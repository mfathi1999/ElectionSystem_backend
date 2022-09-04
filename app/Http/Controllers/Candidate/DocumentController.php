<?php

namespace App\Http\Controllers\Candidate;

use App\Enums\DocumentStatus;
use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    // index candidates documents
    public function index(){
        $candidate = auth()->user();

        $documents = $candidate->documents();

        return CustomResponse::json($documents);
    }

    // return a specific document
    public function show($id){
        $candidate = auth()->user();
        $document = $candidate->documents()->where('id' , $id)->first();

        if(! $document){
            return CustomResponse::json(null,'document not found',404);
        }

        return CustomResponse::json($document);
    }

    public function store(Request $request){
        $request->validate([
            'title' => ['required','string','min:3'],
            'description' => ['required','string','min:10'],
        ]);

        $candidate = auth()->user();

        $document  = $candidate->documents->create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => DocumentStatus::CHECK,
        ]);

        return CustomResponse::json($document,'documents stored successfuly');

        
    }
}
