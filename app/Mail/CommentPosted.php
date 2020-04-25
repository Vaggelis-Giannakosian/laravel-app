<?php

namespace App\Mail;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;


    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
//            ->attach(
//                storage_path('app/public').'/'.$this->comment->user->thumb->path,
//                [
//                    'as' => 'profile_picture.jpeg',
//                    'mime' => 'image/jpeg'
//                ]
//            )
//            ->attachFromStorage($this->comment->user->thumb->path,'profile_picture.jpeg')
//            ->attachFromStorageDisk('public',$this->comment->user->thumb->path,'profile_picture.jpeg')
//            ->attachData(Storage::get($this->comment->user->thumb->path),'profile_picture.jpeg',[
//                'mime' => 'image/jpeg'
//            ])
            ->subject("Comment was posted on '{$this->comment->commentable->title}' post")
            ->from('admin@udemyapp.test','Admin')
            ->view('emails.posts.commented');
    }
}
