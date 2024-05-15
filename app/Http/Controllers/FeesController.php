<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Auth;
use DB;

class FeesController extends Controller
{
    // public function create($id)
    // {
    //         $member = User::whereHas('roles', function($q){
    //             $q->where('name', 'Member');
    //         })->where('id', $id)->orderBy('id','DESC')->first();
            
    //         $lastSubscription = DB::table('fees')->where('user_id', $member->id)
    //             ->select(DB::raw('MAX(expiry) as latest_expiration'))
    //             ->whereNull('deleted_at')->first();
                
            
    //         $currentDate = Carbon::now();
            
    //         if (isset($lastSubscription->latest_expiration)) {
    //             $lastExp = $lastSubscription->latest_expiration;
    //             $timeLeft = $currentDate->diffInDays($lastExp);
    //         } else {
    //             $timeLeft = 0;
    //         }
        
    //     return view('fees.create', [
    //         'member' => $member,
    //         'latestSubscription' => $lastSubscription,
    //         'timeLeft' => $timeLeft
    //     ]);
    // }
    
    public function create($id)
        {
            try {
                $userSubscriptions = DB::table('fees')->where('user_id', $id)->whereNull('deleted_at')->paginate(10);
                $member = DB::table('users')->where('id', $id)->first();
                
                $startSubscription = DB::table('fees')->where('user_id', $id)
                    ->select(DB::raw('MAX(date) as start_expiration'))
                    ->first();
                
                $lastSubscription = DB::table('fees')->where('user_id', $id)
                    ->select(DB::raw('MAX(expiry) as latest_expiration'))->whereNull('deleted_at')->first();
                
                $timeLeft = null; // Initialize $timeLeft variable
                
                if ($startSubscription && $lastSubscription) {
                    $currentDate = Carbon::parse($startSubscription->start_expiration);
                    $expired = Carbon::parse($startSubscription->start_expiration)->gte(Carbon::parse($lastSubscription->latest_expiration));
                    
                    if (isset($lastSubscription->latest_expiration)) {
                        $lastExp = $lastSubscription->latest_expiration; 
                        $timeLeft = $currentDate->diffInDays($lastExp);
                    }
                } else {
                    // Handle case where either $startSubscription or $lastSubscription is null
                    // You can provide a default value or an error message
                    dd("Subscription data not found for user $id");
                }
        
                return view('fees.create', [
                    'latestSubscription' => $lastSubscription,
                    'subscriptions' => $userSubscriptions,
                    'member' => $member,
                    'timeLeft' => $timeLeft, // Include the timeLeft variable in the view
                    'expired' => $expired,
                ]);
            } catch (\Exception $e) {
                // Handle any exceptions (e.g., database connection error)
                dd($e->getMessage());
            }
    }

    public function store(Request $request)
    {
        
        $selectedMonths = $request->date;
        $fees = DB::table('fees')->where('user_id', $request->userId)->select(DB::raw('MAX(expiry) as latest_expiration'))->whereNull('deleted_at')->first();
        $latestExpiration = null;

        if ($fees !== null && isset($fees->latest_expiration)) {
            $latestExpiration = Carbon::parse($fees->latest_expiration)->format('Y-m-d');
        }

        // Calculating the expiry date by adding the selected number of months to the latest expiration date
        $expiryDate = null;
        if ($latestExpiration !== null) {
            $expiryDate = Carbon::parse($latestExpiration)->addMonths($selectedMonths)->format('Y-m-d');
        } else {
            // If there's no latest expiration date, default to adding $selectedMonths to the current date
            $expiryDate = Carbon::now()->addMonths($selectedMonths)->format('Y-m-d');
        }

        $string = $request->name . '-' . Carbon::now()->format('F-H:i');
        $invoice_url = strtoupper($string);

        DB::table('fees')->insert([
            'user_id' => $request->userId,
            'amount' => $request->amount,
            'notification_days' => $request->notification_days,
            'remaining_days' => $request->remaining_days,
            'date' => Carbon::now()->format('Y-m-d'),
            'expiry' => $expiryDate,
            'invoice_url' => $invoice_url,
            'club_id' => Auth::user()->club_id,
            'created_by' => Auth::user()->id,

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

        $lastSubscription = DB::table('fees')->where('user_id', $members->id)->select(DB::raw('MAX(expiry) as latest_expiration'))->whereNull('deleted_at')->first();

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
