<?php

namespace App\Http\Controllers\Admin;

use App\Day;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ManageText;
use App\ValidationText;
use App\NotificationText;
class DayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $days=Day::all();
        $websiteLang=ManageText::all();
        return view('admin.day.index',compact('days','websiteLang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, Day $day)
    {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array(
            'messege'=>env('NOTIFY_TEXT'),
            'alert-type'=>'error'
            );

        return redirect()->back()->with($notification);
        }
        // end



        $valid_lang=ValidationText::all();
        $rules = [
            'custom_day'=>'required'
        ];

        $customMessages = [
            'custom_day.required' => $valid_lang->where('lang_key','custom_day')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);

        $day->custom_day=$request->custom_day;
        $day->save();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.day.index')->with($notification);
    }


}
