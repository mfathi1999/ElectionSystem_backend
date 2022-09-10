<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;
    
    protected $fillable= [
        'title',
        'description',
        'started_at',
        'finished_at',
    ];

    public function files(){
        return $this->morphMany(File::class,'fileable');
    }
    
    public function candidates(){
        return $this->belongsToMany(Candidate::class,'election_candidates');
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }
}
