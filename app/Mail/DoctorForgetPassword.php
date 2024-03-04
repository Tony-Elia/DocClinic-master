<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Doctor;
class DoctorForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $doctor;
    public $template;
    public $subject;
    public function __construct($doctor,$template,$subject)
    {
        $this->doctor=$doctor;
        $this->subject=$subject;
        $this->template=$template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $doctor=$this->doctor;
        $template=$this->template;
        return $this->subject($this->subject)->view('doctor.auth.send-forget-token',compact('doctor','template'));
    }
}
