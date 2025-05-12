<?php

namespace App\Http\Requests\Api\V1\Comment;

use App\Dto\Api\Comment\IndexCommentDto;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'text' => ['nullable', 'string'],
            'page' => ['nullable', 'integer', 'min:1'],
            'limit' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function getDto(): IndexCommentDto
    {
        return new IndexCommentDto([...$this->validated(), 'news_id' => $this->news->id]);
    }
}
