<?php

namespace Database\Seeders;

use App\Enums\StudentStatus;
use App\Models\Season;
use App\Models\Student;
use App\Models\StudentSeasonLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class StudentSeasonLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create("id_ID");
        $seasons = Season::all();
        $totalStudents = 30;
        $chunkSize = 10; // You can adjust the chunk size based on your preference

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $totalStudents * count($seasons));
        $progressBar->setFormat('debug');

        // $progressBar->start();

        // Disable query log during seeding for performance improvement
        DB::disableQueryLog();

        // Start the transaction
        DB::beginTransaction();

        try {
            $studentSeasonRecords = [];
            for ($i = 0; $i < $totalStudents; $i += $chunkSize) {
                $students = Student::limit($chunkSize)->offset($i)->get();
                foreach ($students as $student) {
                    foreach ($seasons as $season) {
                        $status = $this->getRandomStudentStatus();
                        $description = $faker->text;

                        $studentSeasonRecords[] = [
                            'student_id' => $student->id,
                            'season_id' => $season->id,
                            'status' => $status,
                            'description' => $description,
                        ];

                        $progressBar->advance();
                    }
                }
            }
            DB::table('student_season_logs')->insert($studentSeasonRecords);

            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
            throw $e;
        }


        $progressBar->finish();
        $output->writeln("\nSeeding completed!");
    }

    private function getRandomStudentStatus()
    {
        $statuses = [
            StudentStatus::ACTIVE,
            StudentStatus::INACTIVE,
            StudentStatus::GRADUATE,
            StudentStatus::DROPOUT,
        ];

        return $statuses[array_rand($statuses)];
    }
}
