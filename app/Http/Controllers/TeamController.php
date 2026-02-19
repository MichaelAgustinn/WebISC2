<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('admin.team.index', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $input = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/team'), $filename);
            $input['photo'] = $filename;
        }

        Team::create($input);
        return back()->with('success', 'Pengurus berhasil ditambahkan');
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
        ]);

        $input = $request->all();

        if ($request->hasFile('photo')) {
            // Hapus foto lama
            if (File::exists(public_path('uploads/team/' . $team->photo))) {
                File::delete(public_path('uploads/team/' . $team->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/team'), $filename);
            $input['photo'] = $filename;
        }

        $team->update($input);
        return back()->with('success', 'Data pengurus berhasil diperbarui');
    }

    public function destroy(Team $team)
    {
        if (File::exists(public_path('uploads/team/' . $team->photo))) {
            File::delete(public_path('uploads/team/' . $team->photo));
        }
        $team->delete();
        return back()->with('success', 'Pengurus berhasil dihapus');
    }
}
