<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

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

}
