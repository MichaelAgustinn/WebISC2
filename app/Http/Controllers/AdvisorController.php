<?php

namespace App\Http\Controllers;

use App\Models\Advisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdvisorController extends Controller
{
    public function index()
    {
        $advisors = Advisor::all();
        return view('admin.advisor.index', compact('advisors'));
    }

    public function store(Request $request)
    {
        // Validasi Sederhana
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $input = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/advisors'), $filename);
            $input['photo'] = $filename;
        }

        Advisor::create($input);
        return back()->with('success', 'Dosen berhasil ditambahkan');
    }

    public function update(Request $request, Advisor $advisor)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
        ]);

        $input = $request->all();

        if ($request->hasFile('photo')) {
            if (File::exists(public_path('uploads/advisors/' . $advisor->photo))) {
                File::delete(public_path('uploads/advisors/' . $advisor->photo));
            }
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/advisors'), $filename);
            $input['photo'] = $filename;
        }

        $advisor->update($input);
        return back()->with('success', 'Data dosen berhasil diperbarui');
    }

    public function destroy(Advisor $advisor)
    {
        if (File::exists(public_path('uploads/advisors/' . $advisor->photo))) {
            File::delete(public_path('uploads/advisors/' . $advisor->photo));
        }
        $advisor->delete();
        return back()->with('success', 'Dosen berhasil dihapus');
    }
}
