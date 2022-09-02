<?php

namespace App\Http\Controllers\Candidate;

use App\Enums\IdentificationStatus;
use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Models\Identification;
use Illuminate\Http\Request;
use Hekmatinasser\Verta\Verta;

class IdentificationController extends Controller
{
    public function show(){
        $candidate = auth()->user();
        $identification = $candidate->identification()->firstOrFail();
        
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
        
        $candidate = auth()->user();
        $identification = $candidate->identification()->first();

        if($identification){
            return CustomResponse::json($identification,'identification already exist',405);
        }
            
        $identification = $candidate->identification()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
            'birthday_date' => $request->birthday_date,
            'mobile' => $request->mobile,
            'status' => IdentificationStatus::CHECK,
        ]);

        return CustomResponse::json($identification,'your identification stored successfuly. please wating for admin decision');




        
    }
}
