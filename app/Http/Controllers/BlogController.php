<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Blog;
use App\Models\Footer;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('query', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        try {
            $blogs = Blog::with('user') // relasi ke penulis
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%");
                })
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

            $results = $blogs->map(function ($blog) {
                return [
                    'id'          => $blog->id,
                    'title'       => $blog->title,
                    'slug'        => $blog->slug,
                    'first_image' => $blog->first_image ?? '/default.jpg', // pakai accessor kalau ada
                    'created_at'  => optional($blog->created_at)->toDateTimeString(),
                    'author_name' => optional($blog->user)->name,
                ];
            });

            return response()->json($results->values());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Search failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function landing($slug)
    {
        $footer = Footer::find(1);
        $recent = Blog::with('user')->latest()->limit(5)->get();
        $blogs = Blog::with('user')->latest()->paginate(5);
        $categories = Tag::withCount('blogs')->orderByDesc('blogs_count')->get();
        $blog = Blog::where("slug", $slug)->first();

        return view('blog-detail', ['footer' => $footer, 'blogs' => $blogs, 'blog' => $blog, 'recent' =>  $recent, 'categories' => $categories]);
    }
    public function create()
    {
        $tags = Tag::all(); // kirim daftar tag ke view
        return view('admin.blog-index', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp',
            'id'        => 'nullable|integer',
            'old_image' => 'nullable|string',
            'tags'      => 'array',
            'tags.*'    => 'string|max:50',
        ]);

        // ✅ Perbaikan utama di sini
        $isUpdate = $request->filled('id');

        $blog = $isUpdate
            ? Blog::find($request->id)
            : new Blog(['user_id' => Auth::id()]);

        if ($isUpdate && !$blog) {
            return redirect()
                ->back()
                ->withErrors(['id' => 'Blog tidak ditemukan untuk diperbarui.'])
                ->withInput();
        }

        // === Handle Gambar ===
        $compressedPath = $blog->image ?? null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->getPathname();
            $fileName = uniqid('blog_') . '.webp';
            $savePath = storage_path('app/public/blog/' . $fileName);

            ImageHelper::compressImage($imagePath, $savePath, 75, 1280);
            $compressedPath = 'storage/blog/' . $fileName;

            if ($isUpdate && $blog->image && file_exists(public_path($blog->image))) {
                @unlink(public_path($blog->image));
            }
        } elseif ($isUpdate && !empty($validated['old_image'])) {
            $compressedPath = $validated['old_image'];
        }

        // === Slug ===
        $slug = $blog->slug ?? Str::slug($validated['title']);

        if (!$isUpdate || $validated['title'] !== $blog->title) {
            $slug = Str::slug($validated['title']);
            $originalSlug = $slug;
            $counter = 1;

            while (
                Blog::where('slug', $slug)
                ->when($isUpdate, fn($q) => $q->where('id', '!=', $blog->id))
                ->exists()
            ) {
                $slug = $originalSlug . '-' . $counter++;
            }
        }

        $content = ImageHelper::saveBase64Images($validated['content']);

        $blog->fill([
            'title'   => $validated['title'],
            'slug'    => $slug,
            'content' => $content,
            'image'   => $compressedPath,
        ]);

        $blog->save();

        // === Tags ===
        $tagIds = [];
        if ($request->filled('tags')) {
            foreach ($request->tags as $tagName) {
                $tagName = trim($tagName);
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $tagIds[] = $tag->id;
            }
        }
        $blog->tags()->sync($tagIds);

        return redirect()
            ->to($isUpdate ? route('blog.edit', $blog->slug) : route('blog.create'))
            ->with('success', $isUpdate ? 'Blog berhasil diperbarui!' : 'Blog berhasil dibuat!');
    }

    public function edit($slug)
    {
        $tags = Tag::all();
        $blog = Blog::where('slug', $slug)->first();
        // dd($blog);
        return view('admin.blog-index', compact('blog', 'tags'));
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // === 1️⃣ Cari semua tag <img> di dalam konten ===
        preg_match_all('/<img[^>]+src="([^">]+)"/i', $blog->content, $matches);
        $imagePaths = $matches[1] ?? [];

        // === 2️⃣ Hapus semua file gambar yang ditemukan ===
        foreach ($imagePaths as $src) {
            // Lewati kalau src base64 (bukan file)
            if (strpos($src, 'data:image') === 0) {
                continue;
            }

            // Ambil path relatif
            $path = str_replace(asset(''), '', $src); // hilangkan domain
            $path = ltrim($path, '/'); // buang slash di depan

            // Ubah ke path storage
            $storagePath = str_replace('storage/', 'public/', $path);

            if (Storage::exists($storagePath)) {
                Storage::delete($storagePath);
            } elseif (file_exists(public_path($path))) {
                unlink(public_path($path));
            }
        }

        // === 3️⃣ Hapus relasi tags jika ada ===
        if (method_exists($blog, 'tags')) {
            $blog->tags()->detach();
        }

        // === 4️⃣ Hapus data blog ===
        $blog->delete();

        return redirect()->back()->with('success', 'Blog dan semua gambar di konten berhasil dihapus');
    }

    public function byTag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $blogs = $tag->blogs()->latest()->paginate(5);

        $footer = Footer::find(1);
        $recent = Blog::with('user')->latest()->limit(5)->get();
        $blogs = Blog::with('user')->latest()->paginate(5);
        $categories = Tag::withCount('blogs')->orderByDesc('blogs_count')->get();

        return view('blog', ['footer' => $footer, 'blogs' => $blogs, 'recent' =>  $recent, 'categories' => $categories,]);
    }
}
