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
        'status',
        'changed_status_at',
        'changed_status_by',
    ];


    public function files(){
        return $this->morphMany(File::class,'fileable');
    }

    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }
}
