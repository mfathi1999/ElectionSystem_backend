<?php

namespace App\Http\Controllers;

use App\Enums\CandidateStatus;
use App\Helpers\CustomResponse;
use App\Mail\Registered;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function registerCandidate(Request $request){
        // validate request
        $request->validate([
            'email' => ['required','email:rfc,dns','unique:candidates'],
            'username' => ['required','string','unique:candidates','min:5'],
            'password' => ['required','string','confirmed',Password::min(8)
                                                                    ->letters()
                                                                    ->mixedCase()
                                                                    ->numbers()
                                                                    ->symbols()
                            ],
        ]);

        // create new candidate
        $new_candiate = Candidate::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'status' => CandidateStatus::UNAPPROVED,
        ]);

        // send confirmed email
        $this->sendEmailCandidate($new_candiate);
        //return data and 

        return CustomResponse::json($new_candiate,
                                    'registration successful. please check your email inbox for validation email');
    }

    public function sendEmailCandidate(Candidate $candidate){
        if($candidate->email_verified_at != null){
            return CustomResponse::json(null,'email has been verified!');
        }

        Mail::to($candidate)->send(new Registered($candidate,'https://google.com'));
    }

    public function emailVerifyCandidate(Request $request){

        return $request->all();

    }
}
