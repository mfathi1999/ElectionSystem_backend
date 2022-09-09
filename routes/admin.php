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
    
    // identification routes
    Route::get('identifications',[\App\Http\Controllers\Admin\IdentificationController::class,'index'])->name('admin.identification.index');
    Route::get('identification/{id}',[\App\Http\Controllers\Admin\IdentificationController::class,'show'])->name('admin.identification.show');
    Route::get('identification/candidate/{candidate}',[\App\Http\Controllers\Admin\IdentificationController::class,'showByCandidate'])->name('admin.identification.show.candidate');
    // TODO add route for voter identification
    Route::post('identification/accept/{identification}',[\App\Http\Controllers\Admin\IdentificationController::class,'acceptIdentification'])->name('admin.identification.accept');
    Route::post('identification/reject/{identification}',[\App\Http\Controllers\Admin\IdentificationController::class,'rejectIdentification'])->name('admin.identification.accept');
    Route::post('identification/edit/{identification}',[\App\Http\Controllers\Admin\IdentificationController::class,'backToEditIdentification'])->name('admin.identification.accept');

    // documents routs
    Route::get('documents',[App\Http\Controllers\Admin\DocumentController::class,'index'])->name('admin.document.index');
    Route::get('documents/{candidate}',[App\Http\Controllers\Admin\DocumentController::class,'indexByCandidate'])->name('admin.document.index.candidate');
    Route::get('document/{id}',[App\Http\Controllers\Admin\DocumentController::class,'show'])->name('admin.document.show');

    Route::put('document/accept/{document}',[App\Http\Controllers\Admin\DocumentController::class,'accept'])->name('admin.document.accept');
    Route::put('document/reject/{document}',[App\Http\Controllers\Admin\DocumentController::class,'reject'])->name('admin.document.reject');
    
    
    // Election routes
    Route::get('elections',[App\Http\Controllers\Admin\ElectionController::class,'index'])->name('admin.election.index');
    Route::get('election/{id}',[App\Http\Controllers\Admin\ElectionController::class,'show'])->name('admin.election.show');
    Route::post('election',[App\Http\Controllers\Admin\ElectionController::class,'store'])->name('admin.election.store');
    Route::put('election/add-candidate/{election}/candidate/{candidate}',[\App\Http\Controllers\Admin\ElectionController::class,'addCandidate'])->name('admin.election.add.candidate');
    Route::put('election/remove-candidate/{election}/candidate/{candidate}',[\App\Http\Controllers\Admin\ElectionController::class,'removeCandidate'])->name('admin.election.remove.candidate');

    // Candidate routes
    Route::get('candidates',[\App\Http\Controllers\Admin\CandidateController::class,'index'])->name('admin.candidate.index');
    Route::get('candidate/{id}',[App\Http\Controllers\Admin\CandidateController::class,'show'])->name('admin.candidate.show');
});