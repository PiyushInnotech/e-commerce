<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
    ];

    public $timestamps = true;

}
