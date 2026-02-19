<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil data pluck (key => value) untuk ditampilkan di view
        $contents = LandingPage::pluck('value', 'key')->toArray();
        return view('admin.landing.index', compact('contents'));
    }

    public function update(Request $request)
    {
        // Ambil semua input kecuali token dan method
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // 1. Cek apakah ini input FILE (Gambar)
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                if ($file->isValid()) {
                    $filename = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/landing'), $filename);

                    // Hapus gambar lama
                    $old = LandingPage::where('key', $key)->first();
                    if ($old && $old->value && File::exists(public_path('uploads/landing/' . $old->value))) {
                        File::delete(public_path('uploads/landing/' . $old->value));
                    }

                    // Simpan Nama File
                    LandingPage::updateOrCreate(
                        ['key' => $key],
                        [
                            'value' => $filename,
                            'type' => 'image',
                            'section' => explode('_', $key)[0] // Ambil kata depan sbg section (misal: about_image -> about)
                        ]
                    );
                }
            }
            // 2. Jika bukan file (Text biasa) dan valuenya tidak null
            else {
                if ($value !== null) {
                    LandingPage::updateOrCreate(
                        ['key' => $key],
                        [
                            'value' => $value,
                            'type' => 'text', // Default text/textarea
                            'section' => explode('_', $key)[0]
                        ]
                    );
                }
            }
        }

        return back()->with('success', 'Landing Page berhasil diperbarui!');
    }
}
