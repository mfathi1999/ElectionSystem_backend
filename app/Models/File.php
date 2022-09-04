<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\returnSelf;

class File extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'path',
    ];


    public function fileable(){
        return $this->morphTo();
    }
}
