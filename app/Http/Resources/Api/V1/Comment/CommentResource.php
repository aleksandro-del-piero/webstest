<?php

namespace App\Http\Resources\Api\V1\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'user' => UserResource::make($this->user),
            'rating' => $this->rating,
            'published_at' => $this->published_at
        ];
    }
}
