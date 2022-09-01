<?php

namespace App\Http\Controllers;

use App\Helpers\CustomResponse;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //
    public function loginCandidate(Request $request){
        $request->validate([
            'username' => ['required','string'],
            'password' => ['required','string']
        ]);

        $candidate = Candidate::where('username',$request->username)->first();

        if(! $candidate || $candidate->password != $request->password){
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }
        
        return $candidate->createToken('web',['role:candidate'])->plainTextToken;
    }

    public function logoutCandidate(){
        $candidate = auth()->user();
        $candidate->tokens()->delete();
        
        return CustomResponse::json('goodbye');
    }
}
