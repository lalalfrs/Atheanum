<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Database\Factories\NewsFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'title', 'slug', 'excerpt', 'body', 'published_at'])]
class News extends Model
{
    /** @use HasFactory<NewsFactory> */
    use HasFactory, HasSlug;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param  Builder<News>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('published_at', '<=', now())->latest('published_at');
    }
}
