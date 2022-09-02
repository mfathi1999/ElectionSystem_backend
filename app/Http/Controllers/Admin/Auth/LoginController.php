<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\VerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username' => ['required','string'],
            'password' => ['required','string'],
        ]);

        $admin = Admin::where('username',$request->username)->first();

        if(!$admin || ! Hash::check($admin->password , $request->password)){
            throw ValidationException::withMessages([
                'error' => ['The provided credentials are incorrect.'],
            ]);

        }

        return $admin->createToken('web',['role:admin'])->plainTextToken;
    }

    public function forgetPassword(){

    }

    public function verifyEmail(Request $request){
        $request->validate([
            'token' => ['required','integer'],
        ]);

        $admin = auth()->user();

        $verification = VerificationEmail::where('email',$admin->email)->first();

        if($verification){
            if(Hash::check($request->token ,$verification->token ) && now() <= $verification->expired_at){
                $admin = Admin::find($admin->id);
                $admin->email_verified_at = now();
                $admin->save();
                
                return CustomResponse::json(null,'your email verifed');
            }
        }

        return CustomResponse::json(null,'invalid token');
    }

    public function sendVerifyEmail()
    {
        return "verification email was sent";
    }
}
