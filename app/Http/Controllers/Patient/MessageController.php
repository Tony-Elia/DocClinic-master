<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Appointment;
use App\BannerImage;
use App\Message;
use Auth;
use Pusher\Pusher;
use App\ManageText;
use App\Navigation;
use App\Doctor;
class MessageController extends Controller
{
    public function index(){
        $user=Auth::guard('web')->user();
        $doctors=Appointment::with('doctor')->where('user_id',$user->id)->groupBy('doctor_id')->select('doctor_id')->get();
        $banner=BannerImage::first();
        $navigation=Navigation::first();
        $websiteLang=ManageText::all();
        return view('patient.profile.message.index',compact('user','doctors','banner','navigation','websiteLang'));
    }

    public function messageBox($slug){
        $doctor=Doctor::where('slug',$slug)->first();
        $doctor_id=$doctor->id;
        $user=Auth::guard('web')->user();
        Message::where(['user_id'=>$user->id,'doctor_id'=>$doctor_id])->update(['user_view'=>1]);
        $messages = Message::where(['user_id'=>$user->id,'doctor_id'=>$doctor_id])->get();


        $doctors=Appointment::with('doctor')->where('user_id',$user->id)->groupBy('doctor_id')->select('doctor_id')->get();
        $banner=BannerImage::first();
        $navigation=Navigation::first();
        $websiteLang=ManageText::all();

        return view('patient.profile.message.single-message',compact('messages','doctors','banner','navigation','websiteLang','user','doctor_id'));
    }

    public function getMessage($doctor_id){
        $user=Auth::guard('web')->user();
        $my_id=$user->id;
        Message::where(['user_id'=>$user->id,'doctor_id'=>$doctor_id])->update(['user_view'=>1]);
        $messages = Message::where(['user_id'=>$user->id,'doctor_id'=>$doctor_id])->get();
        $websiteLang=ManageText::all();
        return view('patient.profile.message.message-box',compact('messages','websiteLang'));
    }

    public function sendMessage(Request $request){
        $this->validate($request,[
            'receiver_id'=>'required',
            'message'=>'required'
        ]);

        $user=Auth::guard('web')->user();
        Message::create([
            'user_id'=>$user->id,
            'doctor_id'=>$request->receiver_id,
            'message'=>$request->message,
            'send_user'=>$user->id
        ]);

        return response()->json(['doctor_id'=>$request->receiver_id]);
    }
}
