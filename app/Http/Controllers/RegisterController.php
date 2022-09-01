<?php

namespace App\Http\Controllers;

use App\Enums\CandidateStatus;
use App\Helpers\CustomResponse;
use App\Mail\Registered;
use App\Models\Candidate;
use App\Models\VerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
       
        // make authenticate token
        $token = $new_candiate->createToken('web',['role:candidate']);

        $data = [
            'user' => $new_candiate,
            'token' => $token->plainTextToken,
        ];
        return CustomResponse::json($data,
                                    'registration successful. please check your email inbox for validation email');
    }

    public function sendEmailCandidate(Candidate $candidate){
        if($candidate->email_verified_at != null){
            return CustomResponse::json(null,'email has been verified!');
        }

        //create token
        $email_verification = VerificationEmail::where('email',$candidate->email);
        if($email_verification){
            $email_verification->delete();
        }

        $token = random_int(10000,99999);
        $email_verification = VerificationEmail::create([
            'email' => $candidate->email,
            'token' => Hash::make( $token ),
            // 'token' => $token ,
            'expired_at' => now()->addMinutes(3),
        ]);

        // $url = sprintf("localhost/api/candidate/%s/?token=%s",[$candidate->id,$token]);
        Mail::to($candidate)->send(new Registered($candidate,$token));
    }

    public function verifyCandidateEmail(Request $request){

        $request->validate([
            'token' => ['required','integer'],
        ]);

        $candidate = auth()->user();

        $verification = VerificationEmail::where('email',$candidate->email)->first();


        if($verification){
            if(Hash::check($request->token ,$verification->token ) && now() <= $verification->expired_at){
                $candidate = Candidate::find($candidate->id);
                $candidate->email_verified_at = now();
                $candidate->save();

                return CustomResponse::json(null,'your email verifed');
            }
        }

        return CustomResponse::json(null,'invalid token');

    }
}
