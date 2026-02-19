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

        // 1. Data Mingguan (Start of Week)
        $weekly = $getLeaderboard(
            TypingScore::where('created_at', '>=', Carbon::now()->startOfWeek())
        );

        // 2. Data Bulanan (Start of Month)
        $monthly = $getLeaderboard(
            TypingScore::where('created_at', '>=', Carbon::now()->startOfMonth())
        );

        // 3. All Time
        $alltime = $getLeaderboard(TypingScore::query());
        $data = LandingPage::pluck('value', 'key')->toArray();

        return view('landing.typing', compact('weekly', 'monthly', 'alltime', 'data'));
    }

    public function store(Request $request)
    {
        // Validasi login
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Silakan login untuk menyimpan skor.'], 401);
        }

        $request->validate([
            'wpm' => 'required|integer',
            'accuracy' => 'required|integer'
        ]);

        // Simpan Skor
        TypingScore::create([
            'user_id' => Auth::id(),
            'wpm' => $request->wpm,
            'accuracy' => $request->accuracy
        ]);

        return response()->json(['status' => 'success', 'message' => 'Skor berhasil disimpan!']);
    }
}
