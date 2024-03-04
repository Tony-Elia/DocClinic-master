<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Medicine;
use Illuminate\Http\Request;

use App\ManageText;
use App\ValidationText;
use App\NotificationText;

class MedicineController extends Controller
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
        $medicines=Medicine::all();
        $websiteLang=ManageText::all();
        return view('admin.medicine.index',compact('medicines','websiteLang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $websiteLang=ManageText::all();
        return view('admin.medicine.create',compact('websiteLang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            "name"    => "required|array|min:1",
            "name.*"  => "required|string|distinct|min:1",
        ];
        $customMessages = [
            'name.required' => $valid_lang->where('lang_key','name')->first()->custom_lang,

        ];

        $this->validate($request, $rules, $customMessages);



        foreach($request->name as $row){
            Medicine::create([
                'name'=>$row,
                'status'=>1
            ]);
        }

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.medicine.index')->with($notification);
    }


    public function update(Request $request, Medicine $medicine)
    {

         // project demo mode check
         if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end


        $valid_lang=ValidationText::all();
        $rules = [
            "name"    => "required",
            "status"    => "required"
        ];
        $customMessages = [
            'name.required' => $valid_lang->where('lang_key','name')->first()->custom_lang,

        ];

        $this->validate($request, $rules, $customMessages);

        $medicine->name=$request->name;
        $medicine->status=$request->status;
        $medicine->save();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.medicine.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medicine $medicine)
    {

         // project demo mode check
         if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end


        $medicine->delete();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.medicine.index')->with($notification);
    }

    // manage blog status
    public function changeStatus($id){
        $medicine=Medicine::find($id);
        if($medicine->status==1){
            $medicine->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $medicine->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $medicine->save();
        return response()->json($message);

    }
}
