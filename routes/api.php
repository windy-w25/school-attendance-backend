<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');

// Admin
Route::middleware(['auth:sanctum','admin'])->group(function () {
    Route::post('/students', [AdminController::class,'storeStudent']);
    Route::get('/students', [AdminController::class,'indexStudents']);
    Route::post('/teachers', [AdminController::class,'storeTeacher']);
    Route::get('/teachers', [AdminController::class,'indexTeachers']);
});

// Teacher
Route::middleware(['auth:sanctum','teacher'])->group(function () {
    Route::get('/classes/{className}/students', [AttendanceController::class,'studentsByClass']);
    Route::post('/attendance/mark', [AttendanceController::class,'markForClass']);
    // Route::get('/report/student/{studentId}', [ReportController::class,'studentReport']);
    // Route::get('/report/class', [ReportController::class,'classReport']);
    Route::get('/classes', [AttendanceController::class, 'classList']); 

});

// admin and teacher
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/report/student/{studentId}', [ReportController::class,'studentReport'])
        ->middleware('adminOrTeacher');
    Route::get('/report/class', [ReportController::class,'classReport'])
        ->middleware('adminOrTeacher');
});
