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
            $data = User::whereHas('roles', function($q){
                $q->where('name', 'Member');
            })->orderBy('id','DESC')->get();
        } else {
            $data = User::whereHas('roles', function($q){
                $q->where('name', 'Member');
            })->where('created_by', Auth::id())->orderBy('id','DESC')->get();
        }
        return view('member.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        //  $roles = Role::select(['id','name'])->get();
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

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['created_by'] = Auth::user()->id;

        // Create the user
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
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
        $data['user'] = User::find($id);
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
