<?php

use App\Http\Controllers\Admin\ProjectVerificationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\PublicFormController;
use App\Http\Controllers\RegistController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TypingController;
use App\Models\Advisor;
use App\Models\Document;
use App\Models\Faq;
use App\Models\LandingPage;
use App\Models\Post;
use App\Models\Project;
use App\Models\Regist;
use App\Models\Team;
use App\Models\TypingScore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// ! guest area
// ? landingpage
Route::get('/', function () {
    // ? ambil data landingpage
    $data = LandingPage::pluck('value', 'key')->toArray();

    // ? Ambil Data FAQ
    $faqs = Faq::all();

    // ? ambil data pengurus
    $teams = Team::all();

    // ? ambil project terbaru
    $recentProjects = Project::where('status', true)->latest()->take(6)->get();

    // ? ambil data tpying score
    $startOfWeek = Carbon::now()->startOfWeek();
    // 1. DATA MINGGUAN
    $weeklyBestSubquery = DB::table('typing_scores')
        ->select('user_id', DB::raw('MAX(wpm) as max_wpm'))
        ->where('created_at', '>=', $startOfWeek)
        ->groupBy('user_id');

    $weeklyTop = TypingScore::with('user.profile')
        ->joinSub($weeklyBestSubquery, 'best_scores', function ($join) {
            $join->on('typing_scores.user_id', '=', 'best_scores.user_id')
                ->on('typing_scores.wpm', '=', 'best_scores.max_wpm');
        })
        ->join('users', 'typing_scores.user_id', '=', 'users.id')
        ->where('users.role', '!=', 'none')
        ->where('typing_scores.created_at', '>=', $startOfWeek)
        ->select('typing_scores.*')
        ->orderByDesc('typing_scores.wpm')
        ->take(5)
        ->get()
        ->unique('user_id')
        ->values();

    // 2. DATA ALL TIME (Tambahan)
    $allTimeBestSubquery = DB::table('typing_scores')
        ->select('user_id', DB::raw('MAX(wpm) as max_wpm'))
        ->groupBy('user_id');

    $allTimeTop = TypingScore::with('user.profile')
        ->joinSub($allTimeBestSubquery, 'best_scores', function ($join) {
            $join->on('typing_scores.user_id', '=', 'best_scores.user_id')
                ->on('typing_scores.wpm', '=', 'best_scores.max_wpm');
        })
        ->join('users', 'typing_scores.user_id', '=', 'users.id')
        ->where('users.role', '!=', 'none')
        ->select('typing_scores.*')
        ->orderByDesc('typing_scores.wpm')
        ->take(5)
        ->get()
        ->unique('user_id')
        ->values();

    $posts = Post::latest()->take(3)->get();

    return view('index', compact('data', 'faqs', 'teams', 'recentProjects', 'weeklyTop', 'allTimeTop', 'posts'));
})->name('home');
// ? landingpage end

// ? event area public
Route::get('/events', [PublicEventController::class, 'index'])->name('events.public');

Route::get('/events/{slug}', [PublicEventController::class, 'show'])->name('landing.events.show');

Route::post('/events/{event}/register', [PublicEventController::class, 'register'])
    ->middleware('auth')
    ->name('landing.events.register');
// ? event area public end

// ? halaman anggota area
Route::get('/anggota', function (Request $request) {

    $search = $request->input('search');

    $members = User::where('email', '!=', 'isc@unsulbar.ac.id')
        ->where('role', '!=', 'none')
        ->with('profile')

        ->when($search, function ($query, $search) {

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")

                    ->orWhereHas('profile', function ($qProfile) use ($search) {

                        $qProfile->where('division', 'like', "%{$search}%")
                            ->orWhere('angkatan', 'like', "%{$search}%");
                    });
            });
        })

        ->orderBy('name', 'asc')
        ->paginate(12)
        ->withQueryString();

    $landingData = App\Models\LandingPage::pluck('value', 'key')->toArray();

    // TAMBAHAN AJAX
    if ($request->ajax()) {
        return view('landing.anggota', [
            'members' => $members,
            'data' => $landingData,
        ])->render();
    }

    return view('landing.anggota', [
        'members' => $members,
        'data' => $landingData,
    ]);
})->name('anggota');

Route::get('/anggota/{slug}', function ($slug) {
    $member = User::with(['profile', 'projects' => function ($query) {
        $query->where('status', true)
            ->latest(); // Urutkan dari yang terbaru
    }])
        ->where('email', '!=', 'isc@unsulbar.ac.id')
        ->where('slug', $slug)
        ->firstOrFail();

    $landingData = App\Models\LandingPage::pluck('value', 'key')->toArray();

    return view('landing.anggota-detail', [
        'member' => $member,
        'data' => $landingData,
    ]);
})->name('anggota.show');
// ? halaman anggota area end

// ? infromation area
Route::get('/dosen', function () {
    // ? ambil data landingpage
    $data = LandingPage::pluck('value', 'key')->toArray();
    $advisors = Advisor::all();

    return view('landing.dosen', compact('data', 'advisors'));
})->name('dosen');

Route::get('/dokumen', function () {
    // ? ambil data landingpage
    $data = LandingPage::pluck('value', 'key')->toArray();
    $documents = Document::whereHas('user', function ($q) {
        $q->whereIn('role', ['admin', 'pengurus']);
    })->latest()->get();

    return view('landing.dokumen', compact('data', 'documents'));
})->name('dokumen');

// ? infromation area end

// ? creation landingpage area
Route::get('/creation', [PublicController::class, 'creation'])->name('landing.creation');
Route::get('/creation/{slug}', [PublicController::class, 'creationDetail'])->name('landing.creation.detail');
// ? creation landingpage area end

// ? typing test
Route::get('/typing-test', [TypingController::class, 'index'])->name('typing.index');
// ? typing test end

// ? blog
Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('blog.show');

// ? Lupa Password
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

// ? Reset Password
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

// ! Guest belum Login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegistController::class, 'regist'])->name('register.post');

    Route::get('/waiting-verification', [RegistController::class, 'waiting'])->name('waiting.verification');
});
// ! guest area end

// ! route untuk sudah login
Route::middleware('auth')->group(function () {
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('password.update.profile');
    // ? form untuk user
    Route::get('/formulir', [PublicFormController::class, 'index'])->name('landing.forms.index');
    Route::get('/formulir/{slug}', [PublicFormController::class, 'show'])->name('landing.forms.show');
    Route::post('/formulir/{slug}/submit', [PublicFormController::class, 'submit'])->name('landing.forms.submit');
    // ? form untuk user end

    Route::post('/typing-test/save', [TypingController::class, 'store'])->name('typing.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        $totalAnggota = User::where('role', 'anggota')->count();
        $totalPengurus = User::whereIn('role', ['pengurus', 'admin'])->count();
        $totalAkun = User::where('email', '!=', 'isc@unsulbar.ac.id')->count() + Regist::all()->count();

        $totalProject = Project::count();
        $projectAktif = Project::where('status', true)->count();

        $pendingProjects = Auth::user()->ownedProjects()->whereNotNull('rejection_reason')->where('is_revised', false)->latest()->get();

        $recentProjects = Project::with('users')->latest()->take(7)->get();

        $startOfWeek = Carbon::now()->startOfWeek();

        // 1. Buat subquery untuk mencari WPM tertinggi per user
        $subQuery = DB::table('typing_scores')
            ->select('typing_scores.user_id', DB::raw('MAX(typing_scores.wpm) as max_wpm'))
            ->join('users', 'typing_scores.user_id', '=', 'users.id')
            ->where('users.role', '!=', 'none') // Filter role dari tabel users
            ->where('typing_scores.created_at', '>=', $startOfWeek)
            ->groupBy('typing_scores.user_id');

        // 2. Query utama untuk mengambil data lengkap score
        $weeklyTop = TypingScore::with('user.profile')
            ->whereIn('id', function ($query) use ($startOfWeek) {
                $query->select(DB::raw('MAX(t1.id)'))
                    ->from('typing_scores as t1')
                    ->join('users', 't1.user_id', '=', 'users.id')
                    ->where('users.role', '!=', 'none')
                    ->where('t1.created_at', '>=', $startOfWeek)
                    ->whereRaw('t1.wpm = (
                SELECT MAX(t2.wpm)
                FROM typing_scores as t2
                WHERE t2.user_id = t1.user_id
                AND t2.created_at >= ?
            )', [$startOfWeek->format('Y-m-d H:i:s')])
                    ->groupBy('t1.user_id');
            })
            ->orderByDesc('wpm')
            ->take(5)
            ->get();

        return view('dashboard', compact('totalAnggota', 'totalAkun', 'totalPengurus', 'totalProject', 'projectAktif', 'recentProjects', 'weeklyTop', 'pendingProjects'));
    })->name('dashboard');

    // ? profile area
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // ? profile area end

    // ? route untuk like
    Route::post('/projects/{project}/like', [ProjectController::class, 'toggleLike'])->name('projects.like');

    // ? event controller
    Route::resource('admin-events', EventController::class);
    Route::get('/admin/events/{id}/registrants', [EventController::class, 'registrants'])->name('admin-events.registrants');
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.my');
});

// ! route untuk anggota pengurus dan admin
Route::middleware(['auth', 'role:admin,pengurus,anggota'])->group(function () {
    // ? project area
    Route::get('/project-saya', [ProjectController::class, 'index'])->name('myproject.index');
    // ? project area end

    Route::resource('projects', ProjectController::class);

    // ? Update Komentar
    Route::put('/comments/{comment}', [PostController::class, 'updateComment'])->name('comments.update');

    // ? Hapus Komentar
    Route::delete('/comments/{comment}', [PostController::class, 'destroyComment'])->name('comments.destroy');

    // ? Tambah komentar
    Route::post('/blog/{post}/comment', [PostController::class, 'storeComment'])->name('posts.comment');

    // ?  lihat project
    Route::get('/all-project', [ProjectVerificationController::class, 'allProject'])
        ->name('admin.projects.all');
});

// ! route untuk admin dan pengurus
Route::middleware(['auth', 'role:admin,pengurus'])->group(function () {
    // ? project verifikasi area
    Route::get('/project-verify', [ProjectVerificationController::class, 'index'])
        ->name('admin.projects.index');

    Route::put('/projects/{project}/verify', [ProjectVerificationController::class, 'verify'])
        ->name('admin.projects.verify');

    Route::put('/projects/{project}/unverify', [ProjectVerificationController::class, 'unverify'])
        ->name('admin.projects.unverify');
    // ? project verifikasi area end

    // ? buat form
    Route::get('/forms/{form}/responses', [FormController::class, 'responses'])->name('forms.responses');
    Route::resource('forms', FormController::class);
    // ? buat form end

    // ? post area
    Route::get('/dashboard/posts', [PostController::class, 'manage'])->name('posts.manage');
    Route::get('/dashboard/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/dashboard/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/dashboard/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/dashboard/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/dashboard/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    // ? post area end

    // ? landingpage crud
    Route::get('/admin/landing-page', [LandingPageController::class, 'index'])->name('landing.index');
    Route::put('/admin/landing-page', [LandingPageController::class, 'update'])->name('landing.update');
    // ? landingpage crud end

    // ? advisor
    Route::resource('admin/advisors', AdvisorController::class)->except(['create', 'show', 'edit']);
    // ? advisor end

    // ? Faq area
    Route::get('/admin/faq', [FaqController::class, 'index'])->name('faq.index');
    Route::post('/admin/faq', [FaqController::class, 'store'])->name('faq.store');
    Route::put('/admin/faq/{faq}', [FaqController::class, 'update'])->name('faq.update');
    Route::delete('/admin/faq/{faq}', [FaqController::class, 'destroy'])->name('faq.destroy');
    // ? Faq area end

    // ? team area
    Route::resource('admin/teams', TeamController::class)->except(['create', 'show', 'edit']);
    // ? team area end

    // ? Route Manajemen User
    Route::get('/admin/verified', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/admin/unverified', [AdminUserController::class, 'unverified'])->name('users.unverified');
    Route::put('/admin/unverified/submit/{id}', [AdminUserController::class, 'verify'])->name('users.verify');
    Route::put('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::delete('/admin/regist/{user}', [RegistController::class, 'destroy'])->name('regist.destroy');

    // ? document area
    Route::resource('documents', DocumentController::class)->except(['show', 'edit', 'update']);
});

// ! just for testing, remove in production
Route::get('/test', function () {
    return view('auth.waiting-verification');
});
