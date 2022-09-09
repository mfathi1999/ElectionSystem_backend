<?php

namespace App\Http\Controllers\Voter\Auth;

use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Models\Voter;
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

        $voter = Voter::where('username',$request->username)->first();

        if(! $voter || ! Hash::check($request->password , $voter->password)){
            throw ValidationException::withMessages([
                'error' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $voter->createToken('web',['role:voter'])->plainTextToken;
    }

    public function logout(){
        $voter = auth()->user();
        $voter->tokens()->delete();

        return CustomResponse::json('goodbye');
    }
}
