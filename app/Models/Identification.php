<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
    use HasFactory;

    protected $fillable =[
        'first_name',
        'last_name',
        'national_code',
        'mobile',
    ];

    protected $cast =[
        'birthday_date' => 'datetime',
    ];

}
