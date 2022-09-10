<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable =[];

    public function election(){
        return $this->belongsTo(Election::class);
    }

    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }

    public function voter(){
        return $this->belongsTo(Voter::class);
    }


}
