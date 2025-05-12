<?php

namespace App\Http\Requests\Api\V1\Comment;

use App\Dto\Api\Comment\CommentDto;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'comment' => ['required', 'string']
        ];
    }

    public function getDto(): CommentDto
    {
        return new CommentDto($this->news->id, $this->user()->id, $this->comment);
    }
}
