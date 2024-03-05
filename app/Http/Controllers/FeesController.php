<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Auth;
use DB;

class FeesController extends Controller
{
    public function create($id)
    {
    

            $members = User::whereHas('roles', function($q){
                $q->where('name', 'Member');
            })->where('id', $id)->orderBy('id','DESC')->first();

            $lastSubscription = DB::table('fees')->where('user_id', $members->id)
                ->select(DB::raw('MAX(expiry) as latest_expiration'))
                ->first();
            
            $currentDate = Carbon::now();

            if (isset($lastSubscription->latest_expiration)) {
                $lastExp = $lastSubscription->latest_expiration;
                $timeLeft = $currentDate->diffInDays($lastExp);
            } else {
                $timeLeft = 0;
            }
        
        return view('fees.create', [
            'member' => $members,
            'latestSubscription' => $lastSubscription,
            'timeLeft' => $timeLeft
        ]);
    }

    public function takeFee(Request $request)
    {
        $string = $request->name . '-' . Carbon::now()->format('F-H:i');
        $invoice_url = strtoupper($string);

        DB::table('fees')->insert([
            'user_id' => $request->userId,
            'amount' => $request->amount,
            'notification_days' => $request->notification_days,
            'remaining_days' => $request->remaining_days,
            'date' => Carbon::now()->format('Y-m-d'),
            'expiry' => $request->date,
            'invoice_url' => $invoice_url,
            'club_id' => $request->club_id,
        ]);

        return redirect()->route('member.invoice', ['invoice_url' => $invoice_url]);
    }

    public function fillTheFields(Request $request)
    {
        $members = DB::table('users')->when($request->search, function ($query, $search) {
            return $query->where('name', 'Like', '%' . $search . '%')->orWhere('phone', 'Like', '%' . $search . '%')->orWhere('email', 'Like', '%' . $search . '%');
        })->where('club_id', auth()->user()->club_id)->first();

        $fees = DB::table('fees')->where('user_id', $members->id)->orderBy('id', 'Desc')->first();
        $name = $members->name ?? '';
        $phone = $members->phone ?? '';
        $notification_days = $fees->notification_days ?? '';
        $remaining_days = $fees->remaining_days ?? '';
        $amount = $members->fees ?? '';
        $image = $members->image ?? '';
        $club_id = $members->club_id ?? '';
        $userId = $members->id ?? 0;

        $lastSubscription = DB::table('fees')->where('user_id', $members->id)->select(DB::raw('MAX(expiry) as latest_expiration'))->first();

        if (isset($lastSubscription->latest_expiration)) {
            $currentDate = Carbon::parse($lastSubscription->latest_expiration);
            $date = $currentDate->addMonth()->format('Y-m-d');
        } else {
            $currentDate = Carbon::now();
            $date = $currentDate->addMonth()->format('Y-m-d');
        }

        return compact('name', 'phone', 'notification_days', 'remaining_days', 'amount', 'image', 'club_id', 'userId', 'date');
    }
}
