<?php

namespace App\Traits;


use App\Tag;

trait Tagable
{

    protected static function bootTagable()
    {
        static::updating(fn($model)=>$model->tags()->sync(static::findTagsInContent($model->content)));
        static::created(fn($model)=>$model->tags()->sync(static::findTagsInContent($model->content)));
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable')->withTimestamps();
    }


    private static function findTagsInContent($content)
    {
        preg_match_all('/@([^@]+)@/m',$content, $tags);
        return Tag::whereIn('name',$tags[1] ?? [])->get();
    }

}
