<?php


namespace App\Http\ViewComposers;


use App\BlogPost;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
    public function compose(View $view)
    {
        $mostCommented = Cache::tags(['blog-post'])->remember('blog-post-most-commented', 600, function () {
            return BlogPost::mostCommented()->take(5)->get();
        });
        $mostActive = Cache::tags(['blog-post'])->remember('users-most-active', 600, function () {
            return User::withMostBlogPosts()->take(5)->get();
        });
        $mostActiveLastMonth = Cache::tags(['blog-post'])->remember('users-most-active-last-month', 600, function () {
            return User::withMostPostsLastMonth()->take(5)->get();
        });


        $view->with('mostCommented',$mostCommented);
        $view->with('mostActive',$mostActive);
        $view->with('mostActiveLastMonth',$mostActiveLastMonth);
    }

}
