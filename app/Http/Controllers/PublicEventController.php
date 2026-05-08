<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        // Fitur Pencarian
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest()->paginate(12);
        $recentEvents = Event::latest()->take(5)->get();
        $data = LandingPage::pluck('value', 'key')->toArray();

        return view('landing.events', compact('events', 'recentEvents', 'data'));
    }

    public function show($slug)
    {
        $event = Event::with('users')
            ->where('slug', $slug)
            ->firstOrFail();

        $prevEvent = Event::where('id', '<', $event->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextEvent = Event::where('id', '>', $event->id)
            ->orderBy('id', 'asc')
            ->first();

        $data = LandingPage::pluck('value', 'key')->toArray();

        return view('landing.events-detail', compact(
            'event',
            'prevEvent',
            'nextEvent',
            'data'
        ));
    }

    public function register(Event $event)
    {
        if (!$event->status) {
            return back()->with('error', 'Mohon maaf, pendaftaran untuk event ini sudah ditutup.');
        }

        $user = Auth::user();

        if (!$event->users()->where('user_id', $user->id)->exists()) {
            $event->users()->attach($user->id);
            return back()->with('success', 'Berhasil mendaftar event! Silakan gabung grup WhatsApp.');
        }

        return back()->with('info', 'Anda sudah terdaftar di event ini.');
    }
}
