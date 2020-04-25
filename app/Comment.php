<?php

namespace App;

use App\Traits\Tagable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{

    use SoftDeletes,Tagable;


    protected $fillable = ['content','user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

}
