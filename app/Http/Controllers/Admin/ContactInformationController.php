<?php

namespace App\Http\Controllers\Admin;

use App\ContactInformation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
class ContactInformationController extends Controller
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
        $contact=ContactInformation::first();
        $websiteLang=ManageText::all();
        if($contact){
            return view('admin.contact.contact-information.edit',compact('contact','websiteLang'));
        }{
            return view('admin.contact.contact-information.create');
        }
    }




    public function update(Request $request, ContactInformation $contactInformation)
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


        $valid_lang=ValidationText::all();
        $rules = [
            'header'=>'required',
            'address'=>'required',
            'description'=>'required',
            'about'=>'required',
            'phones'=>'required',
            'emails'=>'required',
            'map_embed_code'=>'required',
            'copyright'=>'required',
        ];

        $customMessages = [
            'header.required' => $valid_lang->where('lang_key','header')->first()->custom_lang,
            'address.required' => $valid_lang->where('lang_key','address')->first()->custom_lang,
            'description.required' => $valid_lang->where('lang_key','des')->first()->custom_lang,
            'about.required' => $valid_lang->where('lang_key','about')->first()->custom_lang,
            'phones.required' => $valid_lang->where('lang_key','phone')->first()->custom_lang,
            'emails.required' => $valid_lang->where('lang_key','email')->first()->custom_lang,
            'map_embed_code.required' => $valid_lang->where('lang_key','google_map')->first()->custom_lang,
            'copyright.required' => $valid_lang->where('lang_key','copyright')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);

        ContactInformation::where('id',$contactInformation->id)->update([
            'header'=>$request->header,
            'address'=>$request->address,
            'description'=>$request->description,
            'about'=>$request->about,
            'phones'=>$request->phones,
            'emails'=>$request->emails,
            'map_embed_code'=>$request->map_embed_code,
            'copyright'=>$request->copyright,
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.contact-information.index')->with($notification);
    }


}
