<?php

namespace App\Http\Controllers\Admin;

use App\ContactUs;
use App\ContactMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ManageText;
use App\ValidationText;
use App\NotificationText;
class ContactUsController extends Controller
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
        $contact=ContactUs::first();
        $websiteLang=ManageText::all();
        if($contact){
            return view('admin.contact.contact-us.edit',compact('contact','websiteLang'));
        }

    }





    public function update(Request $request, $id)
    {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array(
                'messege'=>env('NOTIFY_TEXT'),
                'alert-type'=>'error'
            );
            return redirect()->back()->with($notification);
        }
        // end

        ContactUs::where('id',$id)->update([
            'email'=>$request->email,
            'phone'=>$request->phone,
            'facebook'=>$request->facebook,
            'twitter'=>$request->twitter,
            'pinterest'=>$request->pinterest,
            'linkedin'=>$request->linkedin,
            'youtube'=>$request->youtube
        ]);


        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.contact-us.index')->with($notification);
    }



    public function message(){
        $messages=ContactMessage::orderBy('id','desc')->get();
        $websiteLang=ManageText::all();
        return view('admin.contact.contact-message.index',compact('messages','websiteLang'));
    }
}
