<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MedicineType;
use Illuminate\Http\Request;


use App\ManageText;
use App\ValidationText;
use App\NotificationText;

class MedicineTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicinetypes=MedicineType::all();
        $websiteLang=ManageText::all();
        return view('admin.medicine.medicine-type.index',compact('medicinetypes','websiteLang'));
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
            'type'=>'required|unique:medicine_types',
            'status'=>'required'
        ];
        $customMessages = [
            'type.required' => $valid_lang->where('lang_key','type')->first()->custom_lang,
            'type.unique' => $valid_lang->where('lang_key','unique_type')->first()->custom_lang,

        ];

        $this->validate($request, $rules, $customMessages);

        $medicineType=new MedicineType();
        $medicineType->type=$request->type;
        $medicineType->status=$request->status;
        $medicineType->save();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.medicine-type.index')->with($notification);
    }


    public function update(Request $request, MedicineType $medicineType)
    {

          // project demo mode check
          if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end


        $valid_lang=ValidationText::all();
        $rules = [
            'type'=>'required|unique:medicine_types,type,'.$medicineType->id,
            'status'=>'required'
        ];
        $customMessages = [
            'type.required' => $valid_lang->where('lang_key','type')->first()->custom_lang,
            'type.unique' => $valid_lang->where('lang_key','unique_type')->first()->custom_lang,

        ];

        $this->validate($request, $rules, $customMessages);


        $medicineType->type=$request->type;
        $medicineType->status=$request->status;
        $medicineType->save();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.medicine-type.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MedicineType  $medicineType
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicineType $medicineType)
    {

          // project demo mode check
          if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end


        $medicineType->delete();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.medicine-type.index')->with($notification);
    }

    public function changeStatus($id){
        $medicine=MedicineType::find($id);
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
