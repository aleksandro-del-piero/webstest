<?php

namespace App\Repositories;

use App\Dto\Api\Comment\CommentDto;
use App\Dto\Api\Comment\IndexCommentDto;
use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CommentRepository extends BaseRepository
{
    public function getModelClass(): string
    {
        return Comment::class;
    }

    public function create(CommentDto $dto): Comment
    {
        return $this->model->create([
            'user_id' => $dto->user_id,
            'news_id' => $dto->news_id,
            'comment' => $dto->comment,
            'published_at' => now()
        ]);
    }

    public function update(Comment $comment, CommentDto $dto): Comment
    {
        $comment->comment = $dto->comment;
        $comment->save();

        return $comment;
    }

    public function delete(int|Comment $comment): void
    {
        $comment = is_numeric($comment) ? $this->find($comment) : $comment;

        $comment->delete();
    }

    public function get(IndexCommentDto $dto): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with('user')
            ->where('news_id', $dto->news_id)
            ->when($dto->user_id, function ($query, $userId) use ($dto) {
                $query->where('user_id', $userId);
            })
            ->when($dto->text, function ($query) use ($dto) {
                $query->where('comment', 'LIKE', "%{$dto->text}%");
            })
            ->published()
            ->paginate(perPage: $this->sanitizePerPage($dto->limit), page: $dto->page);
    }

    protected function sanitizePerPage(?int $perPage): int
    {
        return min($perPage ?? 5, 20);
    }
}
