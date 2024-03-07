<?php

namespace App\Http\Controllers\API;

use App\Appointment;
use App\Department;
use App\Doctor;
use App\Http\Controllers\Controller;
use App\Schedule;
use App\User;

// use App\Http\Resources\DoctorCollection;

class UserController extends Controller
{
    function getUser($id) {
        $user = User::find($id);
        if($user) return response()->json($user);
        else return response()->json(["message" => "User not found", "status" => "error"], 404);
    }
}
