<?php

namespace Database\Seeders;

use App\Enums\StudentStatus;
use App\Models\Season;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create("id_ID");

        // Generate 5 seasons
        for ($i = 1; $i <= 5; $i++) {
            $name = 2020 + $i . '/' . (2020 + $i) + 1;
            $start_date = $faker->dateTimeBetween('-1 year', '+1 year');
            $end_date = $faker->dateTimeBetween($start_date, '+2 years');

            Season::create([
                'name' => $name,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
        }
    }


}
