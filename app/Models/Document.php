<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'candidate_id', 
        'description',
        'status'
    ];


    public function files(){
        return $this->morphMany(File::class,'fileable');
    }

    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }
}
