<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Subscribe;
use App\SubscriberEmail;
use App\Mail\SendSubscriberMail;
use Mail;
use App\Helpers\MailHelper;



use App\ManageText;
use App\ValidationText;
use App\NotificationText;


class SubscriberController extends Controller
{
    public function index(){
        $subscribers=Subscribe::where('status',1)->get();
        $valid_lang=ValidationText::all();
        $confirm=$valid_lang->where('lang_key','are_you_sure')->first()->custom_lang;
        $websiteLang=ManageText::all();
        return view('admin.subscriber.subscriber.index',compact('subscribers','confirm','websiteLang'));
    }

    public function delete($id){

         // project demo mode check
         if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        Subscribe::destroy($id);
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return back()->with($notification);
    }

    public function emailTemplate(){
        $template=SubscriberEmail::first();
        $websiteLang=ManageText::all();
        return view('admin.subscriber.email.index',compact('template','websiteLang'));
    }

    public function sendMail(Request $request){

         // project demo mode check
         if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
        $valid_lang=ValidationText::all();
        $rules = [
            'subject'=>'required',
            'message'=>'required',
        ];
        $customMessages = [
            'subject.required' => $valid_lang->where('lang_key','subject')->first()->custom_lang,
            'message.required' => $valid_lang->where('lang_key','msg')->first()->custom_lang,
        ];
        $this->validate($request, $rules, $customMessages);




        $template=SubscriberEmail::first();
        $template->subject=$request->subject;
        $template->message=$request->message;

        $subscribers=Subscribe::where('status',1)->get();
        if($subscribers->count()==0){
            $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','something')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'error');

            return back()->with($notification);
        }
        MailHelper::setMailConfig();
        foreach($subscribers as $subscriber){
            Mail::to($subscriber->email)->send(new SendSubscriberMail($template));
        }
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','email_send')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return back()->with($notification);
    }
}
