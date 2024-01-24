<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use Auth;
use Illuminate\Support\Arr;

class StaffController extends AdminBaseController
{
    public function index(Request $request)
    {
        if (Auth::user()->is_admin) {
            $data = User::whereHas('roles', function($q){
                $q->where('name', 'Staff');
            })->orderBy('id','DESC')->get();
        } else {
            $data = User::whereHas('roles', function($q){
                $q->where('name', 'Staff');
            })->where('created_by', Auth::id())->orderBy('id','DESC')->get();
        }
        return view('staff.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
         $roles = Role::select(['id', 'name'])->where('name', 'staff')->get();
         $departments = Department::get();
        return view('staff.create',compact('roles','departments'));
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
        return redirect()->route('staff.index')->with('success', 'Staff created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('staff.show',compact('user'));
    }

    public function assign_user(Request $request)
    {
        $user = User::get();
        return response()->json(['success'=>'success','users'=>$user]);
    }

    public function edit($id)
    {
        $data['departments'] = Department::all();
        $data['user'] = User::find($id);
        $data['roles'] = Role::select(['id', 'name'])->where('name', 'staff')->get();
        $data['userRole'] = $data['user']->roles->pluck('name','name')->all();
        return view('staff.edit',$data);
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
        return redirect()->route('staff.index')->with('success','Staff updated successfully');
    }
    
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('staff.index')->with('success','Staff deleted successfully');
    }
   
}
