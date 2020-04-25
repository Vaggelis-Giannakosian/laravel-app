<?php

namespace App\Listeners;

use App\Events\BlogPostCreated;
use App\Jobs\ThrottledMail;
use App\Mail\PostAdded;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminWhenPostCreated
{


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BlogPostCreated $event)
    {
        User::thatIsAnAdmin()->get()->each(fn($user)=> ThrottledMail::dispatch(new PostAdded(), $user) );
    }

}
