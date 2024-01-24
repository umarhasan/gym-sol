<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Validator;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Session;

class DashboardController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    
    public function index()
    {
        // return Auth::user();
        $data['users'] = User::all()->count();
        return view('home',$data);
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
