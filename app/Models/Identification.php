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
        'birthday_date',
        'status',
    ];

    protected $cast =[
        'birthday_date' => 'datetime',
    ];

    public function Identificationable(){
        return $this->morphTo();
    }
}
