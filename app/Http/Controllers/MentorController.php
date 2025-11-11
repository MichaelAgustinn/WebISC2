<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    public function index()
    {
        $mentors = Mentor::all();
        return view('admin.mentor-index', ['mentors' => $mentors]);
    }

    public function create()
    {
        return view('admin.mentor');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'jabatan' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
            'id' => 'nullable|exists:mentors,id', // gunakan id untuk update
            'old_image' => 'nullable|string',
        ]);

        $mentor = null;
        $compressedPath = null;

        // === Jika ada ID, berarti update data lama ===
        if (!empty($validated['id'])) {
            $mentor = Mentor::find($validated['id']);
            $compressedPath = $mentor->image;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->getPathname();
                $fileName = uniqid('mentor_') . '.webp';
                $savePath = storage_path('app/public/mentor/' . $fileName);

                // 🔧 Kompres & Simpan gambar
                $result = ImageHelper::compressImage($imagePath, 75, 1280, 1280);
                ImageHelper::saveImage($result['image'], $savePath, 'webp', $result['quality']);

                $compressedPath = 'storage/mentor/' . $fileName;

                // 🔥 Hapus gambar lama jika ada
                if ($mentor->image && file_exists(public_path($mentor->image))) {
                    unlink(public_path($mentor->image));
                }
            } elseif (!empty($validated['old_image'])) {
                $compressedPath = $validated['old_image'];
            }

            $mentor->update([
                'name' => $validated['name'],
                'jabatan' => $validated['jabatan'],
                'image' => $compressedPath,
            ]);
        }

        // === Jika tidak ada ID, buat data baru ===
        else {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->getPathname();
                $fileName = uniqid('mentor_') . '.webp';
                $savePath = storage_path('app/public/mentor/' . $fileName);

                // 🔧 Kompres & Simpan gambar
                $result = ImageHelper::compressImage($imagePath, 75, 1280, 1280);
                ImageHelper::saveImage($result['image'], $savePath, 'webp', $result['quality']);

                $compressedPath = 'storage/mentor/' . $fileName;
            }

            Mentor::create([
                'name' => $validated['name'],
                'jabatan' => $validated['jabatan'],
                'image' => $compressedPath,
            ]);
        }

        return redirect()->back()->with('success', 'Mentor berhasil disimpan');
    }


    public function edit($id)
    {
        $mentor = Mentor::find($id);
        return view('admin.mentor', ['mentor' => $mentor]);
    }

    public function destroy($id)
    {
        $mentor = Mentor::find($id);

        if (!$mentor) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        if ($mentor->image && file_exists(public_path($mentor->image))) {
            unlink(public_path($mentor->image));
        }

        $mentor->delete();

        return redirect()->back()->with('success', 'Data dan gambar berhasil dihapus');
    }
}
