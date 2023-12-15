<?php

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

Route::post('/register',[App\Http\Controllers\Api\AuthController::class,'register']);
Route::post('/login',[App\Http\Controllers\Api\AuthController::class,'login']);

Route::middleware('auth:api')->group(function(){
    //Admin
    Route::get('/rekening',[App\Http\Controllers\Api\RekeningController::class,'index']);
    Route::post('/rekening',[App\Http\Controllers\Api\RekeningController::class,'store']);
    Route::get('/rekening/{id}',[App\Http\Controllers\Api\RekeningController::class,'show']);
    Route::put('/rekening/{id}',[App\Http\Controllers\Api\RekeningController::class,'update']);
    Route::delete('/rekening/{id}',[App\Http\Controllers\Api\RekeningController::class,'destroy']);


});