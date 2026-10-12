<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLibraryEventRequest;
use App\Models\LibraryEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryEventController extends Controller
{
    public function index(): View
    {
        return view('events.index', [
            'upcomingEvents' => LibraryEvent::upcoming()->get(),
            'pastEvents' => LibraryEvent::past()->take(6)->get(),
        ]);
    }

    public function show(LibraryEvent $event): View
    {
        return view('events.show', [
            'event' => $event,
        ]);
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()->isLibrarian(), 403);

        return view('events.create');
    }

    public function store(StoreLibraryEventRequest $request): RedirectResponse
    {
        $event = LibraryEvent::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('events.show', $event)
            ->with('success', 'Acara berhasil ditambahkan ke agenda.');
    }

    public function destroy(Request $request, LibraryEvent $event): RedirectResponse
    {
        abort_unless($request->user()->isLibrarian(), 403);

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Acara telah dihapus dari agenda.');
    }
}
