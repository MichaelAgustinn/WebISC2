<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LoanLetterDetail;
use App\Models\User;
use App\Models\WarningLetterDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LetterController extends Controller
{

    public function index()
    {
        // Ambil semua jenis surat, termasuk peringatan dan peminjaman
        $letters = Letter::with(['warningDetail', 'loanDetail'])
            ->latest()
            ->get();

        return view('admin.letters.index', compact('letters'));
    }

    public function show($id)
    {
        $letter = Letter::with(['warningDetail', 'loanDetail', 'users.profile'])->findOrFail($id);

        if ($letter->jenis_surat === 'peringatan') {
            // ✅ Jika surat peringatan
            $view = 'letters.templates.peringatan';
            $data = [
                'letter' => $letter,
                'detail' => $letter->warningDetail,
                'users' => $letter->users,
            ];
        } else {
            // ✅ Semua peminjaman (alat maupun tempat) tetap pakai template peminjaman-tempat
            $view = 'letters.templates.peminjaman-tempat';
            $data = [
                'letter' => $letter,
                'data' => [
                    'perihal' => $letter->loanDetail->perihal,
                    'tujuan' => $letter->loanDetail->tujuan,
                    'dasar_kegiatan' => $letter->loanDetail->dasar_kegiatan,
                    'hari' => $letter->loanDetail->hari,
                    'jam' => $letter->loanDetail->jam,
                    'nama_tempat_barang' => $letter->loanDetail->nama_tempat_barang,
                ],
            ];
        }

        $pdf = Pdf::loadView($view, $data)
            ->setPaper('A4', 'portrait')
            ->setOption([
                'dpi' => 96,
                'defaultFont' => 'Times New Roman',
                'enable_php' => true,
            ]);

        return $pdf->stream('Surat_' . $letter->id . '.pdf');
    }




    public function destroy($id)
    {
        $letter = Letter::with(['warningDetail', 'loanDetail', 'users'])->findOrFail($id);

        // Hapus relasi pivot user (jika ada)
        if ($letter->users()->exists()) {
            $letter->users()->detach();
        }

        // Hapus detail surat peringatan (jika ada)
        if ($letter->warningDetail) {
            $letter->warningDetail->delete();
        }

        // Hapus detail surat peminjaman (jika ada)
        if ($letter->loanDetail) {
            $letter->loanDetail->delete();
        }

        // Terakhir hapus surat utama
        $letter->delete();

        return redirect()->route('letters.index')
            ->with('success', 'Surat dan detail terkait berhasil dihapus!');
    }

    public function create()
    {
        // Ambil semua user dengan status Anggota atau Pengurus
        $users = User::whereIn('role', ['Anggota', 'Pengurus'])->get();
        return view('admin.letters.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_surat' => 'required|string',
            'jenis_peringatan' => 'required|in:1,2,3',
            'nama_ketua' => 'required|string',
            'users' => 'required|array',
        ]);

        $letter = Letter::create([
            'jenis_surat' => 'peringatan',
            'tanggal' => $request->tanggal,
            'nomor_surat' => $request->nomor_surat,
            'nama_ketua' => $request->nama_ketua,
        ]);

        WarningLetterDetail::create([
            'letter_id' => $letter->id,
            'peringatan_ke' => $request->jenis_peringatan,
        ]);

        $letter->users()->attach($request->users);

        // ✅ Gunakan pengaturan PDF standar
        $pdf = Pdf::loadView('letters.templates.peringatan', [
            'letter' => $letter,
            'detail' => $letter->warningDetail,
            'users' => $letter->users,
        ])
            ->setPaper('A4', 'portrait')
            ->setOption([
                'dpi' => 96,
                'defaultFont' => 'Times New Roman',
                'enable_html5_parser' => true, // penting agar layout sama persis
                'enable_php' => true,
                'isRemoteEnabled' => true,
            ]);

        return $pdf->download('Surat_Peringatan_' . $letter->id . '.pdf');
    }

    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string',
            'perihal' => 'required|string',
            'tujuan' => 'required|string',
            'dasar_kegiatan' => 'required|string',
            'hari' => 'required|string',
            'jam' => 'required|string',
            'tanggal' => 'required|date',
            'nama_ketua' => 'required|string',
            'nama_tempat_barang' => 'required|string',
        ]);

        // ✅ Selalu dianggap surat peminjaman tempat
        $jenis = 'peminjaman_tempat';

        // 1️⃣ Simpan surat utama
        $letter = Letter::create([
            'jenis_surat' => $jenis,
            'tanggal' => $request->tanggal,
            'nomor_surat' => $request->nomor_surat,
            'nama_ketua' => $request->nama_ketua,
        ]);

        // 2️⃣ Simpan detail peminjaman
        LoanLetterDetail::create([
            'letter_id' => $letter->id,
            'perihal' => $request->perihal,
            'tujuan' => $request->tujuan,
            'dasar_kegiatan' => $request->dasar_kegiatan,
            'hari' => $request->hari,
            'jam' => $request->jam,
            'nama_tempat_barang' => $request->nama_tempat_barang,
        ]);

        // 3️⃣ Data untuk template PDF
        $data = [
            'perihal' => $request->perihal,
            'tujuan' => $request->tujuan,
            'dasar_kegiatan' => $request->dasar_kegiatan,
            'hari' => $request->hari,
            'jam' => $request->jam,
            'nama_tempat_barang' => $request->nama_tempat_barang,
        ];

        // ✅ Gunakan satu template saja
        $view = 'letters.templates.peminjaman-tempat';

        // 4️⃣ Generate PDF surat
        $pdf = Pdf::loadView($view, [
            'letter' => $letter,
            'data' => $data,
        ])
            ->setPaper('A4', 'portrait')
            ->setOption([
                'dpi' => 96,
                'defaultFont' => 'Times New Roman',
                'enable_html5_parser' => true,
                'enable_php' => true,
            ]);

        return $pdf->download('Surat_Peminjaman_' . $letter->id . '.pdf');
    }
}
