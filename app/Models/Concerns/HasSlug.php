<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

/**
 * Generates a unique `slug` from `title` when the model is first created.
 */
trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->slug)) {
                $model->slug = static::uniqueSlugFor($model->title);
            }
        });
    }

    protected static function uniqueSlugFor(?string $title): string
    {
        $base = Str::slug($title ?? '') ?: 'item';

        // Hindari slug yang bentrok dengan nama rute aksi sistem (seperti /berita/tulis, /acara/tambah)
        $reserved = ['tulis', 'tambah', 'create', 'edit', 'destroy', 'delete'];
        if (in_array(strtolower($base), $reserved, true)) {
            $base = "{$base}-1";
        }

        $slug = $base;
        $suffix = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
