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
        $doctors = Doctor::all();
        foreach ($doctors as $doctor) {
            $doctor->appointments;
            $doctor->department;
            $doctor->schedules;
        }
        return response()->json($doctors, 200);
    }
}
