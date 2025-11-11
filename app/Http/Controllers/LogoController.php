<?php


namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Logo;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    public function index()
    {
        $logos = Logo::all();

        return view('admin.logo-index', ['logos' => $logos]);
    }

    public function create()
    {
        return view('admin.logo');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp',
            'id' => 'nullable|exists:logos,id', // gunakan id untuk update
            'old_image' => 'nullable|string',
        ]);

        $logo = null;
        $compressedPath = null;

        if (!empty($validated['id'])) {
            // Update logo yang sudah ada
            $logo = Logo::find($validated['id']);
            $compressedPath = $logo->image;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->getPathname();
                $fileName = uniqid('logo_') . '.webp';
                $savePath = storage_path('app/public/logo/' . $fileName);

                ImageHelper::compressImage($imagePath, $savePath, 75, 1280);

                $compressedPath = 'storage/logo/' . $fileName;

                // Hapus file lama
                if ($logo->image && file_exists(public_path($logo->image))) {
                    unlink(public_path($logo->image));
                }
            } elseif (!empty($validated['old_image'])) {
                $compressedPath = $validated['old_image'];
            }

            $logo->update([
                'title' => $validated['title'],
                'image' => $compressedPath,
            ]);
        } else {
            // Buat logo baru
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->getPathname();
                $fileName = uniqid('logo_') . '.webp';
                $savePath = storage_path('app/public/logo/' . $fileName);

                ImageHelper::compressImage($imagePath, $savePath, 75, 1280);

                $compressedPath = 'storage/logo/' . $fileName;
            }

            Logo::create([
                'title' => $validated['title'],
                'image' => $compressedPath,
            ]);
        }

        return redirect()->route('logo.index')->with('success', 'Logo berhasil disimpan');
    }

    public function show($id)
    {
        $logo = Logo::find($id);
        return view('admin.logo', ['logo' => $logo]);
    }

    public function destroy($id)
    {
        $logo = Logo::find($id);

        if (!$logo) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        if ($logo->image && file_exists(public_path($logo->image))) {
            unlink(public_path($logo->image));
        }

        $logo->delete();

        return redirect()->back()->with('success', 'Data dan gambar berhasil dihapus');
    }
}
