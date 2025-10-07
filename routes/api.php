<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Middleware\RoleMiddleware;

//  Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/logout',   [AuthController::class, 'logout'])->middleware('auth:sanctum');


//  Routes cho ADMIN
Route::middleware(['auth:sanctum', RoleMiddleware::class . ':admin'])->group(function () {
    Route::apiResource('classes', ClassesController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('subjects', SubjectController::class);
});


//  Routes cho TEACHER
Route::middleware(['auth:sanctum', RoleMiddleware::class . ':teacher'])->group(function () {
    Route::apiResource('subjects', SubjectController::class);
});


//  Routes cho STUDENT
// Route::middleware(['auth:sanctum', RoleMiddleware::class . ':student'])->group(function () {
//     Route::post('/classes/{class}/join', [ClassesController::class, 'join']);
// });
