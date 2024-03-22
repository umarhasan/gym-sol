<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;
use Carbon\Carbon;

class ExpensesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10000; $i++) {
            $string = $faker->name . '-' . Carbon::now()->format('F-H:i');
            $invoice_url = strtoupper($string);

            DB::table('expenses')->insert([
                'amount' => $faker->randomFloat(2, 10, 1000), // Generates a random float between 10 and 1000
                'expense_by' => $faker->name,
                'date' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'), // Generates a date within the past year
                'details' => $faker->sentence,
                'paid_to' => $faker->name,
                'club_id' => 1, // Random club
                'invoice_url' => $invoice_url,
            ]);
        }
    }
}
