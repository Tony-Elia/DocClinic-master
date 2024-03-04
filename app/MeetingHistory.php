<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeetingHistory extends Model
{
    protected $fillable=[
        'doctor_id','user_id','meeting_id','meeting_time','duration',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function meeting(){
        return $this->belongsTo(ZoomMeeting::class,'meeting_id','meeting_id');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
}
