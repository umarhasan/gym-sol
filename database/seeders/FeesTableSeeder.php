<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;
use Auth;
class FeesTableSeeder extends Seeder
{
    public function run()
    {
        // Generate 100 user entries using the factory
        $userIds = DB::table('users')->pluck('id');
        $name = DB::table('users')->pluck('name');
        
        $fees = DB::table('users')->pluck('fees');
        $string = str_replace(' ', '_', $name).'_'.Carbon::now()->format('F-H:i');
        $invoice_url = strtoupper($string);
        foreach ($userIds as $userId) {
            DB::table('fees')->insert([
                'user_id' => $userId,
                'amount' => $fees,
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