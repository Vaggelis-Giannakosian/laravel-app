<?php

namespace App\Providers;

use App\Events\BlogPostCreated;
use App\Events\CommentPosted;
use App\Listeners\CacheSubscriber;
use App\Listeners\NotifyAdminWhenPostCreated;
use App\Listeners\NotifyUsersAboutCommentPosted;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CommentPosted::class => [
            NotifyUsersAboutCommentPosted::class
        ],
        BlogPostCreated::class => [
            NotifyAdminWhenPostCreated::class
        ],
    ];

    protected $subscribe = [
        CacheSubscriber::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
