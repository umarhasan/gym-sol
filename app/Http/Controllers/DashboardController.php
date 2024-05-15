<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Validator;
use App\Models\User;
use App\Models\Fees;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }


    public function index()
    {
        $userId = Auth::id();
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $monthlyProfitAndLoss = [];
    
    
        
        $isGymAdmin = Auth::user()->hasRole('Gym Admin');
        
        $isGymStaff = Auth::user()->hasRole('Gym Staff');
        $member = Auth::user()->hasRole('Member');
        $isGymCompany = Auth::user()->hasRole('Gym company');
    
    
        // Initialize variables to store statistics
        $totalUsers = 0;
        $totalMembers = 0;
        $totalStaff = 0;
        $totalCompany = 0;
        $totalFees = 0;
        $totalExpenses = 0;
        $profitAndLoss = 0;
        
        // Calculate statistics based on roles
        if ($isGymAdmin) {
            $totalUsers = User::count();
            $totalMembers = User::whereHas('roles', fn($q) => $q->where('name', 'Member'))->count();
            $totalStaff = User::whereHas('roles', fn($q) => $q->where('name', 'Gym Staff'))->count();
            $totalCompany = User::whereHas('roles', fn($q) => $q->where('name', 'Gym company'))->count();
            $totalFees = Fees::sum('amount');
            $totalExpenses = Expense::sum('amount');
            $profitAndLoss = number_format($totalFees - $totalExpenses);
        }
        elseif($isGymCompany){
            
            $totalUsers = User::where('created_by', $userId)->count();
            $totalMembers = User::whereHas('roles', fn($q) => $q->where('name', 'Member'))->where('created_by',$userId)->count();
            $totalStaff = User::whereHas('roles', fn($q) => $q->where('name', 'Gym Staff'))->where('created_by', $userId)->count();
            $totalCompany = User::whereHas('roles', fn($q) => $q->where('name', 'Gym company'))->where('created_by', $userId)->count();
            $totalFees = Fees::where('created_by', $userId)->sum('amount');
            $totalExpenses = Expense::where('created_by', $userId)->sum('amount');
            $profitAndLoss = number_format($totalFees - $totalExpenses);
            
        }        
        elseif ($member) {
            $totalUsers = User::where('created_by', $userId)->count();
            $totalMembers = User::whereHas('roles', fn($q) => $q->where('name', 'Member'))->where('created_by', $userId)->count();
            $totalStaff = User::whereHas('roles', fn($q) => $q->where('name', 'Gym Staff'))->where('created_by', $userId)->count();
            $totalCompany = User::whereHas('roles', fn($q) => $q->where('name', 'Gym company'))->where('created_by', $userId)->count();
            
            $totalFees = Fees::where('created_by', $userId)->sum('amount');
            $totalExpenses = Expense::where('created_by', $userId)->sum('amount');
            $profitAndLoss = number_format($totalFees - $totalExpenses);
        }
        elseif ($isGymStaff) {
            $totalUsers = User::where('created_by', $userId)->count();
            $totalMembers = User::whereHas('roles', fn($q) => $q->where('name', 'Member'))->where('created_by',$userId)->count();
            $totalStaff = User::whereHas('roles', fn($q) => $q->where('name', 'Gym Staff'))->where('created_by', $userId)->count();
            $totalCompany = User::whereHas('roles', fn($q) => $q->where('name', 'Gym company'))->where('created_by', $userId)->count();
            
            $totalFees = Fees::where('created_by', $userId)->sum('amount');
            $totalExpenses = Expense::where('created_by', $userId)->sum('amount');
            $profitAndLoss = number_format($totalFees - $totalExpenses);
        }

    
    
            // // Loop through each month of the current year
            for ($month = 1; $month <= $currentMonth; $month++) {
                // Calculate start and end dates of the month
                $startDate = Carbon::create($currentYear, $month, 1)->startOfMonth();
                
                $endDate = Carbon::create($currentYear, $month, 1)->endOfMonth();
    
                // Calculate profit and loss for the month
                // $fees = Fees::where('user_id', $userId)->sum('amount');
                // $expenses = Expense::where('created_by', $userId)->sum('amount');
                // $profitAndLoss = $fees - $expenses;
    
                // Store profit and loss for the month
                $monthlyProfitAndLoss[$startDate->format('F')] = $profitAndLoss;
            }
            
                    // Generate chart data using the monthly profit and loss array
            $chartData = [
                'labels' => array_keys($monthlyProfitAndLoss),
                'values' => array_values($monthlyProfitAndLoss),
            ];
            
            // dd($profitAndLoss);
    
        // Pass data to the view
        $data = [
            'totalUsers' => $totalUsers,
            'totalMembers' => $totalMembers,
            'totalStaff' => $totalStaff,
            'totalCompany' => $totalCompany,
            'totalFees' => $totalFees,
            'totalExpenses' => $totalExpenses,
            'profitAndLoss' => $profitAndLoss,
        ];
    
        return view('home', compact('data','chartData'));
    }
    
    public function profile()
    {
        return view('profile');
    }
    
    public function update(Request $request)
    {
        $id = Auth::user()->id;
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
        ]);
    
        $input = $request->all();
    
        $user = User::find($id);
        $user->update($input);

        session::flash('success','Record Updated Successfully');
        return redirect()->back();

    }

    public function change_password()
    {
        return view('auth.change-password');
    }
    public function store_change_password(Request $request)
    {
        $user = Auth::user();
        $userPassword = $user->password;

        $validator =Validator::make($request->all(),[
          'oldpassword' => 'required',
          'newpassword' => 'required|same:password_confirmation|min:6',
          'password_confirmation' => 'required',
        ]);

        if(Hash::check($request->oldpassword, $userPassword)) 
        {
            return back()->with(['error'=>'Old password not match']);
        }

        $user->password = Hash::make($request->newpassword);
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");
    }

    public function profileupdate(Request $request){

        // dd($request->all());

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone_number;
        $user->address = $request->address;
        $user->created_by = auth()->user()->id;

        // Check if an image is present in the request
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $fileName = $file->getClientOriginalName() . time() . "Hatch-social." . $file->getClientOriginalExtension();
            $file->move('uploads/user/', $fileName);
            $user->image = $fileName;
        }

        $user->save();

        session::flash('success','Record Updated Successfully');
        return redirect('profile')->with('success','Record Uploaded Successfully');
    }
}
