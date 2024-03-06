<?php

namespace App\Http\Controllers\API;

use App\Appointment;
use App\Department;
use App\Doctor;
use App\Http\Controllers\Controller;
use App\Schedule;

// use App\Http\Resources\DoctorCollection;

class DoctorController extends Controller
{
    public function getAll() {
        return response()->json(Doctor::all(), 200);
    }

    public function getDoctor($id) {
        $doctor = Doctor::find($id);

        if(!($doctor)) return response()->json(["message" => "Error: Doctor ID not found", "status" => "Error"], 400);

        $doctor->department; $doctor->appointments;
        foreach ($doctor->schedules as $schedule) {
            $schedule->day;
        }

        return response()->json([$doctor]);
    }
}
