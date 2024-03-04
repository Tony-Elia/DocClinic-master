<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Leave;
use Illuminate\Http\Request;
use Auth;


use App\ManageText;
use App\ValidationText;
use App\NotificationText;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $leaves=Leave::where('doctor_id',Auth::guard('doctor')->user()->id)->get();
        $websiteLang=ManageText::all();
        return view('doctor.leave.index',compact('leaves','websiteLang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            'date'=>'required'
        ];
        $customMessages = [
            'date.required' => $valid_lang->where('lang_key','date')->first()->custom_lang,
        ];
        $this->validate($request, $rules, $customMessages);


        $doctor=Auth::guard('doctor')->user()->id;
        $date= date('Y-m-d',strtotime($request->date)) ;
        $exist=Leave::where(['date'=>$date,'doctor_id'=>$doctor])->count();
        if($exist ==0){
            Leave::create(['date'=>$date,'doctor_id'=>$doctor]);
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');

            return redirect()->route('doctor.leave.index')->with($notification);
        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','something')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');

            return redirect()->route('doctor.leave.index')->with($notification);
        }


    }


    public function update(Request $request, Leave $leave)
    {

            // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
        $valid_lang=ValidationText::all();
        $rules = [
            'date'=>'required'
        ];
        $customMessages = [
            'date.required' => $valid_lang->where('lang_key','date')->first()->custom_lang,
        ];
        $this->validate($request, $rules, $customMessages);



        Leave::where('id',$leave->id)->update(['date'=>$request->date]);
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.leave.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {

            // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
        $leave->delete();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.leave.index')->with($notification);
    }
}
