<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CoursePrerequisite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursePrerequisiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $courses = Course::all();
        $courses = collect(json_decode($courses->toJson()));

        $_course_prerequisites = [];

        DB::beginTransaction();
        try {
            foreach ($courses as $course) {
                $prerequisiteCourse = $courses->whereNotIn('id', [$course->id])->random();
                $_course_prerequisites[] = [
                    'course_id' => $course->id,
                    'prerequisite_course_id' => $prerequisiteCourse->id,
                ];
            }
            
            DB::table('course_prerequisites')->insert($_course_prerequisites);


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
