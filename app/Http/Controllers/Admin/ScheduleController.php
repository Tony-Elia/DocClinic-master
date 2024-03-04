<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Schedule;
use App\Appointment;
use App\Day;
use App\Doctor;
use Illuminate\Http\Request;


use App\ManageText;
use App\ValidationText;
use App\NotificationText;

class ScheduleController extends Controller
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
        $schedules=Schedule::with('day','doctor')->get();
        $appointments=Appointment::all();
        $websiteLang=ManageText::all();
        return view('admin.schedule.index',compact('schedules','appointments','websiteLang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $days=Day::all();
        $doctors=Doctor::all();
        $websiteLang=ManageText::all();
        return view('admin.schedule.create',compact('days','doctors','websiteLang'));
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
            'doctor'=>'required',
            'day'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'quantity'=>'required',
            'status'=>'required'
        ];
        $customMessages = [
            'doctor.required' => $valid_lang->where('lang_key','doctor')->first()->custom_lang,
            'day.required' => $valid_lang->where('lang_key','day')->first()->custom_lang,
            'start_time.required' => $valid_lang->where('lang_key','start_time')->first()->custom_lang,
            'end_time.required' => $valid_lang->where('lang_key','end_time')->first()->custom_lang,
            'quantity.required' => $valid_lang->where('lang_key','quantity')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);


        Schedule::create([
            'doctor_id'=>$request->doctor,
            'day_id'=>$request->day,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'quantity'=>$request->quantity,
            'status'=>$request->status,
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return back()->with($notification);
    }


    public function edit(Schedule $schedule)
    {
        $days=Day::all();
        $doctors=Doctor::all();
        $websiteLang=ManageText::all();
        return view('admin.schedule.edit',compact('schedule','days','doctors','websiteLang'));
    }


    public function update(Request $request, Schedule $schedule)
    {


        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end



        $valid_lang=ValidationText::all();
        $rules = [
            'doctor'=>'required',
            'day'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'quantity'=>'required',
            'status'=>'required'
        ];
        $customMessages = [
            'doctor.required' => $valid_lang->where('lang_key','doctor')->first()->custom_lang,
            'day.required' => $valid_lang->where('lang_key','day')->first()->custom_lang,
            'start_time.required' => $valid_lang->where('lang_key','start_time')->first()->custom_lang,
            'end_time.required' => $valid_lang->where('lang_key','end_time')->first()->custom_lang,
            'quantity.required' => $valid_lang->where('lang_key','quantity')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);


            $schedule->doctor_id=$request->doctor;
            $schedule->day_id=$request->day;
            $schedule->start_time=$request->start_time;
            $schedule->end_time=$request->end_time;
            $schedule->quantity=$request->quantity;
            $schedule->status=$request->status;
            $schedule->save();

            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.schedule.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {

            // project demo mode check
            if(env('PROJECT_MODE')==0){
                $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
                return redirect()->back()->with($notification);
            }
            // end


        $schedule->delete();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.schedule.index')->with($notification);
    }

     // manage blog status
     public function changeStatus($id){
        $schedule=Schedule::find($id);
        if($schedule->status==1){
            $schedule->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $schedule->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $schedule->save();
        return response()->json($message);

    }
}
