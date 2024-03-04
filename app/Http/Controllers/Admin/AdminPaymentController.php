<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Appointment;
use App\Doctor;
use Carbon\Carbon;
use App\Setting;


use App\ManageText;
use App\ValidationText;
use App\NotificationText;
class AdminPaymentController extends Controller
{
    public function payment(){
        $appointments=Appointment::where([
            'payment_status'=>1
        ])->get();
        $doctors=Doctor::where('status',1)->get();
        $currency=Setting::first();

        $doctorPayments=Doctor::with('appointments')->where(['status'=>1])->get();

        $doctorPayments=Appointment::where('payment_status',1)->get();


        $websiteLang=ManageText::all();
        return view('admin.payment.index',compact('appointments','doctors','currency','doctorPayments','websiteLang'));
    }

    public function paymentSearch(Request $request){
        $this->validate($request,[
            'from_date'=>'required',
            'to_date'=>'required',
        ]);

        $doctors=Doctor::where('status',1)->get();
        $appointments=Appointment::where([
            'payment_status'=>1
        ])->get();

        $from_date=date('Y-m-d',strtotime($request->from_date));
        $to_date=date('Y-m-d',strtotime($request->to_date));

        $appointments=$appointments->whereBetween('date', array($from_date, $to_date));
        if($request->doctor_id) $appointments= $appointments->where('doctor_id',$request->doctor_id);
        $currency=Setting::first();
        $websiteLang=ManageText::all();

        return view('admin.payment.ajax-payment',compact('appointments','currency','doctors','websiteLang'));


    }
}
