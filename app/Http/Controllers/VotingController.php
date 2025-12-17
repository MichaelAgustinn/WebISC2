<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\Voucher;
use App\Models\Karya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VotingController extends Controller
{
    // Menampilkan halaman voting
    public function index()
    {
        $karya   = Karya::all();
        $footer  = Footer::find(1);
        $voucher = session('voucher'); // ← aman, pasti ada

        return view('voting.index', compact('karya', 'footer', 'voucher'));
    }

    public function isiVoucher()
    {
        $footer = Footer::find(1);
        return view('voting.voucher', ['footer' => $footer]);
    }


    public function vote(Request $request)
    {
        $request->validate([
            'karya_id' => 'required',
            'voucher_id' => 'required'
        ]);

        $voucher = Voucher::find($request->voucher_id);

        if (!$voucher || !$voucher->status) {
            return redirect()->back()->with('error', 'Voucher tidak valid.');
        }

        // Update vote
        $karya = Karya::find($request->karya_id);
        $karya->increment('jumlah_vote');

        // Update voucher menjadi tidak aktif
        $voucher->update(['status' => false]);

        return redirect()->route('voting.thanks')
            ->with('success', 'Terima kasih telah melakukan voting!');
    }

    public function thanks()
    {
        return view('voting.thanks');
    }


    // ! ini untuk admin
    // =============================================
    // KARYA CRUD
    // =============================================

    public function karyaIndex()
    {
        $karya = Karya::orderBy('id', 'DESC')->get();
        return view('admin.karya.index', compact('karya'));
    }

    public function karyaCreate()
    {
        return view('admin.karya.create');
    }

    public function karyaStore(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:3072',
        ]);

        $image = $request->file('image')?->store('karya', 'public');

        Karya::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'image' => $image,
        ]);

        return redirect()->route('karya.index')->with('success', 'Karya berhasil ditambahkan.');
    }

    public function karyaEdit($id)
    {
        $karya = Karya::findOrFail($id);
        return view('admin.karya.edit', compact('karya'));
    }

    public function karyaUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:3072',
        ]);

        $karya = Karya::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($karya->image && Storage::disk('public')->exists($karya->image)) {
                Storage::disk('public')->delete($karya->image);
            }
            $karya->image = $request->file('image')->store('karya', 'public');
        }

        $karya->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'image' => $karya->image,
        ]);

        return redirect()->route('karya.index')->with('success', 'Karya berhasil diperbarui.');
    }

    public function karyaDelete($id)
    {
        $karya = Karya::findOrFail($id);

        if ($karya->image && Storage::disk('public')->exists($karya->image)) {
            Storage::disk('public')->delete($karya->image);
        }

        $karya->delete();

        return redirect()->route('karya.index')->with('success', 'Karya berhasil dihapus.');
    }
}
