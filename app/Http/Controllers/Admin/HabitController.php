<?php

namespace App\Http\Controllers\Admin;

use App\Habit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\ManageText;
use App\ValidationText;
use App\NotificationText;

class HabitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $habits=Habit::all();
        $websiteLang=ManageText::all();
        return view('admin.habit.index',compact('habits','websiteLang'));
    }


    public function store(Request $request)
    {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            "habit"    => "required|array|min:1",
            "habit.*"  => "required|string|distinct|min:1",
        ];


        $customMessages = [
            'habit.required' => $valid_lang->where('lang_key','habit')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);


        foreach($request->habit as $item){
            Habit::create([
                'habit'=>$item
            ]);
        }

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');


        return redirect()->route('admin.habit.index')->with($notification);
    }


    public function update(Request $request, Habit $habit)
    {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

;

        $valid_lang=ValidationText::all();
        $rules = [
            'habit'=>'required'
        ];


        $customMessages = [
            'habit.required' => $valid_lang->where('lang_key','habit')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);

        $habit->habit=$request->habit;
        $habit->save();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');


        return redirect()->route('admin.habit.index')->with($notification);
    }

    public function destroy(Habit $habit)
    {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
        $habit->delete();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');


        return redirect()->route('admin.habit.index')->with($notification);
    }
}
