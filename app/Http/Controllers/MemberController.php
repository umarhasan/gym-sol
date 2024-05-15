<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Fees;
use App\Models\Department;
use App\Models\Club;
use App\Models\ImportHistory;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;


class MemberController extends AdminBaseController
{
        public function index(Request $request)
        {
            if (Auth::user()->is_admin) {
                $data = User::with('Fees')->whereHas('roles', function($q){
                    $q->where('name', 'Member');
                })->orderBy('id','DESC')->paginate(10);
            } else {
                $data = User::with('Fees')->whereHas('roles', function($q){
                    $q->where('name', 'Member');
                })->where('created_by', Auth::id())->orderBy('id','DESC')->paginate(10);
            }
            
            return view('member.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }
        public function create()
        {
            $departments = Department::get();
             $roles = Role::select(['id', 'name'])->where('name', 'member')->get();
            return view('member.create',compact('roles','departments'));
        }
        public function store(Request $request)
        {
           
            $this->validate($request, [
                'name' => 'required',
            ]);
    
            
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->phone . '@gym-sol.com';
            $user->password = Hash::make('12345678');
            $user->phone = $request->phone;
            $user->fees = $request->fees;
            $user->gender = $request->gender;
            $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
            $user->club_id = Auth::user()->id;
            $user->created_by = Auth::user()->id;
    
            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $fileName = $file->getClientOriginalName() . time() . "Hatch-social." . $file->getClientOriginalExtension();
                $file->move('uploads/member/profile/', $fileName);
                $user->profile = $fileName;
            }
    
            $user->save();
    
            $user->assignRole('Member');
            
            $fees = new Fees();
            $fees->user_id = $user->id;
            $fees->amount = $request->fees;
            $fees->date = now()->format('Y-m-d');
            $fees->expiry = ($request->fees > 0) ? Carbon::parse($request->expiry)->format('Y-m-d') : now()->format('Y-m-d');
            $fees->club_id = Auth::user()->id;
            $fees->invoice_url = strtoupper(str_replace(' ', '_', $request->name) . '_' . Carbon::now()->format('F-H:i'));
            $fees->created_by = Auth::user()->id;
            $fees->save();
            
            return redirect()->route('member.index')->with('success', 'User created successfully');
        }
        public function show($id)
        {
            $user = User::find($id);
            return view('member.show',compact('user'));
        }
        public function assign_user(Request $request)
        {
            $user = User::get();
            return response()->json(['success'=>'success','users'=>$user]);
        }
        public function edit($id)
        {
            $data['user'] = User::with('Fees')->find($id);
            $data['roles'] = Role::select(['id', 'name'])->where('name', 'member')->get();
            $data['userRole'] = $data['user']->roles->pluck('name','name')->all();
            return view('member.edit',$data);
        }
        
        public function update(Request $request, $id)
        {
            
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                // Add validation rules for other fields as needed
            ]);
        
            $user = User::findOrFail($id);
        
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->fees = $request->fees;
        
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $fileName = $file->getClientOriginalName() . time() . "Hatch-social." . $file->getClientOriginalExtension();
                $file->move('uploads/member/profile/', $fileName);
                $user->profile = $fileName;
            }
        
            // Update other fields as needed
            $user->created_by = Auth::user()->id;
            $user->save();
        
            // Update fees if necessary
            if ($user->fees > 0) {
                $fees = Fees::where('user_id', $user->id)->whereNull('deleted_at')->first();
                if ($fees) {
                    $fees->amount = $request->fees;
                    $fees->expiry = Carbon::parse($request->expiry)->format('Y-m-d');
                    $fees->save();
                } else {
                    // If fees record doesn't exist, create a new one
                    $fees = new Fees();
                    $fees->user_id = $user->id;
                    $fees->amount = $request->fees;
                    $fees->date = now()->format('Y-m-d');
                    $fees->expiry = Carbon::parse($request->expiry)->format('Y-m-d');
                    $fees->club_id = Auth::user()->id; // or however you want to assign club_id
                    $fees->invoice_url = strtoupper(str_replace(' ', '_', $user->name) . '_' . Carbon::now()->format('F-H:i'));
                    $fees->created_by = Auth::user()->id;
                    $fees->save();
                }
            }
        
            return redirect()->route('member.index')->with('success', 'User updated successfully');
        }
        public function destroy($id)
        {
            User::find($id)->delete();
            return redirect()->route('member.index')->with('success','User deleted successfully');
        }
        public function subscriptionsUpdate(Request $request, $id)
        {
                
            $user = Fees::findOrFail($id);
            $user->date = Carbon::parse($request->start_date)->format('Y-m-d');
            $user->expiry = Carbon::parse($request->expiry_date)->format('Y-m-d');
            $user->amount = $request->amount;
            $user->save();

            return redirect()->back()->with('success','Subscription update successfully');
        
        }
        public function subscriptionsDelete($id)
        {
            Fees::find($id)->delete();
            return redirect()->back()->with('success','Subscription deleted successfully');
        }
        public function MemberProfile($id)
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
        
                return view('member.member_profile', [
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

    public function import(Request $request)
    {
        $errors = [];
        $recordsImported = 0;
        $processedPhoneNumbers = []; // Array to track processed phone numbers
        $processedPhoneNumberFormat = []; // Array to track processed phone numbers
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);
    
        $file = $request->file('file');
        $data = array_map('str_getcsv', file($file));
    
        if (count($data) > 0 && isset($data[0])) {
            unset($data[0]);
        }
    
        foreach ($data as $row) {
            if ($recordsImported >= 500) {
                $errors[] = "Exceeded maximum limit of 500 entries.";
                break;
            }
    
            // Check for duplicate phone numbers
            if (in_array($row[1], $processedPhoneNumbers)) {
                $errors[] = 'Duplicate phone number: ' . $row[1];
                // Log duplicate phone number
                $this->logImportHistory(Auth::user()->id, $recordsImported, 'Duplicate phone number: ' . $row[1]);
                continue;
            }
        
        
            try {
                $user = new User();
                $user->name = $row[0];
                $user->phone = $row[1];
                $user->fees = $row[2];
                $user->gender = $row[3];
                $user->email = $row[1].'@gym-sol.com';
                $user->password = Hash::make('12345678');
                $user->club_id = Auth::user()->id;
                $user->created_by = Auth::user()->id;
                $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
                $user->save();
        
                $user->assignRole('Member');
        
                $fees = new Fees();
                $fees->user_id = $user->id;
                $fees->amount = $row[2];
                $fees->date = now()->format('Y-m-d');
                $fees->expiry = Carbon::parse($row[4])->format('Y-m-d');
                $fees->club_id = Auth::user()->club_id;
                $fees->invoice_url = strtoupper(str_replace(' ', '_', $row[0]) . '_' . Carbon::now()->format('F-H:i'));
                $fees->created_by = Auth::user()->id;
                $fees->save();
        
                $recordsImported++;
                $processedPhoneNumbers[] = $row[1]; // Add phone number to processed array
            } catch (\Exception $e) {
                // Log the error
                Log::error('Error importing user: ' . $e->getMessage());
                // Extract phone number from the exception message
                preg_match('/\d{12}/', $e->getMessage(), $matches);
                // Add only phone number related error message to the errors array
                if (!empty($matches)) {
                    $errors[] = 'Duplicate phone number: ' . $matches[0];
                }
                continue;
            }
        }
    
        // If there are errors, log them and return with error message
        if (!empty($errors)) {
            Log::error('Import failed: ' . implode(', ', $errors));
            $this->logImportHistory(Auth::user()->id, $recordsImported, implode(', ', $errors));
            return redirect()->back()->with('error', 'Data import failed. Please check the log for details.');
        }
    
        // If no errors, log success and return with success message
        Log::info('Data imported successfully');
        $this->logImportHistory(Auth::user()->id, $recordsImported, null);
        return redirect()->route('member.index')->with('success', 'Data imported successfully');
    }

        private function logImportHistory($userId, $recordsImported, $errorMessage)
        {
            $importHistory = new ImportHistory();
            $importHistory->user_id = $userId;
            $importHistory->records_imported = $recordsImported;
            $importHistory->error_message = $errorMessage;
            $importHistory->save();
        }
        
        public function downloadSample()
        {
            // Path to the CSV file
            $filePath = public_path('all-member.csv');
        
            // Check if the file exists
            if (file_exists($filePath)) {
                // Set headers for CSV download
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="all-member.csv"');
        
                // Read the file and output its contents
                readfile($filePath);
                exit;
            } else {
                // File not found response
                return response()->json(['error' => 'File not found.'], 404);
            }
    }
}
