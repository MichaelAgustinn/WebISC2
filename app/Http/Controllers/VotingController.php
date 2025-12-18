<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\Voucher;
use App\Models\Karya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VotingController extends Controller
{
    // Menampilkan halaman voting
    public function index()
    {
        $karya  = Karya::all();
        $footer = Footer::find(1);

        // Ambil voucher code dari session
        $voucherCode = session('voucher_code');

        if (!$voucherCode) {
            return redirect()->route('voting.input')
                ->with('error', 'Silakan masukkan voucher terlebih dahulu.');
        }

        return view('voting.index', compact('karya', 'footer', 'voucherCode'));
    }

    /**
     * Halaman input voucher
     */
    public function isiVoucher()
    {
        $footer = Footer::find(1);
        return view('voting.voucher', compact('footer'));
    }

    /**
     * Proses voting
     */
    public function vote(Request $request)
    {
        $request->validate([
            'karya_id' => 'required|exists:karya,id',
        ]);

        $voucherCode = session('voucher_code');

        if (!$voucherCode) {
            return redirect()->route('voting.input')
                ->with('error', 'Voucher tidak ditemukan.');
        }

        DB::transaction(function () use ($request, $voucherCode) {

            $voucher = Voucher::where('code', $voucherCode)
                ->where('status', true)
                ->lockForUpdate()
                ->first();

            if (!$voucher) {
                abort(403, 'Voucher tidak valid atau sudah digunakan');
            }

            $karya = Karya::findOrFail($request->karya_id);
            $karya->increment('jumlah_vote');

            // INI YANG MEMBUAT STATUS FALSE (BENAR)
            $voucher->update(['status' => false]);
        });

        // Hapus session voucher setelah dipakai
        session()->forget('voucher_code');

        return redirect()->route('voting.thanks')
            ->with('success', 'Terima kasih telah melakukan voting!');
    }

    /**
     * Halaman terima kasih
     */
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
