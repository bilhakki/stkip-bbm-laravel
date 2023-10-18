<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 1 Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@adm.campus.com',
            'username' => 'admin@adm.campus.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => UserRole::ADMIN,
        ]);


        // Create 1 Academic University
        // User::create([
        //     'name' => 'Academic University',
        //     'email' => 'academic_university@adm.campus.com',
        //     'username' => 'academic_university@adm.campus.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('12345678'),
        //     'role' => UserRole::ACADEMIC_UNIVERSITY,
        // ]);

        // Create 1 Academic Faculty
        // User::create([
        //     'name' => 'Academic Faculty',
        //     'email' => 'academic_faculty@adm.campus.com',
        //     'username' => 'academic_faculty@adm.campus.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('12345678'),
        //     'role' => UserRole::ACADEMIC_FACULTY,
        // ]);

        // Create 1 Academic Major
        // User::create([
        //     'name' => 'Academic Major',
        //     'email' => 'academic_major@adm.campus.com',
        //     'username' => 'academic_major@adm.campus.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('12345678'),
        //     'role' => UserRole::ACADEMIC_MAJOR,
        // ]);
    }
}
