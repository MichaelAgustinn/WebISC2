<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Pengurus;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index()
    {
        $penguruses = Pengurus::all();
        return view('admin.pengurus-index', ['penguruses' => $penguruses]);
    }

    public function create()
    {
        return view('admin.pengurus');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'jabatan' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
            'id' => 'nullable|exists:penguruses,id',
            'old_image' => 'nullable|string',
        ]);

        $pengurus = null;
        $compressedPath = null;

        if (!empty($validated['id'])) {
            $pengurus = Pengurus::find($validated['id']);
            $compressedPath = $pengurus->image;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->getPathname();
                $fileName = uniqid('pengurus_') . '.webp';
                $savePath = storage_path('app/public/pengurus/' . $fileName);

                // 🔧 gunakan hasil kompres dan simpan
                $result = ImageHelper::compressImage($imagePath, 75, 1280, 1280);
                ImageHelper::saveImage($result['image'], $savePath, 'webp', $result['quality']);

                $compressedPath = 'storage/pengurus/' . $fileName;

                if ($pengurus->image && file_exists(public_path($pengurus->image))) {
                    unlink(public_path($pengurus->image));
                }
            } elseif (!empty($validated['old_image'])) {
                $compressedPath = $validated['old_image'];
            }

            $pengurus->update([
                'name' => $validated['name'],
                'jabatan' => $validated['jabatan'],
                'image' => $compressedPath,
            ]);
        } else {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->getPathname();
                $fileName = uniqid('pengurus_') . '.webp';
                $savePath = storage_path('app/public/pengurus/' . $fileName);

                // 🔧 simpan hasil kompres
                $result = ImageHelper::compressImage($imagePath, 75, 1280, 1280);
                ImageHelper::saveImage($result['image'], $savePath, 'webp', $result['quality']);

                $compressedPath = 'storage/pengurus/' . $fileName;
            }

            Pengurus::create([
                'name' => $validated['name'],
                'jabatan' => $validated['jabatan'],
                'image' => $compressedPath,
            ]);
        }

        return redirect()->back()->with('success', 'Pengurus berhasil disimpan');
    }


    public function edit($id)
    {
        $pengurus = Pengurus::find($id);
        return view('admin.pengurus', ['pengurus' => $pengurus]);
    }

    public function destroy($id)
    {
        $pengurus = Pengurus::find($id);

        if (!$pengurus) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        if ($pengurus->image && file_exists(public_path($pengurus->image))) {
            unlink(public_path($pengurus->image));
        }

        $pengurus->delete();

        return redirect()->back()->with('success', 'Data dan gambar berhasil dihapus');
    }
}
