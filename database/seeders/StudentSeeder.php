<?php

namespace Database\Seeders;

use App\Enums\StudentStatus;
use App\Enums\UserRole;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create("id_ID");
        $studentRole = UserRole::STUDENT;
        // $faculty_ids = Faculty::pluck('id')->toArray();
        // $major_ids = Major::pluck('id')->toArray();
        $faculties = Faculty::with(['majors'])->get();

        // if (empty($major_ids)) {
        //     throw new Exception('No major records found. Please seed majors table first.');
        // }

        $totalStudents = 60; // Total number of students to be created
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $totalStudents);
        $progressBar->setFormat('debug');

        // Disable query log during seeding for performance improvement
        DB::disableQueryLog();
        // Start the transaction
        DB::beginTransaction();

        try {
            $userRecords = [];
            $studentRecords = [];

            for ($index = 1; $index <= $totalStudents; $index++) {
                $name = $faker->unique()->name;
                if ($index === 1) {
                    $name = 'Mahasiswa';
                }

                $email = strtolower(str_replace('.', '', str_replace(' ', '', $name))) . '@stu.campus.com';

                // Ensure the email is unique
                while (User::where('email', $email)->exists()) {
                    $name = $faker->unique()->name;
                    $email = strtolower(str_replace('.', '', str_replace(' ', '', $name))) . '@stu.campus.com';
                }

                $user = [
                    'name' => $name,
                    'email' => $email,
                    'username' => $faker->unique()->numberBetween(300000, 600000),
                    'email_verified_at' => now(),
                    'password' => Hash::make('12345678'),
                    'role' => $studentRole,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Push user data to the array
                $userRecords[] = $user;

                // Advance the progress bar
                $progressBar->advance();
            }

            // Bulk insert users
            DB::table("users")->insert($userRecords);

            // Get user IDs and associate with student data
            $users = User::select('id', 'email')->whereIn('email', array_column($userRecords, 'email'))->get();
            foreach ($users as $user) {
                $index = array_search($user->email, array_column($userRecords, 'email'));
                $faculty = $faculties->random();
                $studentRecord = [
                    'user_id' => $user->id,
                    'faculty_id' => (int) $faculty->id,
                    'major_id' => (int)  $faculty->majors->random()->id,
                    'current_credits' => $faker->numberBetween(0, 150),
                    'admission_year' => $faker->numberBetween(now()->year - 10, now()->year),
                    'date_of_birth' => $faker->date(),
                    'gender' => $faker->randomElement(['male', 'female', 'male', 'female', 'other']), // Adjust occurrence frequency of 'other'
                    'status' => $faker->randomElement(StudentStatus::values()),
                    'address' => $faker->address,
                    'phone_number' => $faker->phoneNumber,
                    'guardian_name' => $faker->name,
                    'guardian_phone_number' => $faker->phoneNumber,
                    'blood_type' => $faker->randomElement(['A+', 'B+', 'AB+', 'O+', 'A-', 'B-', 'AB-', 'O-']),
                    'tuition_fee' => $faker->numberBetween(1000000, 5000000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Push student data to the array
                $studentRecords[] = $studentRecord;
            }

            // Bulk insert students
            DB::table('students')->insert($studentRecords);

            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
            throw $e;
        }

        $progressBar->finish();
        $output->writeln('');
    }
}
