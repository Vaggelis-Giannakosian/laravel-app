<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = ['title'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

}
