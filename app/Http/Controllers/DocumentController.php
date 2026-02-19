<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // Menampilkan daftar dokumen milik user yang login
    public function index()
    {
        $documents = Document::where('user_id', Auth::id())->latest()->paginate(10);
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

        // Upload File
        $path = $request->file('file')->store('documents', 'public');

        Document::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'file_path' => $path,
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diupload.');
    }

    // Fitur Download Aman
    public function download(Document $document)
    {
        // Pastikan hanya pemilik atau admin yang bisa download
        if (Auth::id() !== $document->user_id && Auth::user()->role !== 'admin' && Auth::user()->role !== 'pengurus') {
            abort(403);
        }

        return Storage::download('public/' . $document->file_path, $document->name);
    }

    public function destroy(Document $document)
    {
        if (Auth::id() !== $document->user_id) {
            abort(403);
        }

        // Hapus file fisik
        if (Storage::exists('public/' . $document->file_path)) {
            Storage::delete('public/' . $document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
