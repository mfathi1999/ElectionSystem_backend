<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Candidate extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable =[
        'username',
        'password',
        'approved_by',
        'emaile',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts=[
        'email_verified_at' => 'datetime',
    ];

    public function Identification(){
        return $this->morphOne(Identification::class,'identificationable');
    }
}
