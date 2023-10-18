<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Classroom;
use App\Models\ClassroomEnrollment;
use App\Models\ClassroomSession;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Room;
use App\Models\Season;
use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ClassroomSeeder1 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totalSeasons = Season::count();
        $totalCourses = Course::count();
        $totalIterations = $totalSeasons * $totalCourses * 10;

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $totalIterations);
        $progressBar->start();

        foreach (Season::all() as $season) {
            foreach (Course::all() as $course) {
                $lecturer = Lecturer::inRandomOrder()->first();
                $room = Room::inRandomOrder()->first();
                $capacity = $room->capacity;
                $classroom = Classroom::create([
                    'name' => $course->code . '-' . $room->name,
                    'capacity' => $capacity,
                    'credits' => $course->credits,
                    'season_id' => $season->id,
                    'course_id' => $course->id,
                ]);

                $students = Student::inRandomOrder()->limit($capacity)->get();

                $classroomEnrollments = [];
                foreach ($students as $student) {
                    $classroomEnrollments[] = [
                        'status' => 'approved',
                        'season_id' => $season->id,
                        'classroom_id' => $classroom->id,
                        'student_id' => $student->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                ClassroomEnrollment::insert($classroomEnrollments);

                $classroomSessions = [];
                for ($i = 1; $i <= 10; $i++) {
                    $classroomSessions[] = [
                        'start_datetime' => now()->addDays($i),
                        'end_datetime' => now()->addDays($i)->addHours(2),
                        'attendance_code' => 'SESSION' . $i . '-' . $classroom->id,
                        'topic' => 'Topic for Session ' . $i,
                        'classroom_id' => $classroom->id,
                        'season_id' => $season->id,
                        'lecturer_id' => $lecturer->id,
                        'room_id' => $room->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $progressBar->advance();
                }
                ClassroomSession::insert($classroomSessions);
                $classroomSessions = ClassroomSession::where('classroom_id', $classroom->id)
                    ->where('season_id', $season->id)
                    ->get();

                $attendances = [];
                foreach ($classroomSessions as $classroomSession) {
                    foreach ($students->random(rand(5, $capacity)) as $student) {
                        $status = rand(0, 1) ? 'present' : 'absent';
                        $attendances[] = [
                            'status' => $status,
                            'student_id' => $student->id,
                            'classroom_session_id' => $classroomSession->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                StudentAttendance::insert($attendances);
            }
        }

        $progressBar->finish();
        $output->writeln("\nSeeding completed!");
    }
}
