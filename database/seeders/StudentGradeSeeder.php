<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class StudentGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create("id_ID");
        $classrooms = Classroom::with(["students:id"])->get([
            'id',
            'course_id',
            'season_id',
        ]);

        $classrooms = collect(json_decode($classrooms->toJson()));
        DB::beginTransaction();

        $output = new ConsoleOutput();
        $progressBarCount = $classrooms->sum(function ($classroom) {
            return count($classroom->students);
        });
        $progressBar = new ProgressBar($output, $progressBarCount);
        $progressBar->setFormat('debug');
        try {
            $_studentGrades = [];
            foreach ($classrooms as $classroom) {
                foreach ($classroom->students as $key => $student) {
                    $_studentGrades[] = [
                        "grade" => $faker->randomElement([1, 1.5, 2, 2.5, 3, 3.5, 4]),
                        "user_id" => 1,
                        "student_id" => $student->id,
                        "course_id" => $classroom->course_id,
                        "season_id" => $classroom->season_id,
                        "classroom_id" => $classroom->id
                    ];
                    $progressBar->advance();
                }
            }

            foreach (array_chunk($_studentGrades, 5000) as $key => $value) {
                DB::table('student_grades')->insert($value);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
