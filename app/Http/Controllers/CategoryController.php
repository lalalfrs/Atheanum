<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display categories and DDC Dewey classification.
     */
    public function index()
    {
        $categories = Category::with(['books' => function ($q) {
            $q->take(4);
        }])->withCount('books')->get();

        $books = Book::all();

        return view('categories.index', compact('categories', 'books'));
    }
}
