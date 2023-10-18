<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create("id_ID");
        $lecturerRole = UserRole::LECTURER;

        DB::beginTransaction();
        try {
            $_users = [];
            $_lecturers = [];
            for ($i = 1; $i <= 20; $i++) {
                $name = $faker->unique()->name;
                $email = strtolower(str_replace('.', '', str_replace(' ', '', $name))) . '@lec.campus.com';

                $_users[] = [
                    'name' =>  $name,
                    'email' => $email,
                    'username' => $faker->unique()->numberBetween(100000, 300000),
                    'email_verified_at' => now(),
                    'password' => Hash::make('12345678'),
                    'role' => $lecturerRole,
                ];

                $_lecturers[] = [
                    // 'user_id' => $user->id,
                    'position' => $faker->randomElement(['Assistant Lecturer', 'Lecturer', 'Senior Lecturer']),
                    'specialization' => $faker->jobTitle,
                    'phone_number' => $faker->phoneNumber,
                    'status' => $faker->randomElement(['active', 'inactive', 'active', 'active', 'active', 'active']),
                ];
            }
            DB::table('users')->insert($_users);
            $startID = DB::select('select last_insert_id() as id');
            $startID = $startID[0]->id;
            $lastID = $startID + count($_users) - 1;
            $user_ids = range($startID, $lastID);

            foreach ($user_ids as $key => $user_id) {
                $_lecturers[$key]['user_id'] = $user_id;
            }

            DB::table('lecturers')->insert($_lecturers);
            $startID = DB::select('select last_insert_id() as id');
            $startID = $startID[0]->id;
            $lastID = $startID + count($_lecturers) - 1;
            $lecturer_ids = range($startID, $lastID);

            $students = Student::all();
            $students = collect(json_decode($students->toJson()));

            $_academic_advisors = [];
            foreach ($students as $key => $student) {
                $_academic_advisors[] = [
                    'student_id' => $student->id,
                    'lecturer_id' => $lecturer_ids[array_rand($lecturer_ids, 1)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('academic_advisors')->insert($_academic_advisors);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
