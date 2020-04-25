<?php

namespace App\Jobs;

use App\Comment;
use App\Mail\CommentPostedOnPostWatched;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyUsersPostWasCommented implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       User::thatHasCommentedOnPost($this->comment->commentable)
           ->get()
           ->filter(fn (User $user) => $user->id !== $this->comment->user->id)
           ->each(fn(User $user)=> Mail::to($user)->send( new CommentPostedOnPostWatched($this->comment, $user) ) );
    }
}
