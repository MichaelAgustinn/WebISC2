<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    // --- HALAMAN PUBLIC (LANDING PAGE) ---

    public function index(Request $request)
    {
        $query = Post::with(['user', 'categories'])->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->paginate(6);
        $recentPosts = Post::latest()->take(3)->get();

        $popularCategories = Category::withCount('posts')
            ->having('posts_count', '>', 0)
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();

        $data = LandingPage::pluck('value', 'key')->toArray();


        return view('blog.blog', compact('posts', 'recentPosts', 'popularCategories', 'data'));
    }

    public function show($slug)
    {
        // 1. Ambil Postingan Utama
        $post = Post::with(['user', 'comments.user', 'categories'])
            ->where('slug', $slug)
            ->firstOrFail();

        // 2. Data Sidebar (Sama seperti index)
        $recentPosts = Post::latest()->take(3)->get();
        $popularCategories = Category::withCount('posts')
            ->having('posts_count', '>', 0)
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();

        // 3. Logika Next/Prev Post
        $prevPost = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();
        $nextPost = Post::where('id', '>', $post->id)->orderBy('id', 'asc')->first();

        $data = LandingPage::pluck('value', 'key')->toArray();

        return view('blog.blog-detail', compact('post', 'recentPosts', 'popularCategories', 'prevPost', 'nextPost', 'data'));
    }

    public function manage()
    {
        $posts = Post::where('user_id', Auth::id())->with('categories')->latest()->paginate(10);
        return view('user.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('user.posts.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'title' => 'required|max:255',
            'categories_input' => 'required|string', // Pastikan nama inputnya sama dengan di View
            'description' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // 2. Upload Gambar
        $imagePath = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/posts'), $filename);
            $imagePath = 'uploads/posts/' . $filename;
        }

        // 3. Create Post
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'description' => $request->description,
            'thumbnail' => $imagePath,
        ]);

        // 4. Simpan Kategori (Multi Tags)
        $this->syncCategories($post, $request->categories_input);

        return redirect()->route('posts.manage')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) abort(403);
        // Load relasi categories agar muncul di form edit
        $post->load('categories');
        return view('user.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|max:255',
            'categories_input' => 'required|string', // Nama input disesuaikan (bukan category_name)
            'description' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // 1. Cek Upload Gambar Baru
        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail && File::exists(public_path($post->thumbnail))) {
                File::delete(public_path($post->thumbnail));
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/posts'), $filename);

            $post->thumbnail = 'uploads/posts/' . $filename;
        }

        // 2. Update Data Post
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // 3. Update Kategori (Multi Tags)
        $this->syncCategories($post, $request->categories_input);

        return redirect()->route('posts.manage')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) abort(403);

        if ($post->thumbnail && File::exists(public_path($post->thumbnail))) {
            File::delete(public_path($post->thumbnail));
        }

        $post->categories()->detach(); // Hapus relasi pivot dulu
        $post->delete();

        return back()->with('success', 'Artikel dihapus.');
    }

    // --- HELPER FUNCTION ---
    private function syncCategories($post, $tagsString)
    {
        if (!$tagsString) {
            $post->categories()->detach();
            return;
        }

        // Pecah string "Laravel,PHP" -> Array
        $tags = explode(',', $tagsString);
        $categoryIds = [];

        foreach ($tags as $tagName) {
            $name = trim($tagName);
            if (empty($name)) continue;

            // Cari atau Buat Kategori Baru
            $cat = Category::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );
            $categoryIds[] = $cat->id;
        }

        // Sync ke Pivot Table
        $post->categories()->sync($categoryIds);
    }

    // --- KOMENTAR ---
    public function storeComment(Request $request, Post $post)
    {
        // 1. Validasi Input
        $request->validate([
            'body' => 'required|string|max:1000', // Maksimal 1000 karakter agar tidak spam
        ]);

        // 2. Simpan ke Database
        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(), // Ambil ID user yang sedang login
            'body' => $request->body,
        ]);

        // 3. Redirect Kembali dengan Pesan Sukses
        // Menggunakan anchor #comments agar halaman scroll langsung ke bagian komentar
        return back()->with('success', 'Komentar berhasil dikirim!')->withFragment('comments');
    }

    // HAPUS KOMENTAR
    public function destroyComment(Comment $comment)
    {
        // Cek apakah yang menghapus adalah pemilik komentar
        if (Auth::id() !== $comment->user_id) {
            abort(403, 'Anda tidak berhak menghapus komentar ini.');
        }

        $comment->delete();
        // withFragment('comments') agar setelah reload langsung scroll ke bagian komentar
        return back()->with('success', 'Komentar berhasil dihapus.')->withFragment('comments');
    }

    // UPDATE KOMENTAR
    public function updateComment(Request $request, Comment $comment)
    {
        // Cek pemilik
        if (Auth::id() !== $comment->user_id) {
            abort(403, 'Anda tidak berhak mengedit komentar ini.');
        }

        $request->validate([
            'body' => 'required|string|max:1000'
        ]);

        $comment->update([
            'body' => $request->body
        ]);

        return back()->with('success', 'Komentar berhasil diperbarui.')->withFragment('comments');
    }
}
