<?php

namespace Database\Seeders;

use App\Models\Season;
use App\Models\Student;
use App\Models\TuitionPayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class TuitionPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create("id_ID");

        $students = Student::all();
        $seasons = Season::all();
        $tuition_payments = [];
        foreach ($students as $student) {
            $payment_date = $faker->dateTimeBetween('-3 months', 'now');
            $amount = $faker->numberBetween(5000000, 20000000);
            $receipt_number = 'REC-' . $faker->unique()->numberBetween(1000, 9999);
            $status = $faker->randomElement(['pending', 'paid', 'expired', 'failed']);

            $tuition_payments[] = [
                'payment_at' => $payment_date,
                'amount' => $amount,
                'receipt_number' => $receipt_number,
                'status' => $status,
                'season_id' => $seasons->random()->id,
                'student_id' => $student->id,
            ];
        }

        DB::table('tuition_payments')->insert($tuition_payments);
    }
}
