<?php

namespace App\Http\Controllers\Voter;

use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index(){
        $voter = auth()->user();

        $votes = $voter->votes()->get();

        return CustomResponse::json($votes);
        
    }

    public function show($id){
        $voter = auth()->user();
        $vote = $voter->votes()->findOrFail($id);

        return CustomResponse::json($vote);
    }

    public function showByElection(Election $election){
        $voter = auth()->user();

        $vote = $voter->votes()->where('election_id',$election->id)->first();
        return CustomResponse::json($vote);
    }
    public function store(Election $election, Request $request){
        $request->validate([
            'candidate_id' => ['required','intiger','exists:candidates,column'],
        ]);

        $voter = auth()->user();

        // election not expired
        if($election->finished_at < now()){
            return CustomResponse::json(null,'Election has been finished',405);
        }

        // check voter votes this election before of not
        $vote = $voter->votes()->Where('election_id',$election->id)->get();

        if($vote){
            return CustomResponse::json(null,'You voted before!',405);
        }

        // create new vote
        $vote = new Vote;
        $vote->voter_id = $voter->id;
        $vote->election_id = $election->id;
        $vote->candidate_id = $request->candidate_id;
        
        $vote->save();

        return CustomResponse::json($vote,'Election Vote submited successfuly');
    }
}
