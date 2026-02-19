<?php

use App\Http\Controllers\Admin\ProjectVerificationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdvisorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TypingController;
use App\Models\Advisor;
use App\Models\Document;
use App\Models\Faq;
use App\Models\LandingPage;
use App\Models\Post;
use App\Models\Project;
use App\Models\Team;
use App\Models\TypingScore;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

// ! guest area
// ? landingpage
Route::get('/', function () {
    //? ambil data landingpage
    $data = LandingPage::pluck('value', 'key')->toArray();

    //? Ambil Data FAQ
    $faqs = Faq::all();

    // ? ambil data pengurus
    $teams = Team::all();

    // ? ambil project terbaru
    $recentProjects = Project::where('status', true)->latest()->take(6)->get();

    // ? ambil data tpying score
    // 1. DATA MINGGUAN
    $weeklyTop = TypingScore::with('user.profile')
        ->where('created_at', '>=', Carbon::now()->startOfWeek())
        ->orderBy('wpm', 'desc')
        ->get()
        ->unique('user_id')
        ->take(5);

    // 2. DATA ALL TIME (Tambahan)
    $allTimeTop = TypingScore::with('user.profile')
        ->orderBy('wpm', 'desc')
        ->get()
        ->unique('user_id')
        ->take(5);

    $posts = Post::latest()->take(3)->get();

    return view('index', compact('data', 'faqs', 'teams', 'recentProjects', 'weeklyTop', 'allTimeTop', 'posts'));
})->name('home');
// ? landingpage end

// ? halaman anggota area
Route::get('/anggota', function () {
    $members = User::where('email', '!=', 'isc@unsulbar.ac.id')->with('profile')->get();

    $landingData = App\Models\LandingPage::pluck('value', 'key')->toArray();

    return view('landing.anggota', [
        'members' => $members,
        'data' => $landingData
    ]);
})->name('anggota');

Route::get('/anggota/{id}', function ($id) {
    // Cari user berdasarkan ID, pastikan bukan admin
    $member = User::with('profile')->where('email', '!=', 'isc@unsulbar.ac.id')->findOrFail($id);

    $landingData = App\Models\LandingPage::pluck('value', 'key')->toArray();

    return view('landing.anggota-detail', [
        'member' => $member,
        'data' => $landingData
    ]);
})->name('anggota.show');
// ? halaman anggota area end

// ? infromation area
Route::get('/dosen', function () {
    //? ambil data landingpage
    $data = LandingPage::pluck('value', 'key')->toArray();
    $advisors = Advisor::all();

    return view('landing.dosen', compact('data', 'advisors'));
})->name('dosen');

Route::get('/dokumen', function () {
    //? ambil data landingpage
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
// ! guest area end

// ! Guest belum Login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister'])->name('register.post');
});

// ! Auth sudah login
Route::middleware('auth')->group(function () {
    Route::post('/typing-test/save', [TypingController::class, 'store'])->name('typing.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        $totalAnggota = User::where('role', 'anggota')->count();
        $totalPengurus = User::whereIn('role', ['pengurus', 'admin'])->count();
        $totalAkun = User::where('email', '!=', 'isc@unsulbar.ac.id')->count();

        $totalProject = Project::count();
        $projectAktif = Project::where('status', true)->count();

        $recentProjects = Project::with('users')->latest()->take(7)->get();

        $weeklyTop = TypingScore::with('user.profile')
            ->where('created_at', '>=', Carbon::now()->startOfWeek())
            ->orderBy('wpm', 'desc')
            ->get()
            ->unique('user_id')
            ->take(5);

        return view('dashboard', compact('totalAnggota', 'totalAkun', 'totalPengurus', 'totalProject', 'projectAktif', 'recentProjects', 'weeklyTop'));
    })->name('dashboard');

    // ? profile area
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // ? profile area end

    // ? route untuk like
    Route::post('/projects/{project}/like', [ProjectController::class, 'toggleLike'])->name('projects.like');
});

Route::middleware(['auth', 'role:admin,pengurus,anggota'])->group(function () {
    Route::resource('projects', ProjectController::class);

    // Update Komentar
    Route::put('/comments/{comment}', [PostController::class, 'updateComment'])->name('comments.update');

    // Hapus Komentar
    Route::delete('/comments/{comment}', [PostController::class, 'destroyComment'])->name('comments.destroy');

    // Tambah komentar
    Route::post('/blog/{post}/comment', [PostController::class, 'storeComment'])->name('posts.comment');
});

// ! route untuk admin dan pengurus
Route::middleware(['auth', 'role:admin,pengurus'])->group(function () {
    // ? project verifikasi area
    Route::get('/projects', [ProjectVerificationController::class, 'index'])
        ->name('projects.index');

    Route::put('/projects/{project}/verify', [ProjectVerificationController::class, 'verify'])
        ->name('admin.projects.verify');

    Route::put('/projects/{project}/unverify', [ProjectVerificationController::class, 'unverify'])
        ->name('admin.projects.unverify');
    // ? project verifikasi area end

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

    //? Route Manajemen User
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::put('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // ? document area
    Route::resource('documents', DocumentController::class)->except(['show', 'edit', 'update']);
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
});


// ! just for testing, remove in production
Route::get('/test', function () {
    return view('blog.blog');
});
