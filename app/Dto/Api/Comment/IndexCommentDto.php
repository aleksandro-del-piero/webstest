<?php

namespace App\Dto\Api\Comment;

class IndexCommentDto
{
    public ?int $user_id;
    public ?string $text;
    public int $page;
    public int $limit;
    public int $news_id;

    public function __construct(array $payload = [])
    {
        $this->news_id = $payload['news_id'];
        $this->user_id = $payload['user_id'] ?? null;
        $this->text = $payload['text'] ?? null;
        $this->page = $payload['page'] ?? 1;
        $this->limit = $payload['limit'] ?? config('comments.limit');
    }
}
