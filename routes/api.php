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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// candidates routes
Route::prefix('candidate')->group(function () {
    
    Route::post('login',[\App\Http\Controllers\LoginController::class,'loginCandidate']);
    Route::post('register',[\App\Http\Controllers\RegisterController::class,'registerCandidate']);
    
    Route::group(['middleware' => ['auth:sanctum','type.candidate']],function(){
        
        Route::post('logout',[\App\Http\Controllers\LoginController::class,'logoutCandidate']);
        Route::post('email-verify',[\App\Http\Controllers\RegisterController::class,'verifyCandidateEmail']);

        // email verification
        Route::get('resend-verification-email',[\App\Http\Controllers\RegisterController::class,'resendCandidateVerifyEmail']);
    });
});