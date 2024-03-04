<?php

namespace App\Http\Controllers\Doctor\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Admin;
use App\Doctor;
use App\BannerImage;
use Hash;


use App\ManageText;
use App\ValidationText;
use App\NotificationText;

class DoctorLoginController extends Controller
{


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DOCTOR;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:doctor')->except('doctorLogout');
    }


    public function doctorLoginForm(){
        $image=BannerImage::first();
        $websiteLang=ManageText::all();
        return view('doctor.auth.login',compact('image','websiteLang'));
    }

    public function storeLoginInfo(Request $request){
        $valid_lang=ValidationText::all();
        $rules = [
            'email'=>'required|email',
            'password'=>'required',
        ];

        $customMessages = [
            'email.required' => $valid_lang->where('lang_key','email')->first()->custom_lang,
            'password.required' => $valid_lang->where('lang_key','pass')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);



        $credential=[
            'email'=> $request->email,
            'password'=> $request->password
        ];

        $isDoctor=Doctor::where('email',$request->email)->first();
        if($isDoctor){
            if(Hash::check($request->password,$isDoctor->password)){
                if(Auth::guard('doctor')->attempt($credential,$request->remember)){


                    $notify_lang=NotificationText::all();
                    $notification=$notify_lang->where('lang_key','login')->first()->custom_lang;
                    $notification=array('messege'=>$notification,'alert-type'=>'success');
                    return Redirect()->intended(route('doctor.dashboard'))->with($notification);
                }
                $notify_lang=NotificationText::all();
                $notification=$notify_lang->where('lang_key','credential')->first()->custom_lang;
                $notification=array('messege'=>$notification,'alert-type'=>'error');
                return Redirect()->back()->withInput($request->only('email,remember'))->with($notification);
            }else{
                $notify_lang=NotificationText::all();
                $notification=$notify_lang->where('lang_key','credential')->first()->custom_lang;
                $notification=array('messege'=>$notification,'alert-type'=>'error');
                return Redirect()->back()->with($notification);
            }

        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','credential')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return Redirect()->back()->with($notification);
        }



    }

    public function doctorLogout(){
        Auth::guard('doctor')->logout();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','login')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('doctor.login')->with($notification);
    }

}
