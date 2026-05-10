<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\TypingScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TypingController extends Controller
{
    public function index()
    {
        $getLeaderboard = function ($language, $startDate = null) {
            $subQuery = DB::table('typing_scores')
                ->select('user_id', DB::raw('MAX(wpm) as max_wpm'))
                ->where('language', $language);

            if ($startDate) {
                $subQuery->where('created_at', '>=', $startDate);
            }

            $subQuery->groupBy('user_id');

            return TypingScore::query()
                ->with('user.profile')
                ->joinSub($subQuery, 'best_scores', function ($join) {
                    $join->on('typing_scores.user_id', '=', 'best_scores.user_id')
                        ->on('typing_scores.wpm', '=', 'best_scores.max_wpm');
                })
                ->join('users', 'typing_scores.user_id', '=', 'users.id')
                ->where('users.role', '!=', 'none')
                ->where('typing_scores.language', $language)
                ->when($startDate, function ($q) use ($startDate) {
                    return $q->where('typing_scores.created_at', '>=', $startDate);
                })
                ->select('typing_scores.*')
                ->orderByDesc('typing_scores.wpm')
                ->take(10)
                ->get()
                ->unique('user_id');
        };

        $languages = ['indonesia', 'java', 'php', 'flutter'];
        $leaderboards = [];

        foreach ($languages as $lang) {
            $leaderboards[$lang] = [
                'weekly'  => $getLeaderboard($lang, Carbon::now()->startOfWeek()),
                'monthly' => $getLeaderboard($lang, Carbon::now()->startOfMonth()),
                'alltime' => $getLeaderboard($lang),
            ];
        }

        $data = LandingPage::pluck('value', 'key')->toArray();

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
            'language' => 'required'
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
