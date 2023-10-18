<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            'Faculty of Engineering',
            'Faculty of Science',
            'Faculty of Business',
            'Faculty of Medicine',
            'Faculty of Law',
            'Faculty of Social Sciences',
            'Faculty of Education',
            'Faculty of Arts',
            'Faculty of Communication',
            'Faculty of Environmental Studies',
        ];

        foreach ($faculties as $faculty) {
            Faculty::create([
                'name' => $faculty,
            ]);
        }
    }
}
