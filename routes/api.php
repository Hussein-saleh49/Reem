<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LoginnController;
use App\Http\Controllers\Auth\RegisterationController;   
use App\Http\Controllers\devicecontroller;
use App\Http\Controllers\dummyapi;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post("/register",[RegisterationController::class,"register"]);
Route::post("/login",[LoginController::class,"__invoke"]);

// Route::get("auth/facebook",[SocialController::class,"redirectToFacebook"]);
// Route::get("auth/facebook/callback",[SocialController::class,"handleFacebookCallback"]);





Route::post('/send-otp', [PasswordResetController::class, 'SendOtp']);
Route::post('/resend-otp', [PasswordResetController::class, 'resendOtp']);
Route::post('/verify-otp', [PasswordResetController::class, 'verifyOtp']);
Route::post('/create-password', [PasswordResetController::class, 'createNewPassword']);


//home page
//get current address
Route::middleware('auth:sanctum')->get('/user/address', [AddressController::class, 'getAddress']);
//update address
Route::middleware('auth:sanctum')->post('/user/address', [AddressController::class, 'updateAddress']);
//search
Route::get('/search', [MedicationController::class, 'search']);
Route::get('/top-searches', [MedicationController::class, 'topSearches']);

//add,skip and show appointment

Route::middleware('auth:sanctum')->group(function () {
    // Fetch today's appointments
    Route::get('/appointments/today/{userId}', [AppointmentController::class, 'getTodayAppointments']);

    // Add a measurement
    Route::post('/measurements/add', [AppointmentController::class, 'addMeasurement']);

    // Skip an appointment
    Route::post('/appointments/skip/{appointmentId}', [AppointmentController::class, 'skipAppointment']);
});

// Route to add a new reminder
Route::post('/reminders/add', [ReminderController::class, 'addReminder']);

// Route to get all reminders for a specific user
Route::get('/reminders/user/{userId}', [ReminderController::class, 'getUserReminders']);

// Route to skip a specific reminder
Route::post('/reminders/{reminderId}/skip', [ReminderController::class, 'skipReminder']);

//nearby pharmacies
Route::get('/pharmacies/nearby', [PharmacyController::class, 'getNearbyPharmacies']);

//get all pharmacies
Route::get("/pharmacies", [PharmacyController::class, "getAllPharmacies"]);

//chatbot


Route::post('/chatbot', [ChatController::class, '__invoke']);









