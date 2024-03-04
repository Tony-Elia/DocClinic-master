<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Location;
use App\Doctor;
use Illuminate\Http\Request;


use App\ManageText;
use App\ValidationText;
use App\NotificationText;


class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $locations=Location::all();
        $doctors=Doctor::all();
        $websiteLang=ManageText::all();
        return view('admin.location.index',compact('locations','doctors','websiteLang'));
    }

    public function store(Request $request)
    {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end


        $valid_lang=ValidationText::all();
        $rules = [
            'location'=>'required|unique:locations',
            'status'=>'required'
        ];
        $customMessages = [
            'location.required' => $valid_lang->where('lang_key','location')->first()->custom_lang,
            'location.unique' => $valid_lang->where('lang_key','unique_location')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);



        Location::create([
            'location'=>$request->location,
            'status'=>$request->status,
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.location.index')->with($notification);
    }


    public function update(Request $request, Location $location)
    {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            'location'=>'required|unique:locations,location,'.$location->id,
            'status'=>'required'
        ];
        $customMessages = [
            'location.required' => $valid_lang->where('lang_key','location')->first()->custom_lang,
            'location.unique' => $valid_lang->where('lang_key','unique_location')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);


        $location->location=$request->location;
        $location->status=$request->status;
        $location->save();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.location.index')->with($notification);
    }


    public function destroy(Location $location)
    {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $location->delete();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.location.index')->with($notification);
    }



    public function changeStatus($id){
        $location=Location::find($id);
        if($location->status==1){
            $location->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $location->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $location->save();
        return response()->json($message);

    }
}
