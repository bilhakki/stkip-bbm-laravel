<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Season;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Room;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\ClassroomEnrollment;
use App\Models\ClassroomSession;
use App\Models\StudentAttendance;
use Faker\Core\Number;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;


class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chunk_number = 5000;

        $seasons = Season::all();
        $seasons = collect(json_decode($seasons->toJson()));
        $courses = Course::all();
        $courses = collect(json_decode($courses->toJson()));
        $_students = Student::all();
        $_students = collect(json_decode($_students->toJson()));
        $_lecturers = Lecturer::all();
        $_lecturers = collect(json_decode($_lecturers->toJson()));
        $_rooms = Room::all();
        $_rooms = collect(json_decode($_rooms->toJson()));

        $totalSeasons = count($seasons);
        $totalCourses = count($courses);

        DB::beginTransaction();

        try {
            $_classrooms = [];
            $_data_classrooms = [];


            $output = new ConsoleOutput();
            $progressBar = new ProgressBar($output, $totalSeasons * $totalCourses);
            $progressBar->setFormat('debug');
            $progressBar->start();
            foreach ($seasons as $index_season => $season) {
                foreach ($courses as $index_course => $course) {
                    $room = $_rooms->random();
                    $capacity = $room->capacity;

                    $_data_classrooms[] = [
                        'room' => $room,
                        'students' => $_students->shuffle()->take($capacity),
                        'lecturer' => $_lecturers->random(),
                    ];

                    $_classrooms[] = [
                        'name' => $course->code . '-' . $room->name,
                        'capacity' => $capacity,
                        'credits' => $course->credits,
                        'season_id' => $season->id,
                        'course_id' => $course->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $progressBar->advance();
                }
            }

            DB::table("classrooms")->insert($_classrooms);

            $startID = DB::select('select last_insert_id() as id');
            $startID = $startID[0]->id;
            $lastID = $startID + count($_classrooms) - 1;
            $classroom_ids = range($startID, $lastID);

            $progressBar->finish();

            $_classroom_lecturers = [];
            foreach ($classroom_ids as $index => $classroom_id) {
                $random_number = random_int(0, $_lecturers->count() - 1);
                //
                $_classroom_lecturers[] = [
                    "classroom_id" => $classroom_id,
                    "lecturer_id" => $_lecturers[$random_number % $_lecturers->count()]->id,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
                $_classroom_lecturers[] = [
                    "classroom_id" => $classroom_id,
                    "lecturer_id" => $_lecturers[($random_number + 1) % $_lecturers->count()]->id,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
                if ($_classrooms[$index]['credits'] > 2) {
                    $_classroom_lecturers[] = [
                        "classroom_id" => $classroom_id,
                        "lecturer_id" => $_lecturers[($random_number + 2) % $_lecturers->count()]->id,
                        "created_at" => now(),
                        "updated_at" => now(),
                    ];
                }
            }

            DB::table("classroom_lecturer")->insert($_classroom_lecturers);

            $_classrooms_students = [];
            foreach ($classroom_ids as $index => $classroom_id) {
                foreach ($_data_classrooms[$index]['students'] as $key => $student) {
                    $_classrooms_students[] = [
                        'classroom_id' => $classroom_id,
                        'student_id' => $student->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            foreach (array_chunk($_classrooms_students, 1000) as $key => $__classrooms_students) {
                DB::table('classroom_student')->insert($__classrooms_students);
            }
            $output->writeln("\nClassroom completed!");
            $index = 0;
            $_classroomEnrollments = [];
            $_classroomSessions = [];

            foreach ($seasons as $index_season => $season) {
                foreach ($courses as $index_course => $course) {
                    $_data_classroom = $_data_classrooms[$index];
                    $room = $_data_classroom['room'];
                    $capacity = $_data_classroom['room']->capacity;
                    $students = $_data_classroom['students'];
                    $lecturer = $_data_classroom['lecturer'];

                    foreach ($students as $student) {
                        $_classroomEnrollments[] = [
                            'status' => 'approved',
                            'season_id' => $season->id,
                            'classroom_id' => $classroom_ids[$index],
                            'student_id' => $student->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }


                    for ($i = 1; $i <= 10; $i++) {
                        $_classroomSessions[] = [
                            'start_datetime' => now()->addDays($i),
                            'end_datetime' => now()->addDays($i)->addHours(2),
                            'attendance_code' => 'SESSION-' . $i . '-' . $classroom_ids[$index],
                            'topic' => 'Topic for Session ' . $i,
                            'classroom_id' => $classroom_ids[$index],
                            'season_id' => $season->id,
                            'lecturer_id' => $lecturer->id,
                            'room_id' => $room->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }

            $chunkClassroomEnrollments = array_chunk($_classroomEnrollments, $chunk_number);
            $chunkClassroomSessions = array_chunk($_classroomSessions, $chunk_number);
            $output = new ConsoleOutput();

            $progressBar = new ProgressBar($output, count($chunkClassroomSessions));
            $progressBar->setFormat('debug');
            $progressBar->start();
            foreach ($chunkClassroomEnrollments as $__classroomEnrollments) {
                DB::table("classroom_enrollments")->insert($__classroomEnrollments);
            }

            foreach ($chunkClassroomSessions as $__classroomSessions) {
                DB::table("classroom_sessions")->insert($__classroomSessions);
                $progressBar->advance();
            }

            $progressBar->finish();
            $output->write("\nClassroomSession completed!", true);
            $output->write("Start create StudentAttendance :", true);

            $classroomSessions = ClassroomSession::all();
            $classroomSessions = collect(json_decode(json_encode($classroomSessions->toArray())));

            $index = 0;
            $_studentAttendances = [];

            $output = new ConsoleOutput();
            $progressBar = new ProgressBar($output, $totalSeasons * $totalCourses);
            $progressBar->setFormat('debug');
            $progressBar->start();

            foreach ($seasons as $index_season => $season) {
                foreach ($courses as $index_course => $course) {
                    $_data_classroom = $_data_classrooms[$index];
                    $room = $_data_classroom['room'];
                    $capacity = $_data_classroom['room']->capacity;
                    $students = $_data_classroom['students'];
                    $lecturer = $_data_classroom['lecturer'];

                    $_classroomSessions = $classroomSessions->where('classroom_id', $classroom_ids[$index])->where('season_id', $season->id);

                    foreach ($_classroomSessions as $classroomSession) {
                        foreach ($students->random(rand(5, $capacity)) as $student) {
                            $status = rand(0, 1) ? 'present' : 'absent';
                            $_studentAttendances[] = [
                                'status' => $status,
                                'student_id' => $student->id,
                                'classroom_session_id' => $classroomSession->id,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }
                    $progressBar->advance();

                    $index++;
                }
            }
            $progressBar->finish();
            $output->write("\n" . count($_studentAttendances) . " StudentAttendance created!", true);

            $chunkStudentAttendance = array_chunk($_studentAttendances, $chunk_number);
            $output = new ConsoleOutput();
            $progressBar = new ProgressBar($output, count($chunkStudentAttendance));
            $progressBar->setFormat('debug');
            $progressBar->start();
            foreach ($chunkStudentAttendance as $__studentAttendances) {
                DB::table("student_attendances")->insert($__studentAttendances);
                $progressBar->advance();
            }
            $progressBar->finish();
            $output->write("\nStudentAttendance completed!", true);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // throw $e;
            $output->write("\nSeeding failed: " . $e->getMessage(), true);
        }
    }
}
