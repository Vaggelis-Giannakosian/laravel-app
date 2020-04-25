<?php

namespace App;

use App\Scopes\DeletedAdminScope;
use App\Traits\Tagable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{

    use SoftDeletes,Tagable;

    protected $fillable = ['title','content','user_id'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function scopeOwn(Builder $query){
        return $query->where('user_id',auth()->user()->id);
    }

    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count','desc');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment','commentable')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function thumb()
    {
        return $this->morphOne(Image::class,'imageable');
    }

    public function scopeLastestWithRelations(Builder $query)
    {
        return $query->latest()->with(['user','tags','comments']);
    }


    //HANDLING MODEL EVENTS
    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope());
        parent::boot();
    }



}
