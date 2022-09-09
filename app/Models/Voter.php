<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voter extends User
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'email',
        'status',
        'changed_status_by',
    ];

    public function identification(){
        return $this->morphOne(Identification::class,'identificationable');
    }
}
