<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(){
        $elections = Election::all();

        return CustomResponse::json($elections);
    }
    
    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id){
        $election = Election::findOrFail($id);

        return CustomResponse::json($election);
    }

    public function store(Request $request){
        // request validation
        $request->validate([
            'title' => ['required','string','min:3','max:191'],
            'description' => ['required','string','min:10'],
            'started_at' => ['required','date_format:Y-m-d H:i:s'],
            'finished_at' => ['required','date_format:Y-m-d H:i:s'],
        ]);

        $election = Election::create([
            'title' => $request->title,
            'description' => $request->description,
            'started_at' => $request->started_at,
            'finished_at' => $request->finished_at,
        ]);

        return CustomResponse::json($election,'Election created succesfuly');
        
    }

    public function addCandidate(Election $election,Candidate $candidate){
        $election->candidates()->attach($candidate);

        return CustomResponse::json(null,'candidate added to elecction');

    }

    public function removeCandidate(Election $election,Candidate $candidate){
        $election->candidates()->detach($candidate);

        return CustomResponse::json(null,'candidate removed from election');
    }
}
