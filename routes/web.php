<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CreationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestimonialController;
use App\Models\Blog;
use App\Models\Creation;
use App\Models\Faq;
use App\Models\Footer;
use App\Models\Information;
use App\Models\Landing_page;
use App\Models\Logo;
use App\Models\Mentor;
use App\Models\Pengurus;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


// ! Landing Page Route Start
Route::get('/', function () {
    $hero = Landing_page::where('section', 'hero')->first();
    $about = Landing_page::where('section', 'about')->first();
    $visi = Landing_page::where('section', 'visi')->first();
    $misi = Landing_page::where('section', 'misi')->first();
    $pengurus = User::where('role', 'Pengurus')->count();
    $anggota = User::where('role', 'Anggota')->count();
    $karya = Creation::where('status', 'approve')->count();
    $testimonials = Testimonial::all();
    $faq = Faq::all();
    $logos = Logo::all();
    $footer = Footer::find(1);
    $blogs = Blog::with('user')->latest()->limit(5)->get();
    // $mentors = Mentor::all();
    $penguruses = Pengurus::all();
    $creations = Creation::where('status', 'approve')->latest()->limit(6)->get();

    return view('welcome', [
        'hero' => $hero,
        'about' => $about,
        'misi' => $misi,
        'visi' => $visi,
        'pengurus' => $pengurus,
        'anggota' => $anggota,
        'karya' => $karya,
        'faqs' => $faq,
        'logos' => $logos,
        'footer' => $footer,
        'testimonials' => $testimonials,
        'blogs' => $blogs,
        // 'mentors' => $mentors,
        'penguruses' => $penguruses,
        'creations' => $creations,
    ]);
})->name('landing');
// ! Landing Page Route Stop

// ? landing information
Route::get('/information/dosen', [InformationController::class, 'dosen'])->name('information.dosen');
Route::get('/information/anggota', [InformationController::class, 'anggota'])->name('information.anggota');
Route::get('/information/document', [InformationController::class, 'document'])->name('information.download');
// ? landing information end

// ! blog page route start
Route::get('/blog-page', function () {
    $footer = Footer::find(1);
    $recent = Blog::with('user')->latest()->limit(5)->get();
    $blogs = Blog::with('user')->latest()->paginate(5);
    $categories = Tag::withCount('blogs')->orderByDesc('blogs_count')->get();

    return view('blog', ['footer' => $footer, 'blogs' => $blogs, 'recent' =>  $recent, 'categories' => $categories]);
})->name('blog.page');

Route::get('/blog/{slug}', [BlogController::class, 'landing'])->name('blog.landing');
Route::get('/blogs/search', [BlogController::class, 'search'])->name('blog.search');
Route::get('/blog/tag/{slug}', [BlogController::class, 'byTag'])->name('blog.tag');

// ! blog page route end

// ! route page creation
Route::get('/creation-page', function () {

    $creations = Creation::with(['users']) // ambil relasi user
        ->where('status', 'approve')->latest()
        ->paginate(5);

    $divisis = ['Website', 'Mobile', 'IoT', 'SistemCerdas', 'Multimedia'];

    $recent = Creation::where('status', 'approve')->latest()->take(5)->get();
    $footer = Footer::find(1);

    $categories = Creation::where('status', 'approve')->select('divisi', DB::raw('COUNT(*) as total'))
        ->groupBy('divisi')
        ->orderByDesc('total')
        ->get();

    return view('creation', [
        'creations' => $creations,
        'divisis' => $categories,
        'recent' => $recent,
        'footer' => $footer,
    ]);
})->name('creation.page');

Route::get('/creation/tag/{slug}', [CreationController::class, 'byTag'])->name('creation.tag');
Route::get('/creation/{slug}', [CreationController::class, 'landing'])->name('creation.landing');
Route::get('/creations/search', [CreationController::class, 'search'])->name('creation.search');
Route::get('/creation/divisi/{divisi}', [CreationController::class, 'byDivisi'])->name('creation.divisi');
// ! route page creation end

// ! dashboard routing
Route::middleware('auth', 'role:Admin,Pengurus')->group(function () {

    // ? surat
    Route::get('/form/letters', [LetterController::class, 'index'])->name('letters.index');
    Route::get('/form/letters/create', [LetterController::class, 'create'])->name('letters.create');
    Route::post('/form/letters', [LetterController::class, 'store'])->name('letters.store');
    Route::get('/form/letters/create/peminjaman', function () {
        return view('admin.letters.create-peminjaman');
    })->name('letters.peminjaman.create');
    Route::post('/form/letters/peminjaman/store', [LetterController::class, 'storePeminjaman'])
        ->name('letters.peminjaman.store');
    Route::get('/form/letters/{id}', [LetterController::class, 'show'])->name('letters.show');
    Route::get('/form/letters/delete/{id}', [LetterController::class, 'destroy'])->name('letters.delete');
    // ? surat end


    Route::get('/landing-page-form', [LandingPageController::class, 'create'])->name('form.landing');
    Route::post('/landing-page-form/submit', [LandingPageController::class, 'store'])->name('form.landing.store');

    // ? faq
    Route::get('/all-faqs', [FaqController::class, 'index'])->name('faq.index');
    Route::get('/faq-form', [FaqController::class, 'create'])->name('faq.landing');
    Route::POST('/faq-form/submit', [FaqController::class, 'store'])->name('faq.landing.store');
    Route::get('/faq-form/{id}', [FaqController::class, 'show'])->name('faq.landing.show');
    Route::POST('/faq-form/submit/{id}', [FaqController::class, 'store'])->name('faq.landing.update');
    Route::get('/faq/delete/{id}', [FaqController::class, 'destroy'])->name('faq.delete');
    // ? faq end

    // ? logo
    Route::get('/all-logo', [LogoController::class, 'index'])->name('logo.index');
    Route::get('/logo-form', [LogoController::class, 'create'])->name('logo.landing');
    Route::POST('/logo-form/store', [LogoController::class, 'store'])->name('logo.landing.store');
    Route::get('/logo-form/{id}', [LogoController::class, 'show'])->name('logo.landing.show');
    Route::get('/logo/delete/{id}', [LogoController::class, 'destroy'])->name('logo.delete');
    // ? logo end

    // ? footer
    Route::get('/footers', [FooterController::class, 'index'])->name('footer.index');
    Route::get('/footer-form', [FooterController::class, 'create'])->name('footer.create'); //* speertinya tidak digunakan
    Route::POST('/footer-form', [FooterController::class, 'store'])->name('footer.landing.store');
    Route::POST('/footer-form/submit/{id}', [FooterController::class, 'update'])->name('footer.landing.update');
    Route::get('/footer-form/{id}', [FooterController::class, 'show'])->name('footer.landing.show');
    Route::get('/footer/delete/{id}', [FooterController::class, 'destroy'])->name('footer.delete'); //* sepertinya tidak akan digunakan
    // ? footer end

    // ? Blog
    Route::get('/blog-form', [BlogController::class, 'create'])->name('blog.create');
    Route::get('/blog-form/{slug}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('/blog-form/{id}', [BlogController::class, 'store'])->name('blog.update');
    Route::post('/blog-form/submit', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog-form/delete/{id}', [BlogController::class, 'destroy'])->name('blog.delete');
    // ? Blog End

    // ? Tetimonial
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonial.index');
    Route::get('/testimonial-form', [TestimonialController::class, 'create'])->name('testimonial.create');
    Route::get('/testimonial-form/{id}', [TestimonialController::class, 'edit'])->name('testimonial.edit');
    Route::post('/testimonial-form/submit', [TestimonialController::class, 'store'])->name('testimonial.store');
    Route::post('/testimonial-form/submit/{id}', [TestimonialController::class, 'store'])->name('testimonial.update');
    Route::get('/testimonial-form/delete/{id}', [TestimonialController::class, 'destroy'])->name('testimonial.delete');
    // ? Tetimonial end

    // ? pengurus
    Route::get('/penguruses', [PengurusController::class, 'index'])->name('pengurus.index');
    Route::get('/pengurus-form', [PengurusController::class, 'create'])->name('pengurus.create');
    Route::post('/pengurus-form/submit', [PengurusController::class, 'store'])->name('pengurus.store');
    Route::post('/pengurus-form/submit/{id}', [PengurusController::class, 'store'])->name('pengurus.update');
    Route::get('/pengurus-form/{id}', [PengurusController::class, 'edit'])->name('pengurus.edit');
    Route::get('/pengurus-form/delete/{id}', [PengurusController::class, 'destroy'])->name('pengurus.delete');
    // ? pengurus end

    // ? Mentor
    Route::get('/mentors', [MentorController::class, 'index'])->name('mentor.index');
    Route::get('/mentor-form', [MentorController::class, 'create'])->name('mentor.create');
    Route::post('/mentor-form/submit', [MentorController::class, 'store'])->name('mentor.store');
    Route::post('/mentor-form/submit/{id}', [MentorController::class, 'store'])->name('mentor.update');
    Route::get('/mentor-form/{id}', [MentorController::class, 'edit'])->name('mentor.edit');
    Route::get('/mentor-form/delete/{id}', [MentorController::class, 'destroy'])->name('mentor.delete');
    // ? Mentor End

    // ? creation
    Route::get('/karya-divisi/{divisi}', [CreationController::class, 'karyaDivisi'])->name('creation.divisi');
    Route::get('/karya-form/{id}', [CreationController::class, 'edit'])->name('creation.edit');
    Route::post('/karya-form/submit', [CreationController::class, 'store'])->name('creation.store');
    Route::post('/karya-form/submit/{id}', [CreationController::class, 'store'])->name('creation.update');
    Route::get('/karya-form/delete/{id}', [CreationController::class, 'destroy'])->name('creation.delete');
    Route::get('/karya/validated/{id}', [CreationController::class, 'validasiKarya'])->name('creation.approve');
    Route::get('/karya/unvalidated/{id}', [CreationController::class, 'unValidasiKarya'])->name('creation.rejected');
    // ? creation end

    // ? verifikasi user
    Route::get('user/verify', [ProfileController::class, 'verifyUserIndex'])->name('verif.index');
    Route::post('users/verify/{id}', [ProfileController::class, 'verifyUser'])->name('verif.user');
    Route::post('users/verify/{id}/pengurus', [ProfileController::class, 'verifyPengurus'])->name('verif.pengurus');
    Route::post('users/unverify/{id}', [ProfileController::class, 'unVerifyUser'])->name('unverif.user');
    // ? verifikasi user end

    // ? information form
    Route::get('/information', [InformationController::class, 'documentIndex'])->name('information.index');
    Route::get('/information/create', [InformationController::class, 'documentCreate'])->name('information.create');
    Route::post('/information/store', [InformationController::class, 'documentStore'])->name('information.store');
    Route::get('/information/{id}/edit', [InformationController::class, 'documentEdit'])->name('information.edit');
    Route::post('/information/{id}/update', [InformationController::class, 'documentUpdate'])->name('information.update');
    Route::delete('/information/{id}', [InformationController::class, 'documentDestroy'])->name('information.destroy');
    // ? information form end

});
// ! dashboard routing end

Route::middleware('auth', 'role:Anggota,Admin,Pengurus')->group(function () {
    Route::get('/karya', [CreationController::class, 'index'])->name('creation.index');
    Route::get('/karya-form', [CreationController::class, 'create'])->name('creation.create');
    Route::post('/karya-form/submit', [CreationController::class, 'store'])->name('creation.store');
    Route::get('/karya-form/{id}', [CreationController::class, 'edit'])->name('creation.edit');
    Route::post('/karya-form/submit/{id}', [CreationController::class, 'store'])->name('creation.update');
    Route::get('/karya-form/delete/{id}', [CreationController::class, 'destroy'])->name('creation.delete');
});

Route::middleware('auth')->group(function () {
    // ! dashboard main
    Route::get('/dashboard', function () {
        // ? just for qoute
        $quotes = [
            "Jangan menyerah sebelum mencoba.",
            "Keberuntungan Berpihak Pada Yang Berani",
            "Hari ini lebih baik dari kemarin.",
            "Setiap langkah kecil membawa perubahan besar.",
            "Berani gagal adalah kunci untuk menang."
        ];
        $randomQuote = $quotes[array_rand($quotes)];
        // ? qoute end
        /** @var \App\Models\User $user */ //?ini biar tidak muncul error di error lens
        $user = Auth::user();
        $userCount = User::count();
        $userActiveCount = User::where('role', '!=', 'None')->count();
        $creationActiveCount = Creation::where('status', 'approve')->count();
        $creationCount = Creation::count();
        $myCreation = $user->creations()->wherePivot('is_creator', true)->count();
        $totalLikes = Creation::whereHas('users', function ($q) use ($user) {
            $q->where('users.id', $user->id)
                ->where('creation_user.is_creator', true);
        })->withCount('likes')->get()->sum('likes_count');
        $regist = User::count();

        return view('admin.dashboard', [
            'quote' => $randomQuote,
            'userCount' => $userCount,
            'userActiveCount' => $userActiveCount,
            'creationActiveCount' => $creationActiveCount,
            'creationCount' => $creationCount,
            'myCreation' => $myCreation,
            'totalLikes' => $totalLikes,
            'regist' => $regist,
        ]);
    })->name('dashboard');
    // ! dashboard main end

    // ? karya
    Route::post('/creations/{id}/like', [CreationController::class, 'toggleLike'])->name('creation.like');
    // ? karya end

    // ? profile start
    Route::get('/profile-settings', [ProfileController::class, 'index'])->name('profile.index');
    Route::PUT('/profile-settings/submit', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // ? profile end
});
require __DIR__ . '/auth.php';

// ! hanya untuk test development


Route::get('/testing', function () {
    $users = User::where('role', '!=', 'Admin')->get();
    // dd($user);
    return view('admin.creation', ['users' => $users]);
});
