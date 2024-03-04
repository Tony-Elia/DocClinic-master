<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable=[
        'doctor_id','user_id','message','doctor_view','patient_view','send_doctor','send_user'
    ];
}
