<?php

namespace App\Http\Controllers;

use App\Enums\CandidateStatus;
use App\Helpers\CustomResponse;
use App\Models\Candidate;
use Illuminate\Http\Request;
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


        //return data and 

        return CustomResponse::json($new_candiate,
                                    'registration successful. please check your email inbox for validation email');
    }
}
