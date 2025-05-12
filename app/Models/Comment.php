<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['news_id', 'user_id', 'comment', 'published_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function news(): BelongsTo
    {
       return $this->belongsTo(News::class, 'news_id');
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null;
    }

    public function scopePublished($query): void
    {
        $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
