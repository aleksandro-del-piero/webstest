<?php

namespace App\Dto\Api\Comment;

class CommentDto
{
    public function __construct(public int $news_id, public int $user_id, public string $comment)
    {
    }
}
