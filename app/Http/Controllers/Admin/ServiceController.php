<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service;
use App\ServiceImage;
use Illuminate\Http\Request;
use Image;
use Str;
use File;

use App\ManageText;
use App\ValidationText;
use App\NotificationText;

class ServiceController extends Controller
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
        $services=Service::all();
        $websiteLang=ManageText::all();
        return view('admin.service.index',compact('services','websiteLang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $websiteLang=ManageText::all();
        return view('admin.service.create',compact('websiteLang'));
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
            'header'=>'required|unique:services',
            'icon'=>'required',
            'images'=>'required',
            'sort_description'=>'required',
            'long_description'=>'required',
            'status'=>'required',
            'show_homepage'=>'required',
        ];
        $customMessages = [
            'header.required' => $valid_lang->where('lang_key','header')->first()->custom_lang,
            'icon.required' => $valid_lang->where('lang_key','icon')->first()->custom_lang,
            'images.required' => $valid_lang->where('lang_key','img')->first()->custom_lang,
            'sort_description.required' => $valid_lang->where('lang_key','short_des')->first()->custom_lang,
            'long_description.required' => $valid_lang->where('lang_key','des')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);


        // insert Department
        $service=Service::create([
            'header'=>$request->header,
            'icon'=>$request->icon,
            'slug'=>Str::slug($request->header),
            'seo_title'=>$request->seo_title ? $request->seo_title : 'service seo title',
            'seo_description'=>$request->seo_description ? $request->seo_description : 'service seo description',
            'sort_description'=>$request->sort_description,
            'long_description'=>$request->long_description,
            'status'=>$request->status,
            'show_homepage'=>$request->show_homepage,
        ]);


        // image insert
        foreach($request->images  as $index => $row){
            $ext=$row->getClientOriginalExtension();
            $small_name= 'service-small-'.date('Y-m-d-h-i-s-').rand(999,9999).$index.'.'.$ext;
            $large_name= 'service-large-'.date('Y-m-d-h-i-s-').rand(999,9999).$index.'.'.$ext;


            // for small image
            $small_name='uploads/custom-images/'.$small_name;
            Image::make($row)
                    ->resize(175,116)
                    ->save(public_path($small_name));


            // large image
            $large_name='uploads/custom-images/'.$large_name;
            Image::make($row)
                    ->resize(730,486)
                    ->save(public_path($large_name));


            $isInsert=ServiceImage::create([
                'service_id'=>$service->id,
                'small_image'=>$small_name,
                'large_image'=>$large_name
            ]);
        }


        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.service.index')->with($notification);
    }


    public function edit(Service $service)
    {
        $websiteLang=ManageText::all();
        return view('admin.service.edit',compact('service','websiteLang'));
    }


    public function update(Request $request, Service $service)
    {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            'header'=>'required|unique:services,header,'.$service->id,
            'icon'=>'required',
            'sort_description'=>'required',
            'long_description'=>'required',
            'status'=>'required',
            'show_homepage'=>'required',
        ];
        $customMessages = [
            'header.required' => $valid_lang->where('lang_key','header')->first()->custom_lang,
            'icon.required' => $valid_lang->where('lang_key','icon')->first()->custom_lang,
            'images.required' => $valid_lang->where('lang_key','img')->first()->custom_lang,
            'sort_description.required' => $valid_lang->where('lang_key','short_des')->first()->custom_lang,
            'long_description.required' => $valid_lang->where('lang_key','des')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);


        // update service
        $service->header=$request->header;
        $service->slug=Str::slug($request->header);
        $service->icon=$request->icon;
        $service->seo_title=$request->seo_title ? $request->seo_title : 'service seo title';
        $service->seo_description=$request->seo_description ? $request->seo_description : 'service seo description';
        $service->sort_description=$request->sort_description;
        $service->long_description=$request->long_description;
        $service->status=$request->status;
        $service->show_homepage=$request->show_homepage;
        $service->save();

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.service.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
        $oldImages=$service->images;
        $service->delete();
        foreach($oldImages as $img){
            if(File::exists(public_path($img->small_image)))unlink(public_path($img->small_image));
            if(File::exists(public_path($img->large_image)))unlink(public_path($img->large_image));
            $img::destroy($img->id);
        }
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('admin.service.index')->with($notification);

    }

    // change service status
    public function changeStatus($id){
        $service=Service::find($id);
        if($service->status==1){
            $service->status=0;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','inactive')->first()->custom_lang;
            $message=$notification;
        }else{
            $service->status=1;
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','active')->first()->custom_lang;
            $message=$notification;
        }
        $service->save();
        return response()->json($message);

    }

    // manage services images
    public function images($serviceId){
        $images=ServiceImage::where('service_id',$serviceId)->get();

        $websiteLang=ManageText::all();
        return view('admin.service.image',compact('images','serviceId','websiteLang'));
    }

    // delete service image
    public function deleteImage($id){

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end
        $image=ServiceImage::find($id);
        $small_image=$image->small_image;
        $large_image=$image->large_image;
        ServiceImage::destroy($id);
        if(File::exists(public_path($image->small_image)))unlink(public_path($image->small_image));
        if(File::exists(public_path($image->large_image)))unlink(public_path($image->large_image));
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return back()->with($notification);
    }

    // store images
    public function storeImage(Request $request,$serviceId){

        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            "image"    => "required"
        ];
        $customMessages = [
            'image.required' => $valid_lang->where('lang_key','img')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);


        foreach($request->image as $index => $row){
            $extention=$row->getClientOriginalExtension();
            $small_image= 'service-small-'.date('Y-m-d-h-i-s-').rand(999,9999).$index.'.'.$extention;
            $large_image= 'service-large-'.date('Y-m-d-h-i-s-').rand(999,9999).$index.'.'.$extention;

            // for small image
            $small_image='uploads/custom-images/'.$small_image;
            $large_image='uploads/custom-images/'.$large_image;
            Image::make($row)
                    ->resize(175,116)
                    ->save(public_path($small_image));
            Image::make($row)
                    ->resize(730,486)
                    ->save(public_path($large_image));
            ServiceImage::create([
                'service_id'=>$serviceId,
                'small_image'=>$small_image,
                'large_image'=>$large_image
            ]);
        }

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return back()->with($notification);
    }
}


