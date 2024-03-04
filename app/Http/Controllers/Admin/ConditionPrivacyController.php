<?php

namespace App\Http\Controllers\Admin;

use App\ConditionPrivacy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
class ConditionPrivacyController extends Controller
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

        $conditionPrivacy=ConditionPrivacy::first();
        if($conditionPrivacy){
            $websiteLang=ManageText::all();
            return view('admin.terms-privacy.edit',compact('conditionPrivacy','websiteLang'));
        }else{
            $websiteLang=ManageText::all();
            return view('admin.terms-privacy.create',compact('websiteLang'));
        }

    }


    public function store(Request $request)
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
            'terms_condition'=>'required',
            'privacy_policy'=>'required',
        ];

        $customMessages = [
            'terms_condition.required' => $valid_lang->where('lang_key','terms_condition')->first()->custom_lang,
            'privacy_policy.required' => $valid_lang->where('lang_key','privacy_policy')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);

        ConditionPrivacy::create([
            'terms_condition'=>$request->terms_condition,
            'privacy_policy'=>$request->privacy_policy
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.terms-privacy.index')->with($notification);
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


        $valid_lang=ValidationText::all();
        $rules = [
            'terms_condition'=>'required',
            'privacy_policy'=>'required',
        ];

        $customMessages = [
            'terms_condition.required' => $valid_lang->where('lang_key','terms_condition')->first()->custom_lang,
            'privacy_policy.required' => $valid_lang->where('lang_key','privacy_policy')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);


        ConditionPrivacy::where('id',$id)->update([
            'terms_condition'=>$request->terms_condition,
            'privacy_policy'=>$request->privacy_policy
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.terms-privacy.index')->with($notification);
    }


}
