<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CandidateStatus;
use App\Enums\IdentificationStatus;
use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Identification;
use App\Models\Voter;
use Illuminate\Http\Request;

class IdentificationController extends Controller
{
    public function index(){
        $identifications = Identification::all();
        return CustomResponse::json($identifications);
    }

    public function show($id){
        $identification = Identification::find($id);
        if(! $identification){
            return CustomResponse::json($identification,null,404);
        }

        return CustomResponse::json($identification);
    }

    public function showByCandidate(Candidate $candidate){
        $identification = $candidate->identification()->first();
        
        if(! $identification){
            return CustomResponse::json($identification,null,404);
        }

        return CustomResponse::json($identification);
    }

    public function showByVoter(Voter $voter){
        $identification = $voter->identification()->first();

        if(! $identification){
            return CustomResponse::json($identification,null,404);
        }

        return CustomResponse::json($identification);
    }

    public function acceptIdentification(Identification $identification , Request $request){
        // validate request
        $request->validate([
            'description' => ['required','string'],
        ]);

        // get admin user
        $admin = auth()->user();

        // change identification status
        $identification->status = IdentificationStatus::ACCEPT;
        // save admin description
        $identification->description = $request->description;
        $identification->save();

        // approve candidate
        $candidate = $identification->Identificationable;
        $candidate->status = CandidateStatus::APPROVED;
        $candidate->approved_by = $admin->id;
        $candidate->save();
    

        return CustomResponse::json($identification,'user identification accepted');
    }

    public function rejectIdentification(Identification $identification , Request $request){
        // validate request
        $request->validate([
            'description' => ['required','string'],
        ]);

        // get admin user
        $admin = auth()->user();
        //change identification status
        $identification->status = IdentificationStatus::REJECT;
        // save admin description
        $identification->description = $request->description;
        $identification->save();


        return CustomResponse::json($identification,'user identification rejected');

    }

    public function backToEditIdentification(Identification $identification , Request $request){
        // validate request
        $request->validate([
            'description' => ['required','string'],
        ]);

        // get admin user
        $admin = auth()->user();
        //change identification status
        $identification->status = IdentificationStatus::EDIT;
        // save admin description
        $identification->description = $request->description;
        $identification->save();

        return CustomResponse::json($identification,'user identification returned for editing by user');

    }
}
