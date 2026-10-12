<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Database\Factories\LibraryEventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'title', 'slug', 'description', 'location', 'starts_at', 'ends_at'])]
class LibraryEvent extends Model
{
    /** @use HasFactory<LibraryEventFactory> */
    use HasFactory, HasSlug;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Acara yang belum selesai, diurutkan dari yang paling dekat.
     *
     * @param  Builder<LibraryEvent>  $query
     */
    public function scopeUpcoming(Builder $query): void
    {
        $query->where(function (Builder $inner): void {
            $inner->where('starts_at', '>=', now()->startOfDay())
                ->orWhere('ends_at', '>=', now());
        })->orderBy('starts_at');
    }

    /**
     * @param  Builder<LibraryEvent>  $query
     */
    public function scopePast(Builder $query): void
    {
        $query->where('starts_at', '<', now()->startOfDay())
            ->where(fn (Builder $inner) => $inner->whereNull('ends_at')->orWhere('ends_at', '<', now()))
            ->latest('starts_at');
    }
}
