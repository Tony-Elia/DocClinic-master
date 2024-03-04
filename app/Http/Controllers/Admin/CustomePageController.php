<?php

namespace App\Http\Controllers\Admin;

use App\CustomePage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;
use App\ManageText;
use App\ValidationText;
use App\NotificationText;
class CustomePageController extends Controller
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
        $pages=CustomePage::all();
        $websiteLang=ManageText::all();
        return view('admin.custome-page.index',compact('pages','websiteLang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $websiteLang=ManageText::all();
        return view('admin.custome-page.create',compact('websiteLang','websiteLang'));
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
            $notification=array(
                'messege'=>env('NOTIFY_TEXT'),
                'alert-type'=>'error'
            );
            return redirect()->back()->with($notification);
        }
        // end


        $valid_lang=ValidationText::all();
        $rules = [
            'page_name'=>'required',
            'description'=>'required',
        ];

        $customMessages = [
            'page_name.required' => $valid_lang->where('lang_key','page_name')->first()->custom_lang,
            'description.required' => $valid_lang->where('lang_key','des')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);

        $page=new CustomePage;
        $page->page_name=$request->page_name;
        $page->slug=Str::slug($request->page_name);
        $page->seo_title=$request->seo_title ? $request->seo_title : 'custom page seo title';
        $page->seo_description=$request->seo_description ? $request->seo_description : 'custom page seo description';
        $page->description=$request->description;
        $page->status=$request->status;
        $page->save();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.custom-page.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomePage  $customePage
     * @return \Illuminate\Http\Response
     */
    public function show(CustomePage $customePage)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomePage  $customePage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page=CustomePage::find($id);
        $websiteLang=ManageText::all();
        return view('admin.custome-page.edit',compact('page','websiteLang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomePage  $customePage
     * @return \Illuminate\Http\Response
     */
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
            'page_name'=>'required',
            'description'=>'required',
        ];

        $customMessages = [
            'page_name.required' => $valid_lang->where('lang_key','page_name')->first()->custom_lang,
            'description.required' => $valid_lang->where('lang_key','des')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);


        $page=CustomePage::find($id);
        $page->page_name=$request->page_name;
        $page->slug=Str::slug($request->page_name);
        $page->seo_title=$request->seo_title ? $request->seo_title : 'custom page seo title';
        $page->seo_description=$request->seo_description ? $request->seo_description : 'custom page seo description';
        $page->description=$request->description;
        $page->status=$request->status;
        $page->save();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.custom-page.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomePage  $customePage
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomePage  $customePage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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


        CustomePage::destroy($id);
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.custom-page.index')->with($notification);
    }

    public function changeStatus($id){
        $page=CustomePage::find($id);
        if($page->status==1){
            $page->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $page->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $page->save();
        return response()->json($message);

    }
}
