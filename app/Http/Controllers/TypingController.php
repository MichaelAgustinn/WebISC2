<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\TypingScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TypingController extends Controller
{
    public function index()
    {
        // Helper function untuk mengambil top score unik per user
        $getLeaderboard = function ($query) {
            return $query->with('user.profile') // Eager load relasi
                ->orderBy('wpm', 'desc') // Urutkan WPM tertinggi
                ->get()
                ->unique('user_id') // Ambil hanya satu record terbaik per user
                ->values() // Reset index array
                ->take(10); // Ambil top 10
        };

        // Daftar value bahasa sesuai dengan yang ada di <select> HTML kamu
        $languages = ['indonesia', 'java', 'php', 'flutter'];
        $leaderboards = [];

        // Looping untuk mengambil data per kategori dan per bahasa
        foreach ($languages as $lang) {
            $leaderboards[$lang] = [
                'weekly'  => $getLeaderboard(TypingScore::where('language', $lang)->where('created_at', '>=', Carbon::now()->startOfWeek())),
                'monthly' => $getLeaderboard(TypingScore::where('language', $lang)->where('created_at', '>=', Carbon::now()->startOfMonth())),
                'alltime' => $getLeaderboard(TypingScore::where('language', $lang)),
            ];
        }

        $data = LandingPage::pluck('value', 'key')->toArray();

        // Passing variabel $leaderboards (isinya array bahasa) ke view
        return view('landing.typing', compact('leaderboards', 'data'));
    }

    public function store(Request $request)
    {
        // Validasi login
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Silakan login untuk menyimpan skor.'], 401);
        }

        $request->validate([
            'wpm' => 'required|integer',
            'accuracy' => 'required|integer',
            'language' => 'require'
        ]);

        // Simpan Skor
        TypingScore::create([
            'user_id' => Auth::id(),
            'wpm' => $request->wpm,
            'accuracy' => $request->accuracy,
            'language' => $request->language,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Skor berhasil disimpan!']);
    }
}
