<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Order;
use App\Appointment;
use App\Setting;
use App\BannerImage;
use Hash;
use Image;
use File;
use App\ManageText;
use App\Navigation;
use App\ValidationText;
use App\NotificationText;
use App\ContactInformation;
use Illuminate\Pagination\Paginator;
class ProfileController extends Controller
{
    protected $banner;
    public function __construct()
    {

        $this->middleware('auth:web');
        $this->banner=BannerImage::first();
    }
    public function dashboard(){
        $user=Auth::user();
        $appointments=Appointment::where('user_id',$user->id)->get();
        $orders=Order::where('user_id',$user->id)->get();
        $banner=$this->banner;
        $navigation=Navigation::first();
        $websiteLang=ManageText::all();
        return view('patient.profile.dashboard',compact('user','appointments','orders','banner','navigation','websiteLang'));
    }

    public function account(){
        $user=Auth::user();
        $banner=$this->banner;
        $navigation=Navigation::first();
        $websiteLang=ManageText::all();
        return view('patient.profile.account',compact('user','banner','navigation','websiteLang'));
    }

    public function appointments(){
        $user=Auth::user();
        $currency=Setting::first();
        Paginator::useBootstrap();
        $appointments=Appointment::where('user_id',$user->id)->orderBy('id','desc')->paginate(10);
        $banner=$this->banner;
        $navigation=Navigation::first();
        $websiteLang=ManageText::all();
        return view('patient.profile.appointment',compact('user','appointments','currency','banner','navigation','websiteLang'));
    }

    public function showAppointment($id){
        $appointment=Appointment::find($id);
        $user=Auth::user();
        $banner=$this->banner;
        $navigation=Navigation::first();
        $websiteLang=ManageText::all();
        $currency=Setting::first();
        $setting=Setting::first();
        $contact=ContactInformation::first();
        return view('patient.profile.show-appointment',compact('user','appointment','banner','navigation','websiteLang','currency','setting','contact'));
    }

    public function orders(){
        $user=Auth::user();
        Paginator::useBootstrap();
        $orders=Order::where('user_id',$user->id)->orderBy('id','desc')->paginate(10);
        $currency=Setting::first();
        $banner=$this->banner;
        $navigation=Navigation::first();
        $websiteLang=ManageText::all();
        return view('patient.profile.order',compact('user','orders','currency','banner','navigation','websiteLang'));
    }

    public function updateProfile(Request $request) {

            // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();

        $rules = [
            'name'=>'required',
            'email'=>'required|unique:users,email,'.Auth::user()->id,
            'phone'=>'required',
            'age'=>'required',
            'occupation'=>'required',
            'gender'=>'required',
            'address'=>'required',
            'country'=>'required',
            'city'=>'required',
        ];

        $customMessages = [
            'name.required' => $valid_lang->where('lang_key','name')->first()->custom_lang,
            'email.required' => $valid_lang->where('lang_key','email')->first()->custom_lang,
            'email.unique' => $valid_lang->where('lang_key','unique_email')->first()->custom_lang,
            'phone.required' => $valid_lang->where('lang_key','phone')->first()->custom_lang,
            'age.required' => $valid_lang->where('lang_key','age')->first()->custom_lang,
            'occupation.required' => $valid_lang->where('lang_key','occupation')->first()->custom_lang,
            'gender.required' => $valid_lang->where('lang_key','gender')->first()->custom_lang,
            'address.required' => $valid_lang->where('lang_key','address')->first()->custom_lang,
            'country.required' => $valid_lang->where('lang_key','country')->first()->custom_lang,
            'city.required' => $valid_lang->where('lang_key','city')->first()->custom_lang
        ];

        $this->validate($request, $rules, $customMessages);



        $current_user=Auth::user();
        $image_name=$current_user->image;

        // inset user profile image
        if($request->file('image')){
            $user_image=$request->image;
            $extention=$user_image->getClientOriginalExtension();
            $image_name= $request->name.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name='uploads/custom-images/'.$image_name;
            Image::make($user_image)
                    ->resize(500,null,function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path($image_name));
            $old_image=User::where('id',Auth::user()->id)->first();
            if($old_image->image)
            {
                if(File::exists(public_path($old_image->image)))unlink(public_path($old_image->image));
            }
        }

        User::where('id',Auth::user()->id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'guardian_name'=>$request->guardian_name,
            'guardian_phone'=>$request->guardian_phone,
            'age'=>$request->age,
            'occupation'=>$request->occupation,
            'gender'=>$request->gender,
            'address'=>$request->address,
            'country'=>$request->country,
            'city'=>$request->city,
            'image'=>$image_name,
            'date_of_birth'=>$request->date_of_birth,
            'weight'=>$request->weight,
            'height'=>$request->height,
            'health_insurance_number'=>$request->health_insurance_number,
            'health_card_number'=>$request->health_card_number,
            'health_card_provider'=>$request->health_card_provider,
            'blood_group'=>$request->blood_group,
            'disabilities'=>$request->disabilities,
            'ready_for_appointment'=>1
        ]);

        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return back()->with($notification);


    }

    public function changePassword(){
        $user=Auth::user();
        $banner=$this->banner;
        $navigation=Navigation::first();
        $websiteLang=ManageText::all();
        return view('patient.profile.change-password',compact('user','banner','navigation','websiteLang'));
    }
    public function storePassword(Request $request){

            // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $valid_lang=ValidationText::all();
        $rules = [
            'password'=>'required|confirmed|min:3',
        ];

        $customMessages = [
            'password.required' => $valid_lang->where('lang_key','pass')->first()->custom_lang,
            'password.confirmed' => $valid_lang->where('lang_key','confirm_pass')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);

        $user=Auth::user();
        $user->password=Hash::make($request->password);
        $user->save();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return back()->with($notification);
    }


}
