<?php

namespace App\Http\Controllers\Voter\Auth;

use App\Enums\VoterStatus;
use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Mail\Registered;
use App\Models\VerificationEmail;
use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register(Request $request){
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

        // create new voter
        $new_voter = Voter::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make( $request->password),
            'status' => VoterStatus::UNAPPROVED,
        ]);

        // send confirmed email
        $this->sendEmail($new_voter);

        // make authentication email
        $token = $new_voter->createToken('web',['role:voter']);

        $data = [
            'user' => $new_voter,
            'token' => $token->plainTextToken,
        ];

        return CustomResponse::json($data,
                                    'registration successful. please check your email inbox for validation email');
    }

    public function sendEmail(Voter $voter){
        if($voter->email_verified_at != null){
            return CustomResponse::json(null,'email has already verified!');
        }

        // create token
        $email_verification = VerificationEmail::where('email',$voter->email);

        if($email_verification){
            $email_verification->delete();
        }

        $token = random_int(10000,99999);
        $email_verification = VerificationEmail::create([
            'email' => $voter->email,
            'token' => Hash::make($token),
            'expired_at' => now()->addMinutes(3),
        ]);

        Mail::to($voter)->send(new Registered($voter,$token));
    }

    public function verifyEmail(Request $request){
        $request->validate([
            'token' => ['required','integer'],
        ]);

        $voter = auth()->user();

        $verification = VerificationEmail::where('email',$voter->email)->first();

        if($verification){
            if(Hash::check($request->token,$verification->token)&& now() <= $verification->expired_at){
                $voter = Voter::find($voter->id);
                $voter->email_verified_at = now();
                $voter->save();
            }
        }

        return CustomResponse::json(null,'invalid token');
    }

    public function resendVerifiedEmail(){
        $voter = auth()->user();
        $this->sendEmail($voter);

        return CustomResponse::json(null,'verification code sent to your email');
    }
}
