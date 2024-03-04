<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Appointment;
use App\Setting;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
class AdminAppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function pendingAppointment(){
        $appointments=Appointment::where('payment_status',0)->get();
        $websiteLang=ManageText::all();
        return view('admin.appointment.pending',compact('appointments','websiteLang'));
    }

    public function newAppointment(){
        $appointments=Appointment::where(['payment_status'=>1,'already_treated'=>0])->orderBy('id','desc')->get();
        $websiteLang=ManageText::all();
        return view('admin.appointment.new',compact('appointments','websiteLang'));
    }

    public function allAppointment(){
        $appointments=Appointment::orderBy('id','desc')->get();
        $websiteLang=ManageText::all();
        return view('admin.appointment.all',compact('appointments','websiteLang'));
    }



    public function show($id){
        $appointment=Appointment::find($id);
        $currency=Setting::first();
        $websiteLang=ManageText::all();
        return view('admin.appointment.show',compact('appointment','currency','websiteLang'));
    }

    public function approvedPayment($id){

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array(
                'messege'=>env('NOTIFY_TEXT'),
                'alert-type'=>'error'
            );
            return redirect()->back()->with($notification);
        }
        // end

        Appointment::where('id',$id)->update(['payment_status'=>1]);
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','payment_approved')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return back()->with($notification);
    }
}
