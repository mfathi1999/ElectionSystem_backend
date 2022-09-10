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

        // upload identification
        Route::get('identification',[\App\Http\Controllers\Candidate\IdentificationController::class,'show'])->name('candidate.identification.show');
        // TODO add updating(editing) identifications
        Route::post('identification',[\App\Http\Controllers\Candidate\IdentificationController::class,'store'])->name('candidate.identification.store');

        // upload documents
        Route::get('documents',[App\Http\Controllers\Candidate\DocumentController::class,'index'])->name('candidate.document.index');
        Route::get('document/{id}',[App\Http\Controllers\Candidate\DocumentController::class,'show'])->name('candidate.document.show');
        Route::post('document',[App\Http\Controllers\Candidate\DocumentController::class,'store'])->name('candidate.document.store');

        // uplodad files for documents
        //TODO develope file storing functions
    });
});

Route::prefix('voter')->group(function(){
    // login routes
    Route::post('login',[App\Http\Controllers\Voter\Auth\LoginController::class,'login'])->name('voter.login');
    Rote::post('register',[App\Http\Controllers\Voter\Auth\RegisterController::class,'register'])->name('voter.register');
    
    Route::group(['middleware' => ['auth:sanctum','type.voter']], function(){
        
        Route::post('logout',[App\Http\Controllers\Voter\Auth\LoginController::class,'logout'])->name('voter.logout');
        Route::post('email-verify',[App\Http\Controllers\Voter\Auth\RegisterController::class,'verifyEmail'])->name('voter.verify.email');

        Route::get('resend-verification-email',[App\Http\Controllers\Voter\Auth\RegisterController::class,'resendVerifiedEmail'])->name('voter.resend.verify.email');

        Route::get('identification',[App\Http\Controllers\Voter\IdentificationController::class,'show'])->name('voter.identification.show');
        Route::post('identification',[App\Http\Controllers\Voter\IdentificationController::class,'store'])->name('voter.identification.store');

        // Voting routes
        Route::get('votes',[App\Http\Controllers\Voter\VoteController::class,'index'])->name('voter.vote.index');
        Route::get('vote/{id}',[App\Http\Controllers\Voter\VoteController::class,'show'])->name('voter.vote.show');
        Route::get('election/{election}/vote',[App\Http\Controllers\Voter\VoteController::class,'showByElection'])->name('voter.vote.showByElection');
        Route::post('election/{election}/vote',[App\Http\Controllers\Voter\VoteController::class,'store'])->name('voter.vote');
        
    });
});