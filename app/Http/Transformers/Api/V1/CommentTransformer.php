<?php

namespace App\Http\Transformers\Api\V1;

use App\Http\Resources\Api\V1\Comment\CommentResource;
use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentTransformer
{
    public function handle(LengthAwarePaginator $comments): LengthAwarePaginator
    {
        return $comments->through(fn(Comment $comment) => CommentResource::make($comment));
    }
}
