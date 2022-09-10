<?php

namespace App\Http\Controllers\Voter;

use App\Enums\IdentificationStatus;
use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IdentificationController extends Controller
{
    public function show(){
        $voter = auth()->user();
        $identification = $voter->identification()->firstOrFail();
        
        return CustomResponse::json($identification);
    }

    public function store(Request $request){
        //validates inputs
        $request->validate([
            'first_name' => ['required','string'],
            'last_name' => ['required','string'],
            'national_code' => ['required','string'],
            'birthday_date' => ['required','date_format:Y-m-d'],
            // TODO add regex validation for phone number
            'mobile' => ['required','string','min:11','max:11'],
        ]);
        
        $voter = auth()->user();
        $identification = $voter->identification()->first();

        if($identification){
            return CustomResponse::json($identification,'identification already exist',405);
        }
            
        $identification = $voter->identification()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
            // TODO convert birthday_date from jalali to datetime.
            'birthday_date' => $request->birthday_date,
            'mobile' => $request->mobile,
            'status' => IdentificationStatus::CHECK,
        ]);

        return CustomResponse::json($identification,'your identification stored successfuly. please wating for admin decision');




        
    }
}
