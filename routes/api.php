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
    //Update Status Kredit
    Route::post('/kredit/{id}', [App\Http\Controllers\Api\KreditController::class,'kredit']);

    //Profile
    Route::get('/profile', [App\Http\Controllers\Api\AuthController::class,'index']);
    
    //Kredit
    Route::post('/kredit', [App\Http\Controllers\Api\KreditController::class,'store']);
    Route::get('/kredit', [App\Http\Controllers\Api\KreditController::class,'index']);

    //Pembayaran token listrik
    Route::get('/pembayaran', [App\Http\Controllers\Api\BayarListrikController::class, 'index']);
    Route::get('/pembayaran{id}', [App\Http\Controllers\Api\BayarListrikController::class, 'show']);
    Route::post('/pembayaran', [App\Http\Controllers\Api\BayarListrikController::class, 'store']);
    Route::delete('/pembayaran{id}', [App\Http\Controllers\Api\BayarListrikController::class, 'destroy']);
    
});