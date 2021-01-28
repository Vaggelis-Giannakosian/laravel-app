<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    public const LOCALES = [
        'en' => 'English',
        'el' => 'Ελληνικά',
        'de' => 'Deutch'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function generateToken($email,$password)
    {
        $credentials = ['email'=>$email,'password' => $password];
        return JWTAuth::attempt($credentials);
    }


    public function posts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function commentsOn()
    {
        return $this->morphMany('App\Comment','commentable')->latest();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function thumb()
    {
        return $this->morphOne(Image::class,'imageable');
    }

    public function scopeWithMostBlogPosts(Builder $query)
    {
        return $query->withCount('posts')->orderBy('posts_count','desc');
    }


    public function scopeWithMostPostsLastMonth(Builder $query)
    {
        return $query->withCount(['posts'=>function(Builder $query){
            $query->whereBetween(static::CREATED_AT,[now()->subMonths(1),now()]);
        }])->having('posts_count','>=',2)->groupBy('id')->orderBy('posts_count','desc');
    }

    public function scopeThatHasCommentedOnPost(Builder $query, BlogPost $post)
    {
        return $query->whereHas('comments',function ($query) use ($post){
            return $query
                ->where('commentable_id', '=', $post->id)
                ->where('commentable_type', '=', BlogPost::class);
        });
    }


    public function scopeThatIsAnAdmin(Builder $query)
    {
        return $query->where('is_admin',true);
    }


}
