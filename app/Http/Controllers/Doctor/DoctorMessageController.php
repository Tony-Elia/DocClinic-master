<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Appointment;
use App\Message;
use App\User;
use App\BannerImage;
use App\ManageText;
use Auth;
use Pusher\Pusher;
class DoctorMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }
    public function index(){
        $doctor=Auth::guard('doctor')->user();
        $users=Appointment::with('user')->where('doctor_id',$doctor->id)->groupBy('user_id')->select('user_id')->get();
        $profile_image=BannerImage::first();
        $profile_image=$profile_image->default_profile;
        $websiteLang=ManageText::all();
        return view('doctor.message.index',compact('users','profile_image','websiteLang'));
    }

    public function messageBox($id){
        $user=User::find($id);
        $user_id=$user->id;
        $doctor=Auth::guard('doctor')->user();
        $my_id=$doctor->id;
        Message::where(['doctor_id'=>$my_id,'user_id'=>$user_id])->update(['doctor_view'=>1]);

        $messages = Message::where(['doctor_id'=>$my_id,'user_id'=>$user_id])->get();


        $users=Appointment::with('user')->where('doctor_id',$doctor->id)->groupBy('user_id')->select('user_id')->get();
        $profile_image=BannerImage::first();
        $profile_image=$profile_image->default_profile;

        return view('doctor.message.single-message',compact('users','profile_image','messages','user_id'));


    }

    public function getMessage($user_id){

        $doctor=Auth::guard('doctor')->user();
        $my_id=$doctor->id;
        Message::where(['doctor_id'=>$my_id,'user_id'=>$user_id])->update(['doctor_view'=>1]);

        $messages = Message::where(['doctor_id'=>$my_id,'user_id'=>$user_id])->get();
        $websiteLang=ManageText::all();
        return view('doctor.message.message-box',compact('messages','websiteLang'));

    }

    public function sendMessage(Request $request){
        $this->validate($request,[
            'receiver_id'=>'required',
            'message'=>'required'
        ]);


        $doctor=Auth::guard('doctor')->user();
        Message::create([
            'doctor_id'=>$doctor->id,
            'user_id'=>$request->receiver_id,
            'message'=>$request->message,
            'send_doctor'=>$doctor->id
        ]);

       return response()->json(['user_id'=>$request->receiver_id]);

    }
}
