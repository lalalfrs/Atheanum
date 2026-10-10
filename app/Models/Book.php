<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'books';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'subtitle',
        'isbn',
        'author',
        'publisher',
        'category_id',
        'category',
        'year',
        'stock',
        'total_copies',
        'shelf_location',
        'status',
        'is_ebook',
        'ebook_pages',
        'ebook_content',
        'cover_image',
        'image_storage_path',
        'file_size_kb',
        'description',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'year' => 'integer',
        'stock' => 'integer',
        'total_copies' => 'integer',
        'is_ebook' => 'boolean',
        'ebook_pages' => 'integer',
        'file_size_kb' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi peminjaman buku.
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Accessor for full cover image URL.
     */
    protected function coverUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->cover_image)) {
                    return 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=600';
                }

                // If already full HTTP URL (CDN / cloud)
                if (str_starts_with($this->cover_image, 'http://') || str_starts_with($this->cover_image, 'https://')) {
                    return $this->cover_image;
                }

                // If storage relative path
                return Storage::disk('public')->url($this->cover_image);
            }
        );
    }

    /**
     * Model boot hooks.
     */
    protected static function booted(): void
    {
        // Auto-compute status before saving if not explicitly set
        static::saving(function (Book $book) {
            if ($book->stock <= 0) {
                $book->status = 'Habis';
            } elseif ($book->stock <= 3) {
                $book->status = 'Stok Kritis';
            } else {
                $book->status = 'Tersedia';
            }

            if (empty($book->total_copies) || $book->total_copies < $book->stock) {
                $book->total_copies = $book->stock;
            }
        });

        // Clean up stored image file upon deletion
        static::deleting(function (Book $book) {
            if ($book->cover_image && ! str_starts_with($book->cover_image, 'http')) {
                Storage::disk('public')->delete($book->cover_image);
            }
        });
    }

    /**
     * Relationship: Belongs to Category.
     */
    public function categoryRelation(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Scope: Critical stock (1 to 3 items).
     */
    public function scopeCriticalStock($query)
    {
        return $query->where('stock', '>', 0)->where('stock', '<=', 3);
    }

    /**
     * Scope: Out of stock (0 items).
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('stock', '<=', 0);
    }

    /**
     * Scope: Available stock (> 3 items).
     */
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 3);
    }

    /**
     * Scope: Dynamic multi-field search.
     */
    public function scopeSearch($query, ?string $term)
    {
        if (empty($term)) {
            return $query;
        }

        $clean = trim($term);

        return $query->where(function ($q) use ($clean) {
            $q->where('title', 'like', "%{$clean}%")
                ->orWhere('subtitle', 'like', "%{$clean}%")
                ->orWhere('author', 'like', "%{$clean}%")
                ->orWhere('isbn', 'like', "%{$clean}%")
                ->orWhere('publisher', 'like', "%{$clean}%")
                ->orWhere('shelf_location', 'like', "%{$clean}%")
                ->orWhere('category', 'like', "%{$clean}%");
        });
    }
}
