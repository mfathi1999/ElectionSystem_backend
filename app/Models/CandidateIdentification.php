<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateIdentification extends Model
{
    use HasFactory;

    protected $fillable =[
        'first_name',
        'last_name',
        'national_code',
        'mobile',
        'email',
    ];

    protected $cast =[
        'email_verified_at' => 'datetime',
        'birthday_date' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];
}
