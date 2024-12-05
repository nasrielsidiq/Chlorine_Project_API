<?php

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/auth/login', [AuthApiController::class, 'login']);
Route::get('/auth/logout', [AuthApiController::class, 'logout']);
Route::get('/home', [StudentController::class, 'home']);
Route::post('/absence', [StudentController::class, 'absence']);
Route::get('/absence/history', [StudentController::class, 'history']);
Route::get('/task', [StudentController::class, 'task']);
Route::get('/setings', [StudentController::class, 'setings']);
Route::get('/profile/get', [StudentController::class, 'getProfile']);
Route::post('/profile/update', [StudentController::class, 'updateProfile']);
Route::get('/user/get', [StudentController::class, 'getStudent']);
Route::post('/user/update', [StudentController::class, 'updateStudent']);
