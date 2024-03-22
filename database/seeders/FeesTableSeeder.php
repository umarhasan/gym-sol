<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;

class FeesTableSeeder extends Seeder
{
    public function run()
    {
        // Fetching user data
        $users = DB::table('users')->select('id', 'name', 'fees')->get();
        
        // Generate 10,000 entries
        $timestamp = Carbon::now()->format('F-H:i');
        for ($i = 0; $i < 10000; $i++) {
            $user = $users->random(); // Randomly select a user from the fetched data
            $string = str_replace(' ', '_', $user->name) . '_' . $timestamp;
            $invoice_url = strtoupper($string);
            
            DB::table('fees')->insert([
                'user_id' => $user->id,
                'amount' => $user->fees,
                'notification_days' => 3,
                'remaining_days' => 3,
                'date' => Carbon::now()->format('Y-m-d'),
                'expiry' => Carbon::now()->format('Y-m-d'),
                'invoice_url' => $invoice_url,
                'club_id' => 1,
            ]);
        }
    }
}
