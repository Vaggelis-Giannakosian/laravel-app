<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content'];
    // blog_post_id
    //blogPost
    public function blogPost()
    {
        return $this->belongsTo('App\BlogPost');
    }
}
