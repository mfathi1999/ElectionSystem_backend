<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login',[App\Http\Controllers\Admin\Auth\LoginController::class,'login'])->name('admin.login');
Route::post('forget-password',[\App\Http\Controllers\Admin\Auth\LoginController::class,'forgetPassword'])->name('admin-forget-password');

Route::middleware(['auth:sanctum','type.admin'])->group(function(){

    Route::post('verify-email',[\App\Http\Controllers\Admin\Auth\LoginController::class,'verifyEmail'])->name('admin.email.verify');
    Route::get('send-verify-email',[\App\Http\Controllers\Admin\Auth\LoginController::class,'sendVerifyEmail'])->name('admin.send.verify.email');
    
});