<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    protected $fillable=[
    'doctor_id','topic','start_time','duration','meeting_id','password','join_url'
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
}
