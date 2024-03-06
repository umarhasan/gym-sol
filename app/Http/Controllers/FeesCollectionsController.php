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

        $collections = User::join('fees', 'users.id', '=', 'fees.user_id')
        ->select('users.id','users.name', 'users.phone', DB::raw('MAX(fees.expiry) as latest_expiry'))
        ->addSelect(DB::raw('(SELECT amount FROM fees WHERE fees.user_id = users.id ORDER BY id DESC LIMIT 1) AS amount'))
        ->groupBy('users.id')
        ->get();

    
        return view('fees.fees-collections', ['collections' => $collections]);
    }

    public function receivedPayment($phone)
    {
        // Assuming 'fees' is the route name, you can replace it with your actual route name
        return redirect()->route('fees')->with('selectedMember', $phone);
    }
}