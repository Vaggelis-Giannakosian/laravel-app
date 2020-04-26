<?php

namespace App\Providers;

use App\BlogPost;
use App\Comment;
use App\Http\ViewComposers\ActivityComposer;
use App\Observers\BlogPostObserver;
use App\Observers\CommentObserver;
use App\Services\Counter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer(['posts.index','posts.show'],ActivityComposer::class);
//        view()->composer('*',ActivityComposer::class); available to all views

        BlogPost::observe(BlogPostObserver::class);
        Comment::observe(CommentObserver::class);

        $this->app->singleton(Counter::class, function($app){
            return new Counter(
                $app->make('Illuminate\Contracts\Cache\Factory'),
                $app->make('Illuminate\Contracts\Session\Session'),
                env('COUNTER_TIMEOUT',3)
            );
        });

//        $this->app->when(Counter::class)->needs('$timeout')->give(env('COUNTER_TIMEOUT',3));
    }
}
