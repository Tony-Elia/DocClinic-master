<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Appointment;
use App\Doctor;
use App\Setting;
use App\ContactInformation;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
class PrescribeController extends Controller
{
    public function index(){
        $appointments=Appointment::where('already_treated',1)->orderBy('id','desc')->get();
        $doctors=Doctor::where('status',1)->get();
        $websiteLang=ManageText::all();
        $validation=ValidationText::where('lang_key','from_date')->first()->custom_lang;
        return view('admin.prescribe.index',compact('appointments','doctors','websiteLang','validation'));
    }

    public function show($id){
        $appointment=Appointment::find($id);
        $currency=Setting::first();
        $setting=Setting::first();
        $contact=ContactInformation::first();
        $websiteLang=ManageText::all();
        return view('admin.prescribe.show',compact('appointment','currency','setting','contact','websiteLang'));
    }

    public function search(Request $request){
        $from_date=date('Y-m-d',strtotime($request->from_date));
        $to_date=date('Y-m-d',strtotime($request->to_date));
        $appointments=Appointment::where(['already_treated'=>1])->get();
        $appointments=$appointments->whereBetween('date', array($from_date, $to_date));
        if($request->doctor_id) $appointments= $appointments->where('doctor_id',$request->doctor_id);
        $websiteLang=ManageText::all();
        return view('admin.prescribe.ajax-prescribe',compact('appointments','websiteLang'));
    }
}
