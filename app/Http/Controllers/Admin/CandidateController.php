<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(){
        $Candidates =Candidate::all();
        return CustomResponse::json($Candidates);
    }

    public function show($id){
        $Candidate = Candidate::findOrFail($id);

        return CustomResponse::json($Candidate);
    }
}
