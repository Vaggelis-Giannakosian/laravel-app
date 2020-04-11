<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{

    use SoftDeletes;


    protected $fillable = ['content'];
    // blog_post_id
    //blogPost
    public function blogPost()
    {
        return $this->belongsTo('App\BlogPost');
    }
}
