<?php

namespace App\Http\Controllers\API;

use App\Doctor;
use App\Schedule;
use App\Order;
use App\Appointment;
use App\CustomPaginator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // requires date, schedule_id, doctor_id, user_id
    public function createAppointmentApi(Request $request)
    {
        $date = $request->date;
        
        // Retrieve schedule, doctor, user and department
        $schedule = Schedule::findOrFail($request->schedule_id);
        $doctor = Doctor::findOrFail($request->doctor_id);
        $user = User::findOrFail($request->user_id);

        $reserved = Appointment::where([
            ['doctor_id', $doctor->id],
            ['date', $date],
            ['schedule_id', $schedule->id]
        ])->first();
        
        if($reserved) return response()->json(["message" => "Appointment already reserved", "status" => "error", "reserved" => $reserved], 400);

        $order = Order::create([
            'user_id'=>$user->id,
            'order_id'=>'#'.date('Yms').rand(9,99),
            'total_payment'=>$doctor->fee,
            'appointment_qty'=>1,
            'payment_status'=>0,
            'payment_method'=>'',
            'last4'=>null,
            'payment_transaction_id'=>null
        ]);

        $appointment = Appointment::create([
            'order_id'=>$order->id,
            'doctor_id'=>$doctor->id,
            'user_id'=>$user->id,
            'day_id'=>$schedule->day_id,
            'schedule_id'=>$schedule->id,
            'date'=>$date,
            'appointment_fee'=>$doctor->fee,
            'payment_status'=>0
        ]);

        $appointment->schedule; $appointment->day;

        if($appointment and $order)
            return response()->json(['message' => 'Appointment created successfully', 'appointment' => $appointment], 200);
        else return response()->json(['message' => "Appointment couldn't be reserved"], 400);
    }

    public function getAppointment($id)
    {
        $doctor = Doctor::find($id);
        if ($doctor == null) {
            return response()->json(['message' => 'Doctor not found!'], 404);
        }
        return response()->json(['Appointments' => $doctor->appointments]);
    }

    public function searchDoctor(Request $request){
        Paginator::useBootstrap();
        $pagination_qty = CustomPaginator::where('id', 1)->first()->qty;
        $location_id = $request->location;
        $doctor_id = $request->doctor;
        $department_id = $request->department;

        $doctors = Doctor::with(['department', 'location'])->orderBy('name', 'desc');

        if ($location_id) {
            $doctors = $doctors->where('location_id', $location_id);
        }

        if ($department_id) {
            $doctors = $doctors->where('department_id', $department_id);
        }

        if ($doctor_id) {
            $doctors = $doctors->where('id', $doctor_id);
        }

        $doctors = $doctors->paginate($pagination_qty);
        $doctors = $doctors->appends($request->all());

        return response()->json($doctors);
    }

    public function getUserAppointments($id) {
        $appointments = Appointment::where('user_id', $id)->get();
        foreach ($appointments as $appointment) {
            $appointment->schedule;
            $appointment->day;
            $appointment->doctor;
        }
        if($appointments)
            return response()->json($appointments);
        else return response()->json(["message" => "Invalid ID", "status" => "error"], 400);
    }
}