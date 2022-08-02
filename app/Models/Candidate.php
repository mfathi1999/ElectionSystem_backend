<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable =[
        'first-name',
        'last_name',
        'mobile',
        'national_code',
        'username',
        'password',
        'approved_by'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts=[
        'email_verified_at' => 'datetime',
    ];

}
