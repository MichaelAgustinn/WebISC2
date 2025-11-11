<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Blog;
use App\Models\Creation;
use App\Models\Footer;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Creation::query();

        if ($user->role !== 'Admin') {
            $query->whereHas('users', function ($q) use ($user) {
                $q->where('users.id', $user->id)
                    ->where('creation_user.is_creator', 1);
            });
        }

        // 🔍 Fitur Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('divisi', 'like', "%{$search}%");
            });
        }

        // 🔽 Filter Divisi
        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }

        // 🔽 Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $creations = $query->with('creator')->latest()->paginate(10)->appends($request->query());

        return view('admin.creation-index', compact('creations'));
    }

    public function landing($slug)
    {
        $creation = Creation::with(['users'])->where('slug', $slug)->first();

        $creation->load(['users' => function ($query) {
            $query->orderByDesc('is_creator');
        }]);

        $divisis = ['Website', 'Mobile', 'IoT', 'SistemCerdas', 'Multimedia'];

        $recent = Creation::where('status', 'approve')->latest()->take(5)->get();
        $footer = Footer::find(1);
        $divisis = Creation::where('status', 'approve')->select('divisi')
            ->selectRaw('COUNT(*) as creations_count')
            ->groupBy('divisi')
            ->get();

        return view('creation-detail', [
            'creation' => $creation,
            'divisis' => $divisis,
            'recent' => $recent,
            'footer' => $footer,
        ]);
    }

    public function karyaDivisi(Request $request, $divisi)
    {
        $user = Auth::user();
        $query = Creation::query();

        // ✅ Filter berdasarkan divisi dari URL
        $query->where('divisi', $divisi);

        // Jika bukan admin, tampilkan hanya karya yang dimiliki user
        if (strtolower($user->role) !== 'admin') {
            $query->whereHas('users', fn($q) => $q->where('user_id', $user->id));
        }

        // 🔍 Fitur Search (judul atau isi konten)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // 🔽 Filter Status (opsional)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ambil data dengan relasi pembuat
        $creations = $query->with('creator')->where('status', 'approve')
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.creation-divisi', compact('creations', 'divisi'));
    }

    public function create()
    {
        $users = User::where('role', '!=', 'Admin')->get();
        return view('admin.creation', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id'        => 'nullable|integer',
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp',
            'old_image' => 'nullable|string',
            'divisi'    => 'required|in:Mobile,Website,IoT,UI/UX,SistemCerdas',
            'status'    => 'nullable|in:pending,approve,rejected',
            'user_ids'  => 'array',
            'user_ids.*' => 'integer|exists:users,id',
        ]);

        $creation = null;
        $isUpdate = false;

        if (!empty($validated['id'])) {
            $creation = Creation::find($validated['id']);
            if ($creation) {
                $isUpdate = true;
            }
        }

        if (!$isUpdate) {
            $creation = new Creation([
                'status' => 'pending',
                'user_id' => Auth::id(),
            ]);
        }

        // === Handle Gambar Utama ===
        $compressedPath = $creation->image ?? null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->getPathname();
            $fileName = uniqid('creation_') . '.webp';
            $savePath = storage_path('app/public/creation/' . $fileName);

            ImageHelper::compressImage($imagePath, $savePath, 75, 1280);
            $compressedPath = 'storage/creation/' . $fileName;

            if ($isUpdate && $creation->image && file_exists(public_path($creation->image))) {
                @unlink(public_path($creation->image));
            }
        } elseif ($isUpdate && !empty($validated['old_image'])) {
            $compressedPath = $validated['old_image'];
        }

        // === Slug unik ===
        $slug = $creation->slug ?? Str::slug($validated['title']);
        if (!$isUpdate || $validated['title'] !== $creation->title) {
            $slug = Str::slug($validated['title']);
            $originalSlug = $slug;
            $counter = 1;
            while (
                Creation::where('slug', $slug)
                ->when($isUpdate, fn($q) => $q->where('id', '!=', $creation->id))
                ->exists()
            ) {
                $slug = $originalSlug . '-' . $counter++;
            }
        }

        // === Simpan gambar base64 di konten ===
        $content = $this->saveBase64ImagesFromContent($validated['content']);

        // === Jika tidak ada upload manual, ambil thumbnail dari konten ===
        if (!$request->hasFile('image') && preg_match('/<img[^>]+src="([^">]+)"/', $content, $matches)) {
            $compressedPath = $compressedPath ?? $matches[1];
        }

        // === Simpan ke DB ===
        $creation->fill([
            'title'   => $validated['title'],
            'slug'    => $slug,
            'content' => $content,
            'image'   => $compressedPath,
            'divisi'  => $validated['divisi'],
            'status'  => $validated['status'] ?? 'pending',
        ]);
        $creation->save();

        $userIds = $request->input('user_ids', []);
        $userIds[] = Auth::id();
        $creation->users()->sync(array_unique($userIds));
        $creation->users()->updateExistingPivot(Auth::id(), ['is_creator' => true]);

        return redirect()->back()->with('success', $isUpdate ? 'Creation berhasil diperbarui!' : 'Creation berhasil dibuat!');
    }

    public function edit($slug)
    {
        $user = Auth::user();
        $users = User::all();
        $creation = Creation::where('slug', $slug)->firstOrFail();

        if ($user->role !== 'Admin') {
            $isCreator = $creation->users()
                ->where('user_id', $user->id)
                ->where('creation_user.is_creator', 1)
                ->exists();

            if (! $isCreator) {
                abort(404);
            }
        }

        return view('admin.creation', compact('creation', 'users'));
    }

    public function destroy($id)
    {
        $creation = Creation::find($id);

        if (!$creation) {
            return redirect()
                ->back()
                ->withErrors(['message' => 'Creation tidak ditemukan.']);
        }

        // === Hapus relasi many-to-many (users) ===
        $creation->users()->detach();

        // === Hapus semua gambar dari konten Summernote ===
        $this->deleteImagesFromContent($creation->content);

        // === Hapus thumbnail jika ada ===
        if ($creation->image) {
            $this->deleteImageFromUrl($creation->image);
        }

        // === Hapus record dari database ===
        $creation->delete();

        return redirect()->back()->with('success', 'Creation berhasil dihapus!');
    }

    public function byDivisi($divisi)
    {
        $creations = Creation::where('status', 'approve')->with('users')
            ->where('divisi', $divisi)
            ->latest()
            ->paginate(5);

        $footer = Footer::find(1);
        $recent = Creation::where('status', 'approve')->with('users')->latest()->limit(5)->get();

        $categories = Creation::where('status', 'approve')->select('divisi', DB::raw('COUNT(*) as total'))
            ->groupBy('divisi')
            ->orderByDesc('total')
            ->get();

        return view('creation', [
            'footer'     => $footer,
            'creations'  => $creations,
            'recent'     => $recent,
            'divisis' => $categories,
            'selectedDivisi' => $divisi,
        ]);
    }

    public function validasiKarya($id)
    {
        $creation = Creation::find($id);
        $creation->status = 'approve';
        $creation->save();

        return redirect()->back()->with('success', 'Karya Di Validasi');
    }

    public function unValidasiKarya($id)
    {
        $creation = Creation::find($id);
        $creation->status = 'rejected';
        $creation->save();

        return redirect()->back()->with('success', 'Karya Di Tolak');
    }

    public function toggleLike($id)
    {
        $user = Auth::user();
        $creation = Creation::findOrFail($id);

        // cek apakah user sudah like sebelumnya
        $alreadyLiked = $creation->likes()->where('user_id', $user->id)->exists();

        if ($alreadyLiked) {
            $creation->likes()->detach($user->id);
            $message = 'Kamu batal menyukai karya ini.';
        } else {
            $creation->likes()->attach($user->id);
            $message = 'Kamu menyukai karya ini.';
        }

        return back()->with('success', $message);
    }


    public function search(Request $request)
    {
        $query = $request->query('query', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        try {
            $creations = Creation::with('users') // ✅ ambil relasi user
                ->whereRaw('LOWER(status) = ?', ['approve'])
                ->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($query) . '%'])
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

            // format hasil
            $results = $creations->map(function ($creation) {
                return [
                    'id'           => $creation->id,
                    'title'        => $creation->title,
                    'slug'         => $creation->slug,
                    'first_image'  => $creation->first_image ?? null,
                    'created_at'   => optional($creation->created_at)->toDateTimeString(),
                    // ✅ ambil nama dari user pertama
                    'creator_name' => optional($creation->users->first())->name,
                ];
            });

            return response()->json($results->values()); // ✅ pastikan array
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Search failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    private function deleteImagesFromContent($content)
    {
        // Ambil semua src dari tag <img>
        preg_match_all('/<img[^>]+src="([^">]+)"/', $content, $matches);

        foreach ($matches[1] as $src) {
            $this->deleteImageFromUrl($src);
        }
    }

    private function deleteImageFromUrl($url)
    {
        // Pastikan ini adalah URL storage (bukan eksternal)
        if (str_contains($url, '/storage/')) {
            $path = str_replace('/storage/', '', parse_url($url, PHP_URL_PATH));
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    private function saveBase64ImagesFromContent($content)
    {
        // Ambil semua gambar base64 dari tag <img>
        preg_match_all('/<img[^>]+src="data:image\/([^;]+);base64,([^">]+)"/i', $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $extension = strtolower($match[1]); // jpg/png/webp
            $base64Data = $match[2];

            $imageData = base64_decode($base64Data);
            if (!$imageData) continue; // skip jika decode gagal

            // Simpan file ke storage/app/public/creations/
            $fileName = 'creations/' . uniqid('img_') . '.' . $extension;
            Storage::disk('public')->put($fileName, $imageData);

            // Ganti src base64 dengan URL publik
            $url = Storage::url($fileName);
            $content = str_replace($match[0], '<img src="' . $url . '"', $content);
        }

        return $content;
    }
}
