<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Fees;
use App\Models\Department;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use DB;
use Hash;
use Auth;
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->dob = $request->dob;
        $user->fees = $request->fees;
        $user->gender = $request->gender;
        $user->club_id = Auth::user()->id;
        $user->created_by = Auth::user()->id;

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $fileName = $file->getClientOriginalName() . time() . "Hatch-social." . $file->getClientOriginalExtension();
            $file->move('uploads/member/profile/', $fileName);
            $user->profile = $fileName;
        }

        $user->save();

        $user->assignRole($request->input('roles'));
        
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
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('member.index')
                        ->with('success','User updated successfully');
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

}
