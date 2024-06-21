<?php
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\PatientController;
 
Route::post('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('login', [AuthenticationController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::resource('/patient', PatientController::class);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/patients-bar-data', [PatientController::class, 'getData']);
    Route::post('/patients-chart-data', [PatientController::class, 'index']);
});