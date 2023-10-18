<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Academic;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create("id_ID");
        $faculties = Faculty::all();
        $faculties = collect(json_decode($faculties->toJson()));
        $majors = Major::all();
        $majors = collect(json_decode($majors->toJson()));
        $university_academic_total = 5;
        $academic_per_faculty = 4;
        $faculty_academic_total = count($faculties) * $academic_per_faculty;
        $academic_per_major = 3;
        $major_academic_total = count($majors) * $academic_per_major;
        $users_total = $university_academic_total + $faculty_academic_total + $major_academic_total;

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, $users_total);
        $progressBar->setFormat('debug');
        $progressBar->start();

        $_users = [];

        // buat akademik universitas
        for ($i = 1; $i <= $users_total; $i++) {
            $name = $faker->unique()->name;
            $email = strtolower(str_replace('.', '', str_replace(' ', '', $name))) . '@stu.campus.com';
            $role = null;
            if ($i <= $university_academic_total) {
                $role = UserRole::ACADEMIC_UNIVERSITY;
            } else if ($i <= $university_academic_total + $faculty_academic_total) {
                $role = UserRole::ACADEMIC_FACULTY;
            } else {
                $role = UserRole::ACADEMIC_MAJOR;
            }
            $time = time();

            $_user = [
                'name' => $name,
                'email' => $email,
                'username' => "$time$i",
                'password' => Hash::make('12345678'),
                'role' => $role
            ];

            $_users[] = $_user;
        }

        DB::table("users")->insert($_users);
        $startID = DB::select('select last_insert_id() as id');
        $startID = $startID[0]->id;
        $lastID = $startID + count($_users) - 1;
        $user_ids = range($startID, $lastID);


        $faculty_count = 0;
        $major_count = 0;
        $index = 1;
        $index_faculty = 1;
        $index_major = 1;

        try {
            $_academics = [];
            foreach ($user_ids as $user_id) {
                if ($index <= $university_academic_total) {
                    $_academics[] = [
                        'user_id' => $user_id,
                        'academicable_type' => null,
                        'academicable_id' => null,
                        "created_at" => now(),
                        "updated_at" => now(),
                    ];
                } else if ($index <= $university_academic_total + $faculty_academic_total) {
                    $faculty = $faculties[$faculty_count];
                    $_academics[] = [
                        'user_id' => $user_id,
                        'academicable_type' => 'App\Models\Faculty',
                        'academicable_id' => $faculty->id,
                        "created_at" => now(),
                        "updated_at" => now(),
                    ];
                    if ($index_faculty % $academic_per_faculty == 0) {
                        $faculty_count++;
                    }
                    $index_faculty++;
                } else {
                    $major = $majors[$major_count];

                    $_academics[] = [
                        'user_id' => $user_id,
                        'academicable_type' => 'App\Models\Major',
                        'academicable_id' => $major->id,
                        "created_at" => now(),
                        "updated_at" => now(),
                    ];

                    if ($index_major % $academic_per_major == 0) {
                        $major_count++;
                    }
                    $index_major++;
                }
                $index++;
                $progressBar->advance();
            }

            foreach (array_chunk($_academics, 1000) as $key => $__academics) {
                DB::table('academics')->insert($__academics);
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            dd([
                'index' => $index,
                'faculty_count' => $faculty_count,
                'major_count' => $major_count,
                'error' => $th,
            ]);
        }

        $progressBar->finish();
        $output->writeln('');
    }
}
