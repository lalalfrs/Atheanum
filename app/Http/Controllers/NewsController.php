<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('news.index', [
            'news' => News::published()->paginate(9),
        ]);
    }

    public function show(News $news): View
    {
        abort_if($news->published_at?->isFuture() && ! auth()->user()?->isLibrarian(), 404);

        return view('news.show', [
            'news' => $news->load('author'),
            'otherNews' => News::published()->whereKeyNot($news->getKey())->take(3)->get(),
        ]);
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()->isLibrarian(), 403);

        return view('news.create');
    }

    public function store(StoreNewsRequest $request): RedirectResponse
    {
        $news = News::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
            'published_at' => $request->date('published_at') ?? now(),
        ]);

        return redirect()->route('news.show', $news)
            ->with('success', 'Berita berhasil diterbitkan.');
    }

    public function destroy(Request $request, News $news): RedirectResponse
    {
        abort_unless($request->user()->isLibrarian(), 403);

        $news->delete();

        return redirect()->route('news.index')
            ->with('success', 'Berita telah dihapus.');
    }
}
