<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Setting;
use App\ManageText;
use App\Navigation;
use App\BannerImage;
use App\EmailTemplate;
use App\Rules\Captcha;
use App\ValidationText;
use App\NotificationText;
use App\Helpers\MailHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\UserVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{


    use RegistersUsers;


    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest:web');
    }


    public function userRegisterPage(){
        $setting=Setting::first();
        $banner=BannerImage::first();
        $navigation=Navigation::first();
        $websiteLang=ManageText::all();
        return view('patient.profile.auth.register')->with(['setting'=>$setting,'banner'=>$banner,'navigation'=>$navigation,'websiteLang'=>$websiteLang]);
    }

    public function storeRegister(Request $request){
            // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            'name'=>'required',
            'email'=>'required|unique:users|email',
            'password'=>'required|min:3',
            'g-recaptcha-response'=>new Captcha()
        ];

        $customMessages = [
            'name.required' => $valid_lang->where('lang_key','name')->first()->custom_lang,
            'email.required' => $valid_lang->where('lang_key','email')->first()->custom_lang,
            'email.unique' => $valid_lang->where('lang_key','unique_email')->first()->custom_lang,
            'password.required' => $valid_lang->where('lang_key','pass')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'patient_id'=>date('ymdis'),
            'email_verified_token'=>Str::random(100)
        ]);

        $template=EmailTemplate::where('id',5)->first();
        $message=$template->description;
        $subject=$template->subject;
        $message=str_replace('{{user_name}}',$user->name,$message);
        MailHelper::setMailConfig();
        Mail::to($user->email)->send(new UserVerification($user,$message,$subject));

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','register')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return Redirect()->back()->with($notification);
    }

    public function userVerify($token){
        $user=User::where('email_verified_token',$token)->first();
        $notify=NotificationText::first();
        if($user){
            $user->email_verified_token=null;
            $user->status=1;
            $user->email_verified=1;
            $user->save();
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','verify')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');
            return  redirect()->route('login')->with($notification);
        }else{

            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','invalid_token')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('register')->with($notification);
        }
    }
}
