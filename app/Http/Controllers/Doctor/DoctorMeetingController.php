<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;

use App\ZoomMeeting;
use App\ZoomCredential;
use App\Traits\ZoomMeetingTrait;
use Illuminate\Http\Request;
use Auth;
use App\Appointment;
use App\EmailTemplate;
use App\MeetingHistory;
use App\User;
use Mail;
use App\Mail\SendZoomMeetingLink;
use App\Helpers\MailHelper;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use Session;
use Exception;

use App\ManageText;
use App\ValidationText;
use App\NotificationText;

use GuzzleHttp\Client;

class DoctorMeetingController extends Controller
{
    use ZoomMeetingTrait;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    public function __construct()
    {
        $this->middleware('auth:doctor');
    }


    public function index(){
        $doctor=Auth::guard('doctor')->user();
        $meetings=ZoomMeeting::where('doctor_id',$doctor->id)->orderBy('start_time','desc')->get();
        $valid_lang=ValidationText::all();
        $confirm=$valid_lang->where('lang_key','are_you_sure')->first()->custom_lang;
        $websiteLang=ManageText::all();
        return view('doctor.zoom.meeting.index',compact('meetings','confirm','websiteLang'));
    }

    public function show($id)
    {
        $meeting = $this->get($id);
        $websiteLang=ManageText::all();
        return view('meetings.index', compact('meeting','websiteLang'));
    }

    public function createForm(Request $request){

        $doctor=Auth::guard('doctor')->user();
        $credential=ZoomCredential::where('doctor_id',$doctor->id)->first();

        if(!$credential){
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','setup_zoom_first')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');

            return redirect()->route('doctor.zoom-credential')->with($notification);
        }

        $appointments=Appointment::where('doctor_id',$doctor->id)->select('user_id')->groupBy('user_id')->get();
        $patients=$appointments;
        $users=User::whereIn('id',$patients)->get();
        $websiteLang=ManageText::all();
        return view('doctor.zoom.meeting.create',compact('patients','users','websiteLang'));
    }


    public function callback_zoom_meeting(Request $request){
        if($request->code){

            $meeting_data = Session::get('meeting_data');

            $doctor=Auth::guard('doctor')->user();
            $credential=ZoomCredential::where('doctor_id',$doctor->id)->first();


            $get_token = $this->get_access_token($request->code);


            if($get_token['status'] == 'success'){

                $get_new_meeting_details = $this->create_a_zoom_meeting([
                    'topic'         => $meeting_data['topic'],
                    'type'          => 2,
                    'start_time'    => $meeting_data['start_time'],
                    'duration'    => $meeting_data['duration'],
                    'agenda'    => $meeting_data['agenda'],
                    'password'      => mt_rand(),
                    'token'         => $get_token['token']['access_token'],
                    'refresh_token' => $get_token['token']['refresh_token'],
                ]);

                // dd($get_new_meeting_details);
                if ($get_new_meeting_details['msg'] == 'success') {

                    $this->store_meeting_data($get_new_meeting_details['response']);

                    Session::forget('meeting_data');

                    $notify_lang=NotificationText::all();
                    $notification=$notify_lang->where('lang_key','create')->first()->custom_lang;
                    $notification=array('messege'=>$notification,'alert-type'=>'success');

                    return redirect()->route('doctor.zoom-meetings')->with($notification);


                    echo $get_new_meeting_details['response']['uuid'];
                } else {
                    Session::forget('meeting_data');

                    $notify_lang=NotificationText::all();
                    $notification=$notify_lang->where('lang_key','something')->first()->custom_lang;
                    $notification=array('messege'=>$notification,'alert-type'=>'error');

                    return redirect()->route('doctor.create-zoom-meeting')->with($notification);
                }


            }else{

                Session::forget('meeting_data');

                $notify_lang=NotificationText::all();
                $notification=$notify_lang->where('lang_key','something')->first()->custom_lang;
                $notification=array('messege'=>$notification,'alert-type'=>'error');

                return redirect()->route('doctor.create-zoom-meeting')->with($notification);
            }

            Session::forget('meeting_data');

            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','something')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');

            return redirect()->route('doctor.create-zoom-meeting')->with($notification);

        }else{
            $url = "https://zoom.us/oauth/authorize?response_type=code&client_id=" . $credential->zoom_api_key . "&redirect_uri=" . route('doctor.callback-zoom-meeting');

            return redirect()->to($url);
        }
    }

    function create_a_zoom_meeting($meetingConfig = [])
    {
        try {
            //++++++++++++++++++++++++++++++++++++++++++++++++
            $jwtToken = $meetingConfig['token'];
            //++++++++++++++++++++++++++++++++++++++++++++++++

            $requestBody = [
                'topic'      => $meetingConfig['topic'] ?? env('APP_NAME'),
                'type'       => $meetingConfig['type'] ?? 2,
                'start_time' => $meetingConfig['start_time'] ?? date('Y-m-dTh:i:00') . 'Z',
                'duration'   => $meetingConfig['duration'] ?? 30,
                'password'   => $meetingConfig['password'] ?? mt_rand(),
                'timezone'   => config('app.timezone'),
                'agenda'     => $meetingConfig['agenda'] ?? env('APP_NAME'),
                'settings'   => [
                    'host_video'        => false,
                    'participant_video' => true,
                    'cn_meeting'        => false,
                    'in_meeting'        => false,
                    'join_before_host'  => true,
                    'mute_upon_entry'   => true,
                    'watermark'         => false,
                    'use_pmi'           => false,
                    'approval_type'     => 1,
                    'registration_type' => 1,
                    'audio'             => 'voip',
                    'auto_recording'    => 'none',
                    'waiting_room'      => false,
                ],
            ];
            //++++++++++++++++++++++++++++++++++++++++++++++++
            //++++++++++++++++++++++++++++++++++++++++++++++++
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
            curl_setopt_array($curl, array(
                CURLOPT_URL            => "https://api.zoom.us/v2/users/me/meetings",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => "",
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => "POST",
                CURLOPT_POSTFIELDS     => json_encode($requestBody),
                CURLOPT_HTTPHEADER     => array(
                    "Authorization: Bearer " . $jwtToken,
                    "Content-Type: application/json",
                    "cache-control: no-cache",
                ),
            ));
            $response = curl_exec($curl);
            $err      = curl_error($curl);
            curl_close($curl);
            //++++++++++++++++++++++++++++++++++++++++++++++++
            if ($err) {
                return [
                    'success'  => false,
                    'msg'      => 'cURL Error #:' . $err,
                    'response' => null,
                ];
            } else {
                return [
                    'success'  => true,
                    'msg'      => 'success',
                    'response' => json_decode($response, true),
                ];
            }
        } catch (Exception $e) {
            if ($e->getCode() == 401) {
                //++++++++++++++++++++++++++++++++++++++++++++++++++++
                $get_token = $this->get_refresh_token($meetingConfig['refresh_token']);
                //++++++++++++++++++++++++++++++++++++++++++++++++++++

                $meeting_data = Session::get('meeting_data');

                $get_new_meeting_details = $this->create_a_zoom_meeting([
                    'topic'      => $meeting_data['topic'],
                    'type'       => 2,
                    'start_time'    => $meeting_data['start_time'],
                    'duration'    => $meeting_data['duration'],
                    'agenda'    => $meeting_data['agenda'],
                    'password'   => mt_rand(),
                    'token'      => $get_token,
                ]);

                echo 'hi refresh token';
                dd($get_new_meeting_details);
                if ($get_new_meeting_details['msg'] == 'success') {
                    echo $get_new_meeting_details['response']['uuid'];
                } else {
                    echo "OPPS!! Error";
                }
            } else {
                return [
                    'success'  => false,
                    'msg'      => 'cURL Error #:' . $err,
                    'response' => null,
                ];
            }
        }
    }

    public function get_access_token($code)
    {
        $doctor=Auth::guard('doctor')->user();
        $credential=ZoomCredential::where('doctor_id',$doctor->id)->first();

        try {
            $client   = new \GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('POST', '/oauth/token', [
                "headers"     => [
                    "Authorization" => "Basic " . base64_encode($credential->zoom_api_key . ':' . $credential->zoom_api_secret),
                ],
                'form_params' => [
                    "grant_type"   => "authorization_code",
                    "code"         => $code,
                    "redirect_uri" => route('doctor.callback-zoom-meeting'),
                ],
            ]);
            $token = json_decode($response->getBody()->getContents(), true);

            return [
                'status' => 'success',
                'token' => $token
            ];

        } catch (Exception $e) {
            return [
                'status' => 'faild',
                'token' => null
            ];
        }
    }


    public function get_refresh_token($refresh_token)
    {
        $doctor=Auth::guard('doctor')->user();
        $credential=ZoomCredential::where('doctor_id',$doctor->id)->first();

        try {
            $client   = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('POST', '/oauth/token', [
                "headers"     => [
                    "Authorization" => "Basic " . base64_encode($credential->zoom_api_key . ':' . $credential->zoom_api_secret),
                ],
                'form_params' => [
                    "grant_type"    => "refresh_token",
                    "refresh_token" => $refresh_token,
                ],
            ]);
            $token = $response->getBody();
            return $token;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
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
            'topic'=>'required',
            'patient'=>'required',
            'start_time'=>'required',
            'duration'=>'required|numeric',
        ];


        $customMessages = [
            'topic.required' => $valid_lang->where('lang_key','topic')->first()->custom_lang,
            'patient.required' => $valid_lang->where('lang_key','patient')->first()->custom_lang,
            'start_time.required' => $valid_lang->where('lang_key','start_time')->first()->custom_lang,
            'duration.required' => $valid_lang->where('lang_key','duration')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);

        $doctor=Auth::guard('doctor')->user();
        $data=array();
        $data['start_time']=$request->start_time;
        $data['topic']=$request->topic;
        $data['duration']=$request->duration;
        $data['agenda']=$doctor->name;
        $data['host_video']=1;
        $data['participant_video']=1;
        $data['patient']=$request->patient;

        Session::put('meeting_data', $data);

        $credential=ZoomCredential::where('doctor_id',$doctor->id)->first();

        $url = "https://zoom.us/oauth/authorize?response_type=code&client_id=" . $credential->zoom_api_key . "&redirect_uri=" . route('doctor.callback-zoom-meeting');

        return redirect()->to($url);


    }


    public function store_meeting_data($response){

        $doctor=Auth::guard('doctor')->user();

        $meeting_data = Session::get('meeting_data');

        $meeting=new ZoomMeeting();
        $meeting->doctor_id=$doctor->id;
        $meeting->start_time=date('Y-m-d H:i:s',strtotime($meeting_data['start_time'])) ;
        $meeting->topic=$meeting_data['topic'];
        $meeting->duration=$meeting_data['duration'];
        $meeting->meeting_id=$response['id'];
        $meeting->password=$response['password'];
        $meeting->join_url=$response['join_url'];
        $meeting->save();

        if($meeting_data['patient']==-1){
            $doctor=Auth::guard('doctor')->user();
            $appointments=Appointment::where('doctor_id',$doctor->id)->select('user_id')->groupBy('user_id')->get();
            $patients=$appointments;
            $users=User::whereIn('id',$patients)->get();
            $meeting_link=$response['join_url'];
            foreach($users as $user){
                $history=new MeetingHistory();
                $history->doctor_id=$doctor->id;
                $history->user_id=$user->id;
                $history->meeting_id=$meeting->meeting_id;
                $history->meeting_time=date('Y-m-d H:i:s',strtotime($meeting->start_time));
                $history->duration=$meeting->duration;
                $history->save();

                // send email
                $template=EmailTemplate::where('id',8)->first();
                $message=$template->description;
                $subject=$template->subject;
                $message=str_replace('{{patient_name}}',$user->name,$message);
                $message=str_replace('{{doctor_name}}',$doctor->name,$message);
                $message=str_replace('{{meeting_schedule}}',date('Y-m-d h:i:A',strtotime($meeting->start_time)),$message);
                MailHelper::setMailConfig();
                Mail::to($user->email)->send(new SendZoomMeetingLink($subject,$message,$meeting_link));
            }
        }else{

            $user=User::where('id',$meeting_data['patient'])->first();
            $meeting_link=$response['join_url'];

            $history=new MeetingHistory();
            $history->doctor_id=$doctor->id;
            $history->user_id=$user->id;
            $history->meeting_id=$meeting->meeting_id;
            $history->meeting_time=date('Y-m-d H:i:s',strtotime($meeting->start_time));
            $history->duration=$meeting->duration;
            $history->save();

            // send email
            $template=EmailTemplate::where('id',8)->first();
            $message=$template->description;
            $subject=$template->subject;
            $message=str_replace('{{patient_name}}',$user->name,$message);
            $message=str_replace('{{doctor_name}}',$doctor->name,$message);
            $message=str_replace('{{meeting_schedule}}',date('Y-m-d h:i:A',strtotime($meeting->start_time)),$message);
            MailHelper::setMailConfig();
            Mail::to($user->email)->send(new SendZoomMeetingLink($subject,$message,$meeting_link));
        }




    }

    public function editForm($id){
        $meeting=ZoomMeeting::find($id);
        if($meeting){
            $doctor=Auth::guard('doctor')->user();
            if($meeting->doctor_id){
                $doctor=Auth::guard('doctor')->user();
                $appointments=Appointment::where('doctor_id',$doctor->id)->select('user_id')->groupBy('user_id')->get();
                $patients=$appointments;
                $users=User::whereIn('id',$patients)->get();
                $websiteLang=ManageText::all();
                return view('doctor.zoom.meeting.edit',compact('meeting','users','websiteLang'));
            }else{
                $notify_lang=NotificationText::all();
                $notification=$notify_lang->where('lang_key','something')->first()->custom_lang;
                $notification=array('messege'=>$notification,'alert-type'=>'error');

                return redirect()->route('doctor.zoom-meetings')->with($notification);
            }
        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','something')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');

            return redirect()->route('doctor.zoom-meetings')->with($notification);
        }

    }
    public function updateMeeting($id, Request $request)
    {

            // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end



        $valid_lang=ValidationText::all();
        $rules = [
            'topic'=>'required',
            'start_time'=>'required',
            'patient'=>'required',
            'duration'=>'required|numeric',
        ];


        $customMessages = [
            'topic.required' => $valid_lang->where('lang_key','topic')->first()->custom_lang,
            'patient.required' => $valid_lang->where('lang_key','patient')->first()->custom_lang,
            'start_time.required' => $valid_lang->where('lang_key','start_time')->first()->custom_lang,
            'duration.required' => $valid_lang->where('lang_key','duration')->first()->custom_lang,
        ];

        $this->validate($request, $rules, $customMessages);




        $doctor=Auth::guard('doctor')->user();
        $data=array();
        $data['start_time']=$request->start_time;
        $data['topic']=$request->topic;
        $data['duration']=$request->duration;
        $data['agenda']=$doctor->name;
        $data['host_video']=1;
        $data['participant_video']=1;

        $response=$this->update($id, $data);

        if($response['success']){
            $success=$response['data'];

            $meeting=ZoomMeeting::where('meeting_id',$id)->first();
            $meeting->doctor_id=$doctor->id;
            $meeting->start_time=date('Y-m-d H:i:s',strtotime($success['data']['start_time']));
            $meeting->topic=$request->topic;
            $meeting->duration=$request->duration;
            $meeting->meeting_id=$success['data']['id'];
            $meeting->password=$success['data']['password'];
            $meeting->join_url=$success['data']['join_url'];
            $meeting->save();


            if($request->patient==-1){
                $doctor=Auth::guard('doctor')->user();
                $appointments=Appointment::where('doctor_id',$doctor->id)->select('user_id')->groupBy('user_id')->get();
                $patients=$appointments;
                $users=User::whereIn('id',$patients)->get();
                $meeting_link=$success['data']['join_url'];
                foreach($users as $user){
                    $history=new MeetingHistory();
                    $history->doctor_id=$doctor->id;
                    $history->user_id=$user->id;
                    $history->meeting_id=$meeting->meeting_id;
                    $history->meeting_time=date('Y-m-d H:i:s',strtotime($meeting->start_time));
                    $history->duration=$meeting->duration;
                    $history->save();

                    // send email
                    $template=EmailTemplate::where('id',8)->first();
                    $message=$template->description;
                    $subject=$template->subject;
                    $message=str_replace('{{patient_name}}',$user->name,$message);
                    $message=str_replace('{{doctor_name}}',$doctor->name,$message);
                    $message=str_replace('{{meeting_schedule}}',date('Y-m-d h:i:A',strtotime($meeting->start_time)),$message);
                    MailHelper::setMailConfig();
                    Mail::to($user->email)->send(new SendZoomMeetingLink($subject,$message,$meeting_link));
                }
            }else{
                $user=User::where('id',$request->patient)->first();
                $meeting_link=$success['data']['join_url'];
                $history=new MeetingHistory();
                $history->doctor_id=$doctor->id;
                $history->user_id=$user->id;
                $history->meeting_id=$meeting->meeting_id;
                $history->meeting_time=date('Y-m-d H:i:s',strtotime($meeting->start_time));
                $history->duration=$meeting->duration;
                $history->save();
                // send email
                $template=EmailTemplate::where('id',8)->first();
                $message=$template->description;
                $subject=$template->subject;
                $message=str_replace('{{patient_name}}',$user->name,$message);
                $message=str_replace('{{doctor_name}}',$doctor->name,$message);
                $message=str_replace('{{meeting_schedule}}',date('Y-m-d h:i:A',strtotime($meeting->start_time)),$message);
                MailHelper::setMailConfig();
                Mail::to($user->email)->send(new SendZoomMeetingLink($subject,$message,$meeting_link));
            }


            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','update')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'success');

            return redirect()->route('doctor.zoom-meetings')->with($notification);
        }else{
            $notify_lang=NotificationText::all();
            $notification=$notify_lang->where('lang_key','something')->first()->custom_lang;
            $notification=array('messege'=>$notification,'alert-type'=>'error');

            return redirect()->route('doctor.zoom-meetings')->with($notification);
        }
    }

    public function destroy($id)
    {
        // project demo mode check
        if(env('PROJECT_MODE')==0){
            $notification=array('messege'=>env('NOTIFY_TEXT'),'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }
        // end

        $meeting=ZoomMeeting::find($id);

        MeetingHistory::where('meeting_id',$meeting->meeting_id)->delete();
        $meeting_id=$meeting->meeting_id;
        ZoomMeeting::where('meeting_id',$meeting_id)->delete();
        $notify_lang=NotificationText::all();
        $notification=$notify_lang->where('lang_key','delete')->first()->custom_lang;
        $notification=array('messege'=>$notification,'alert-type'=>'success');

        return redirect()->route('doctor.zoom-meetings')->with($notification);
    }

    public function meetingHistory(){
        $doctor=Auth::guard('doctor')->user();
        $histories=MeetingHistory::where('doctor_id',$doctor->id)->orderBy('meeting_time','desc')->get();
        $websiteLang=ManageText::all();
        return view('doctor.zoom.meeting.history',compact('histories','websiteLang'));
    }

    public function upCommingMeeting(){
        $doctor=Auth::guard('doctor')->user();
        $histories=MeetingHistory::where('doctor_id',$doctor->id)->orderBy('meeting_time','desc')->get();
        $websiteLang=ManageText::all();
        return view('doctor.zoom.meeting.upcoming',compact('histories','websiteLang'));
    }
}
