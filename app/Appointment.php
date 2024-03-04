<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable=[
        'doctor_id','user_id','day_id','schedule_id','date','appointment_fee','payment_status','payment_transaction_id','payment_method','payment_description','blood_pressure','pulse_rate','temperature','problem_description','habits','already_treated','status','order_id'
    ];

    public function day(){
        return $this->belongsTo(Day::class);
    }
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function prescribes(){
        return $this->hasMany(Prescribe::class);
    }

    public function advice(){
        return $this->hasOne(Advice::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }


}
