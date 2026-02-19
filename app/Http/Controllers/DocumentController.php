<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; // Ubah Storage menjadi File

class DocumentController extends Controller
{
    // Menampilkan daftar dokumen milik user yang login
    public function index()
    {
        $documents = Document::latest()->paginate(10);
        return view('user.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('user.documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:krs,kartu_kontrol,lainnya',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:5120', // Max 5MB
        ]);

        // 1. Buat nama file yang unik
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // 2. Pindahkan file langsung ke folder public/uploads/document
        $file->move(public_path('uploads/document'), $fileName);

        // 3. Simpan data ke database (kita hanya simpan nama filenya saja)
        Document::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'file_path' => $fileName,
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diupload.');
    }

    // Fitur Download Aman
    public function download(Document $document)
    {
        // Tentukan lokasi asli file di folder public
        $filePath = public_path('uploads/document/' . $document->file_path);

        // Cek apakah file fisiknya benar-benar ada di server agar tidak error 500
        if (!File::exists($filePath)) {
            abort(404, 'Maaf, file fisik tidak ditemukan di server.');
        }

        // Return response download bawaan Laravel
        // Parameter kedua adalah nama file saat di-download oleh user (agar namanya rapi)
        return response()->download($filePath, $document->name . '.' . File::extension($filePath));
    }

    public function destroy(Document $document)
    {
        // Pastikan hanya pemilik yang bisa menghapus
        if (Auth::id() !== $document->user_id) {
            abort(403, 'Akses ditolak: Anda bukan pemilik dokumen ini.');
        }

        // Tentukan lokasi asli file
        $filePath = public_path('uploads/document/' . $document->file_path);

        // Hapus file fisik jika ada di folder public
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Hapus data dari database
        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
