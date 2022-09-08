<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentStatus;
use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    // index all documents
    public function index(){
        $documnets  = Document::all();

        return CustomResponse::json($documnets);
    }

    // index all documents related to specific candidate
    public function indexByCandidate(Candidate $candidate){
        $documnets = $candidate->documents();

        return CustomResponse::json($documnets);
    }

    public function show($id){
        $document = Document::find($id);
        
        if(! $document){
            return CustomResponse::json($document,null,404);
        }

        return CustomResponse::json($document);
    }

    public function accept(Document $document){
        $admin = auth()->user();

        $document->update([
            'status' => DocumentStatus::ACCEPT,
            'changed_status_at' => now(),
            'changed_status_by' => $admin->id,
        ]);

        return CustomResponse::json($document,'accept successfuly');
    }

    public function reject(Document $document){
        $admin = auth()->user();

        $document->update([
            'status' => DocumentStatus::REJECT,
            'changed_status_at' => now(),
            'changed_status_by' => $admin->id,
        ]);
        return CustomResponse::json($document,'document rejected');
    }
}
