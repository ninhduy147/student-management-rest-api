<?php

use App\Http\Controllers\ClassesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

ROUTE::get('/',function (){
    return 'Hello world';
});

Route::apiResource('classes', ClassesController::class);
