<?php

use App\Doctor;
use App\Http\Controllers\API\DoctorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\FAQController;
use Maatwebsite\Excel\Row;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



// // Register the user registration page route
// Route::get('/register', [RegisterController::class, 'userRegisterPage']);

// // Register the user store route
// Route::post('/register', [RegisterController::class, 'storeRegister']);

// // Register the user verification route
// Route::get('/verify/{token}', [RegisterController::class, 'userVerify']);

///////// LOGIN ///////

Route::post('/login', 'Auth\LoginController@storeLogin');
Route::post('/logout', 'Auth\LoginController@userLogout')->middleware('auth:api');


Route::post('/register-new', [RegisterController::class, 'register']);
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp']);

Route::get('/doctors', [DoctorController::class, 'getAll']);
Route::get('/doctors/{id}', [DoctorController::class, 'getDoctor']);
Route::get('/search-doctor', [AppointmentController::class, 'searchDoctor']);

//////   Appointment  //////
Route::post('/appointments/create', [AppointmentController::class, 'createAppointmentApi']);
Route::get('appointments/get/{id}', [AppointmentController::class, 'getAppointment']);
Route::get('appointments/user/{id}', [AppointmentController::class, 'getUserAppointments']);

/////   User   /////
Route::get('users/{id}', [UserController::class, 'getUser']);

/////   FAQs   /////
Route::get('faq/get', [FAQController::class, 'getAll']);