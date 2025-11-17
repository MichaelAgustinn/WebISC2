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
            'id' => 'nullable|exists:logos,id',
            'old_image' => 'nullable|string',
        ]);

        $logo = null;
        $compressedPath = null;

        if (!empty($validated['id'])) {
            // ========== UPDATE ==========
            $logo = Logo::find($validated['id']);
            $compressedPath = $logo->image;

            if ($request->hasFile('image')) {

                /** 1) Ambil file */
                $sourcePath = $request->file('image')->getPathname();

                /** 2) Tentukan nama file */
                $fileName = uniqid('logo_') . '.webp';
                $savePath = storage_path('app/public/logo/' . $fileName);

                /** 3) Kompres (tidak menyimpan file) */
                $result = ImageHelper::compressImage($sourcePath, 75, 1280, 1280);

                /** 4) Simpan file hasil kompres */
                ImageHelper::saveImage($result['image'], $savePath, 'webp', $result['quality']);

                /** 5) Simpan path untuk DB */
                $compressedPath = 'storage/logo/' . $fileName;

                /** 6) Hapus file lama */
                if ($logo->image && file_exists(public_path($logo->image))) {
                    unlink(public_path($logo->image));
                }
            } elseif (!empty($validated['old_image'])) {
                $compressedPath = $validated['old_image'];
            }

            /** 7) Update DB */
            $logo->update([
                'title' => $validated['title'],
                'image' => $compressedPath,
            ]);
        } else {
            // ========== CREATE ==========
            if ($request->hasFile('image')) {
                $sourcePath = $request->file('image')->getPathname();
                $fileName = uniqid('logo_') . '.webp';
                $savePath = storage_path('app/public/logo/' . $fileName);

                $result = ImageHelper::compressImage($sourcePath, 75, 1280, 1280);

                ImageHelper::saveImage($result['image'], $savePath, 'webp', $result['quality']);

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
