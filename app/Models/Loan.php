<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    /** Denda keterlambatan dalam Rupiah per hari. */
    public const DAILY_FINE_RATE = 1000;

    /** Jumlah maksimal buku yang boleh dipinjam bersamaan oleh satu anggota. */
    public const MAX_ACTIVE_LOANS = 3;

    /** Durasi standar peminjaman dalam hari. */
    public const LOAN_DURATION_DAYS = 7;

    /** Tambahan hari setiap kali perpanjangan. */
    public const RENEWAL_DAYS = 7;

    /** Jumlah maksimal perpanjangan per peminjaman. */
    public const MAX_RENEWALS = 1;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'fine_amount',
        'fine_paid',
        'fine_paid_at',
        'renewed_count',
        'notes',
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_date' => 'date',
        'returned_at' => 'date',
        'fine_paid_at' => 'date',
        'fine_paid' => 'boolean',
        'fine_amount' => 'integer',
        'renewed_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'dipinjam');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'dipinjam')
            ->where('due_date', '<', now()->toDateString());
    }

    public function isOverdue(): bool
    {
        if ($this->status === 'dipinjam') {
            return $this->due_date && $this->due_date->isPast();
        }

        if ($this->returned_at && $this->due_date) {
            return $this->returned_at->isAfter($this->due_date);
        }

        return false;
    }

    public function getOverdueDaysAttribute(): int
    {
        if (! $this->due_date) {
            return 0;
        }

        $compareDate = $this->status === 'dikembalikan' && $this->returned_at
            ? $this->returned_at
            : now()->startOfDay();

        $diff = (int) $this->due_date->startOfDay()->diffInDays($compareDate, false);

        return max(0, $diff);
    }

    public function getCurrentFineAttribute(): int
    {
        if ($this->status === 'dikembalikan') {
            return $this->fine_amount;
        }

        return $this->overdue_days * self::DAILY_FINE_RATE;
    }
}
