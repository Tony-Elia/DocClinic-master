<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\ManageText;
class DoctorScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }
    public function index(){
        $doctor=Auth::guard('doctor')->user();
        $websiteLang=ManageText::all();
        return view('doctor.schedule.index',compact('doctor','websiteLang'));
    }
}
