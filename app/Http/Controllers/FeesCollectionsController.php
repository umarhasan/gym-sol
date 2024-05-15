<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Fees;
use Carbon\Carbon;
use DB;

class FeesCollectionsController extends AdminBaseController
{
        public function FeesCollections()
        {
            $collections = User::role('Member') // Assuming you're using Laravel's Spatie permission package
                ->with(['fees' => function ($query) {
                    $query->latest()->select('amount', 'expiry');
                }])
                ->select('users.id', 'users.name', 'users.phone')
                ->addSelect(DB::raw('(SELECT MAX(f.expiry) FROM fees f WHERE f.user_id = users.id) AS latest_expiry'))
                ->addSelect(DB::raw('(SELECT f.amount FROM fees f WHERE f.user_id = users.id ORDER BY f.created_at DESC LIMIT 1) AS latest_amount'))
                ->orderBy('id','desc')
                ->paginate(10);
        
            return view('fees.fees-collections', compact('collections'));
        }

    public function receivedPayment($phone)
    {
        // Assuming 'fees' is the route name, you can replace it with your actual route name
        return redirect()->route('fees')->with('selectedMember', $phone);
    }
}