<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use Validator;
use Auth;

class SettingController extends Controller
{
    public function create(){
        $club = Club::where('user_id',Auth::user()->id)->first();
        return view('settings.create', compact('club'));
    }
   
    public function createOrUpdate(Request $request, $club_id = null)
    {
     
        $request->validate([
            'gym_name'          => 'required|string|max:255',
            'gym_title'         => 'required|string|max:255',
            'city'              => 'required|string|max:255',
            'notification_days' => 'required|string|max:255',
            'location'          => 'required|string|max:255',
            // 'address'           => 'nullable',
            'about'             => 'required|string|max:255',
            'owner_name'        => 'required|string|max:255',
            'owner_phone'       => 'required|string|max:255',
            'manager_name'      => 'required|string|max:255',
            'manager_phone'     => 'required|string|max:255',
            'active_whatsapp_no' => 'required|string|max:255',
            // 'phone'             => 'required|string|max:255',
            'logo'              => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for logo
            'favicon'           => 'image|max:2048', // Add validation for favicon
        ]);

        if ($club_id) {
            $club = Club::find($club_id);
        } else {
            $club = new Club();
        }

            $club->gym_name             = $request->input('gym_name');
            $club->gym_title            = $request->input('gym_title');
            $club->city                 = $request->input('city');
            $club->notification_days    = $request->input('notification_days');
            $club->location             = $request->input('location');
            // $club->address              = $request->input('address');
            $club->about                = $request->input('about');
            $club->owner_name           = $request->input('owner_name');
            $club->owner_phone          = $request->input('owner_phone');
            $club->manager_name         = $request->input('manager_name');
            $club->manager_phone        = $request->input('manager_phone');
            $club->active_whatsapp_no   = $request->input('active_whatsapp_no');
            // $club->phone                = $request->input('phone');
            $club->user_id              = Auth::user()->id;

                // Handle logo upload
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $fileName = $file->getClientOriginalName() . time() . "club." . $file->getClientOriginalExtension();
                    $file->move('uploads/club-logo/', $fileName);
                    $club->logo = $fileName;
                }
                // Handle favicon upload
                if ($request->hasFile('favicon')) {
                    $file = $request->file('favicon');
                    $fileName = $file->getClientOriginalName() . time() . "club." . $file->getClientOriginalExtension();
                    $file->move('uploads/club-favicon/', $fileName);
                    $club->favicon = $fileName;
                }

            $club->save();
        if ($club_id) {
            return redirect()->back()->with('success', 'Club settings updated successfully');
        } else {
            return redirect()->back()->with('success', 'Club settings created successfully');
        }
    }
}
