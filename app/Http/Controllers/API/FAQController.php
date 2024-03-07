<?php

namespace App\Http\Controllers\API;

use App\Appointment;
use App\Department;
use App\Doctor;
use App\Faq;
use App\Http\Controllers\Controller;
use App\Schedule;

// use App\Http\Resources\DoctorCollection;

class FAQController extends Controller
{
    public function getAll() {
        $faqs = Faq::all();
        foreach ($faqs as $faq) {
            $faq->category;
        }

        return response()->json($faqs);
    }
}
