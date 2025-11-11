<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\Information;
use App\Models\Mentor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
    public function dosen()
    {
        $dosen = Mentor::all();
        $footer = Footer::find(1);

        return view("information.dosen", ['mentors' => $dosen, 'footer' => $footer]);
    }

    public function Anggota(Request $request)
    {
        $search = $request->input('search');

        // Query dasar: ambil user dengan role tertentu
        $query = User::with('profile')->whereIn('role', ['None', 'anggota', 'Pengurus']);

        // Jika ada kata kunci pencarian
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('profile', function ($p) use ($search) {
                        $p->where('nim', 'like', "%{$search}%")
                            ->orWhere('angkatan', 'like', "%{$search}%")
                            ->orWhere('divisi', 'like', "%{$search}%");
                    });
            });
        }

        // Pagination tetap jalan dan simpan query search di URL
        $anggota = $query->paginate(8)->appends(['search' => $search]);

        $footer = Footer::find(1);

        return view('information.anggota', [
            'anggota' => $anggota,
            'footer' => $footer
        ]);
    }

    public function document()
    {
        $information = Information::latest()->get();
        $footer = Footer::find(1);
        return view('information.document', ['footer' => $footer, 'information' => $information]);
    }

    public function documentIndex()
    {
        $information = Information::latest()->get();
        return view('admin.information.form-index', compact('information'));
    }

    public function documentCreate()
    {
        return view('admin.information.form');
    }

    public function documentStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
        ]);

        // Ambil ekstensi file (contoh: pdf, docx, png)
        $extension = $request->file('file')->getClientOriginalExtension();

        // Buat nama file baru: slug dari nama + ekstensi
        $slugName = Str::slug($request->name);
        $fileName = $slugName . '.' . $extension;

        // Simpan file ke folder 'information' dengan nama kustom
        $path = $request->file('file')->storeAs('information', $fileName, 'public');

        // Simpan path ke database
        Information::create([
            'name' => $request->name,
            'file' => 'storage/' . $path, // hasil: storage/information/panduan-anggota.pdf
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
    public function documentEdit($id)
    {
        $information = Information::findOrFail($id);
        return view('admin.information.form', compact('information'));
    }

    public function documentUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
        ]);

        $information = Information::findOrFail($id);
        $filePath = $information->file;

        // Jika ada file baru diupload
        if ($request->hasFile('file')) {
            // Hapus file lama dari public/storage
            if ($information->file && file_exists(public_path($information->file))) {
                unlink(public_path($information->file));
            }

            // Dapatkan ekstensi dan buat nama file baru
            $extension = $request->file('file')->getClientOriginalExtension();
            $slugName = Str::slug($request->name);
            $fileName = $slugName . '.' . $extension;

            // Simpan file baru
            $path = $request->file('file')->storeAs('information', $fileName, 'public');
            $filePath = 'storage/' . $path;
        }

        // Update data ke database
        $information->update([
            'name' => $request->name,
            'file' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function documentDestroy($id)
    {
        $information = Information::findOrFail($id);

        if ($information->file && file_exists(public_path($information->file))) {
            unlink(public_path($information->file));
        }

        $information->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
