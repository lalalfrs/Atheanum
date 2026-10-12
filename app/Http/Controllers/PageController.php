<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about', [
            'policy' => $this->circulationPolicy(),
            'collection' => [
                'titles' => Book::count(),
                'copies' => (int) Book::sum('stock'),
                'ebooks' => Book::where('is_ebook', true)->count(),
                'categories' => Book::distinct('category')->count('category'),
            ],
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'contact' => config('library.contact'),
            'mapQuery' => config('library.map_query'),
        ]);
    }

    public function librarians(): View
    {
        return view('pages.librarians', [
            'librarians' => User::staff()->orderBy('name')->get(),
        ]);
    }

    public function help(): View
    {
        return view('pages.help', [
            'policy' => $this->circulationPolicy(),
            'contact' => config('library.contact'),
        ]);
    }

    public function cjs(): View
    {
        return view('pages.cjs', [
            'programs' => config('library.cjs', []),
        ]);
    }

    /**
     * @return array{duration: int, max_loans: int, renewal_days: int, max_renewals: int, fine: int}
     */
    private function circulationPolicy(): array
    {
        return [
            'duration' => Loan::LOAN_DURATION_DAYS,
            'max_loans' => Loan::MAX_ACTIVE_LOANS,
            'renewal_days' => Loan::RENEWAL_DAYS,
            'max_renewals' => Loan::MAX_RENEWALS,
            'fine' => Loan::DAILY_FINE_RATE,
        ];
    }
}
