<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\ThrottledMail;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUsersAboutCommentPosted
{


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        //sends immediately
//       Mail::to($post->user)->send( new CommentPostedMarkdown($comment) );

        //sends after specific time interval
//        $when = now()->addMinutes(1);
//       Mail::to($post->user)->later($when, new CommentPostedMarkdown($comment) );


        ThrottledMail::dispatch(
            new CommentPostedMarkdown($event->comment),
            $event->comment->commentable->user
        )->onQueue('high');

//        Mail::to($post->user)->queue( new CommentPostedMarkdown($comment) );

        NotifyUsersPostWasCommented::dispatch(
            $event->comment
        )->onQueue('low');
    }
}
