<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call(FacultySeeder::class);
        $this->call(MajorSeeder::class);
        // $this->call(CourseSeeder::class);
        $this->call(CoursePrerequisiteSeeder::class);
        $this->call(RoomSeeder::class);
        
        $this->call(UserSeeder::class);
        $this->call(AcademicSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(LecturerSeeder::class);
        
        $this->call(SeasonSeeder::class);
        $this->call(TuitionPaymentSeeder::class);
        $this->call(StudentSeasonLogSeeder::class);

        $this->call(ClassroomSeeder::class);
        // $this->call(ClassroomEnrollmentSeeder::class);
        // $this->call(ClassroomSessionSeeder::class);

        $this->call(StudentGradeSeeder::class);
        // $this->call(StudentAttendanceSeeder::class);
    }
}
