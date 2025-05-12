<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendModeratorNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentCreated $event): void
    {
        logger('send moderator notification about new comment', [
            'comment' => $event->message->comment,
            'user_id' => $event->message->user_id,
            'news_id' => $event->message->news_id,
        ]);
    }
}
