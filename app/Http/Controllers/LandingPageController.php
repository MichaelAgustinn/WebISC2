<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Facades\Image;
use App\Models\Landing_page;
use Nette\Utils\Image;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function create()
    {
        return view('admin.landing');
    }

    public function store(Request $request)
    {
        // 🔹 1. Validasi input
        $validated = $request->validate([
            'section' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $compressedPath = null;

        // 🔹 2. Cek apakah section sudah ada (untuk update)
        $existing = Landing_page::where('section', $validated['section'])->first();

        // 🔹 3. Jika ada file gambar baru, hapus gambar lama (jika ada)
        if ($request->hasFile('image')) {

            // Hapus gambar lama jika ada
            if ($existing && $existing->image && file_exists(public_path($existing->image))) {
                unlink(public_path($existing->image));
            }

            // Siapkan nama dan path file baru
            $imagePath = $request->file('image')->getPathname();
            $fileName = uniqid('landing_') . '.webp';
            $savePath = storage_path('app/public/landing/' . $fileName);

            // Kompres dan simpan gambar baru
            ImageHelper::compressImage($imagePath, $savePath, 50, 1024);

            $compressedPath = 'storage/landing/' . $fileName;
        } else {
            // Jika tidak upload gambar baru, gunakan yang lama (kalau ada)
            if ($existing) {
                $compressedPath = $existing->image;
            }
        }

        // 🔹 4. Simpan atau update data ke database
        if ($existing) {
            $existing->update([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'image' => $compressedPath,
            ]);
        } else {
            Landing_page::create([
                'section' => $validated['section'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'image' => $compressedPath,
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }
}
