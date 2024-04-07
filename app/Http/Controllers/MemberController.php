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
use DB;
use Illuminate\Support\Arr;




class MemberController extends AdminBaseController
{
    public function index(Request $request)
    {
        if (Auth::user()->is_admin) {
            $data = User::with('Fees')->whereHas('roles', function($q){
                $q->where('name', 'Member');
            })->orderBy('id','DESC')->paginate(10);
        } else {
            $data = User::whereHas('roles', function($q){
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
            'email' => 'required|email|unique:users,email'
        ]);

        $setting = Club::first();
        
        if ($setting === null) {
            return redirect()->back()->with('error', 'Failed to create club setting');
        } 

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('12345678');
        $user->phone = $request->phone;
        $user->fees = $request->fees;
        $user->gender = $request->gender;
        $user->club_id = $setting->id;
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
        $fees->date = now();
        $fees->expiry = ($request->fees > 0) ? Carbon::parse($request->expiry) : now();
        $fees->club_id = Auth::user()->id;
        $fees->invoice_url = strtoupper(str_replace(' ', '_', $request->name) . '_' . Carbon::now()->format('F-H:i'));
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
            'department_id' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make('12345678');
        
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole('Member');
        return redirect()->route('member.index')->with('success','User updated successfully');
    }
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('member.index')->with('success','User deleted successfully');
    }

    public function MemberProfile($id)
    {
        $userAttendances = Attendance::where('user_id', $id)->paginate(10);
        $userSubscriptions = Fees::where('user_id', $id)->paginate(10);
        $member = User::where('id', $id)->first();
        $lastSubscription = Fees::where('user_id', $id)->selectRaw('MAX(expiry) as latest_expiration')->first();
        $currentDate = Carbon::now();
        if (isset($lastSubscription->latest_expiration)) {
            $lastExp = $lastSubscription->latest_expiration;
            $timeLeft = $currentDate->diffInDays($lastExp);
        } else {
            $timeLeft = 0;
        }
        return view('member.member_profile', [
            'latestSubscription' => $lastSubscription,
            'subscriptions' => $userSubscriptions,
            'attendances' => $userAttendances,
            'member' => $member,
            'timeLeft' => $timeLeft, // Include the timeLeft variable in the view
        ]);
    }

    public function import(Request $request)
    {
        try {
            // Validate the uploaded file
            $request->validate([
                'file' => 'required|file|mimes:csv,txt'
            ]);

            // Retrieve the uploaded file
            $file = $request->file('file');

            // Read the contents of the file
            $data = array_map('str_getcsv', file($file));

            // Remove the header row if present
            if (count($data) > 0 && isset($data[0])) {
                unset($data[0]);
            }

            // Counter for records imported
            $recordsImported = 0;

            // Iterate over each row and create members
            foreach ($data as $row) {
                // Assuming CSV format: name,email,phone,fees,gender,expiry
                $user = new User();
                $user->name = $row[0];
                $user->email = $row[1];
                $user->password = Hash::make('12345678');
                $user->phone = $row[2];
                $user->fees = $row[3];
                $user->gender = $row[4];
                $user->club_id = Auth::user()->club_id;
                $user->created_by = Auth::user()->id;

                // Save the user
                $user->save();

                // Assign 'Member' role to the user
                $user->assignRole('Member');

                // Create fees record for the user
                $fees = new Fees();
                $fees->user_id = $user->id;
                $fees->amount = $row[3];
                $fees->date = now();
                $fees->expiry = Carbon::parse($row[5]);
                $fees->club_id = Auth::user()->club_id;
                $fees->invoice_url = strtoupper(str_replace(' ', '_', $row[0]) . '_' . Carbon::now()->format('F-H:i'));
                $fees->save();

                // Increment the counter
                $recordsImported++;
            }

            // Log success message
            Log::info('Data imported successfully');

            // Log import history
            $this->logImportHistory(Auth::user()->id, $recordsImported, null);

            // Redirect with success message
            return redirect()->route('member.index')->with('success', 'Data imported successfully');
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Import failed: ' . $e->getMessage());

            // Log import history with error message
            $this->logImportHistory(Auth::user()->id, null, $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('error', 'Data import failed. Please check the log for details.');
        }
    }

    private function logImportHistory($userId, $recordsImported, $errorMessage)
    {
        $importHistory = new ImportHistory();
        $importHistory->user_id = $userId;
        $importHistory->records_imported = $recordsImported;
        $importHistory->error_message = $errorMessage;
        $importHistory->save();
    }

}
