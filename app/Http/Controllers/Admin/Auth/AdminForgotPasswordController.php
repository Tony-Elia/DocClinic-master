<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;
use App\Doctor;
use App\Admin;
use App\Mail\ForgetPassword;
use App\Mail\AdminForgetPassword;
use Str;
use Mail;
use Hash;
use Auth;
use App\BannerImage;
use App\EmailTemplate;
use App\Helpers\MailHelper;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
class AdminForgotPasswordController extends Controller
{
   public function forgetPassword(){
        $image=BannerImage::first();
        $websiteLang=ManageText::all();
       return view('admin.auth.forget-password',compact('image','websiteLang'));
   }

   public function sendForgetEmail(Request $request){

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            'email'=>'required|email',
        ];

        $customMessages = [
            'email.required' => $valid_lang->where('lang_key','email')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);


        $admin=Admin::where('email',$request->email)->first();
        if($admin){
            $admin->forget_password_token=Str::random(100);
            $admin->save();

            $template=EmailTemplate::where('id',1)->first();
            $message=$template->description;
            $subject=$template->subject;
            $message=str_replace('{{name}}',$admin->name,$message);
            MailHelper::setMailConfig();
            Mail::to($admin->email)->send(new AdminForgetPassword($admin,$message,$subject));
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','forget_pass')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');
            return back()->with($notification);

        }else {
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','invalid_email')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return Redirect()->back()->with($notification);
        }

   }

   public function resetPassword($token){
        $admin=Admin::where('forget_password_token',$token)->first();
        if($admin){
            $image=BannerImage::first();
            $websiteLang=ManageText::all();
            return view('admin.auth.reset-password',compact('admin','token','image','websiteLang'));
        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','invalid_token')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return Redirect()->route('admin.forget.password')->with($notification);
        }
   }


   public function storeResetData(Request $request,$token){

        $valid_lang=ValidationText::all();
        $rules = [
            'email'=>'required',
            'password'=>'required|confirmed|min:3'
        ];

        $customMessages = [
            'email.required' => $valid_lang->where('lang_key','email')->first()->custom_lang,
            'password.required' => $valid_lang->where('lang_key','pass')->first()->custom_lang,
            'password.confirmed' => $valid_lang->where('lang_key','confirm_pass')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);

        $admin=Admin::where('forget_password_token',$token)->first();
        if($admin->email==$request->email){
            $admin->password=Hash::make($request->password);
            $admin->forget_password_token=null;
            $admin->save();

            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','reset_pass')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');
            return Redirect()->route('admin.login')->with($notification);

        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','invalid_email')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return back()->with($notification);
        }
   }


}
