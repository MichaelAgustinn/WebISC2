<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', Auth::id())->latest()->paginate(9);
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link' => 'required|url',
            'status' => 'required|boolean',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/events'), $fileName);
            $photoPath = 'uploads/events/' . $fileName;
        }

        Event::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'deskripsi' => $request->deskripsi,
            'link' => $request->link,
            'status' => $request->status,
            'photo' => $photoPath,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
        ]);

        return redirect()->route('admin-events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $admin_event)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'link' => 'required|url',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'status' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'deskripsi' => $request->deskripsi,
            'link' => $request->link,
            'status' => $request->status,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
        ];

        if ($request->hasFile('photo')) {
            if (File::exists(public_path($admin_event->photo))) {
                File::delete(public_path($admin_event->photo));
            }

            // Upload foto baru
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/events'), $fileName);
            $data['photo'] = 'uploads/events/' . $fileName;
        }

        $admin_event->update($data);

        return redirect()->route('admin-events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $admin_event)
    {

        if (File::exists(public_path($admin_event->photo))) {

            File::delete(public_path($admin_event->photo));
        }

        $admin_event->delete();

        return redirect()
            ->route('admin-events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    public function registrants($id)
    {
        $event = Event::findOrFail($id);

        $registrants = $event->users()->with('profile')->latest('event_user.created_at')->paginate(15);

        return view('events.registrants', compact('event', 'registrants'));
    }

    public function myEvents()
    {
        $events = Auth::user()->registeredEvents()->orderBy('created_at', 'desc')->paginate(10);

        return view('events.my-events', compact('events'));
    }
}
