<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectLike;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    public function index()
    {
        // Tampilkan project dimana user tersebut terlibat
        $projects = Auth::user()->projects()->latest()->paginate(9);
        return view('user.projects.index', compact('projects'));
    }

    public function create()
    {
        // Ambil semua user untuk dipilih jadi anggota tim (kecuali diri sendiri)
        $users = User::where('id', '!=', Auth::id())->where('role', '!=', 'admin')->get();
        return view('user.projects.form', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'division' => 'required|in:mobile,iot,uiux,sistem_cerdas,website',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Validasi backend tetap perlu
            'team_members' => 'array' // Array ID user
        ]);

        // 1. Upload Gambar
        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/projects'), $imageName);

        // 2. Buat Project
        $project = Project::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'description' => $request->description,
            'division' => $request->division,
            'image' => $imageName,
        ]);

        $team = $request->team_members ?? [];
        if (!in_array(Auth::id(), $team)) {
            array_push($team, Auth::id());
        }
        $project->users()->attach($team);

        return redirect()->route('projects.index')->with('success', 'Karya berhasil dipublish!');
    }

    public function edit(Project $project)
    {
        // Pastikan user adalah anggota project ini
        if (!$project->users->contains(Auth::id())) {
            abort(403);
        }

        $users = User::where('id', '!=', Auth::id())->where('role', '!=', 'admin')->get();
        // Ambil ID anggota tim selain user login
        $currentTeam = $project->users->pluck('id')->toArray();

        return view('user.projects.form', compact('project', 'users', 'currentTeam'));
    }

    public function update(Request $request, Project $project)
    {
        if (!$project->users->contains(Auth::id())) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'division' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5), // Update slug (opsional)
            'description' => $request->description,
            'division' => $request->division,
        ];

        // Cek jika ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if (File::exists(public_path('uploads/projects/' . $project->image))) {
                File::delete(public_path('uploads/projects/' . $project->image));
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/projects'), $imageName);
            $data['image'] = $imageName;
        }

        $project->update($data);

        // Sync Tim (Hati-hati jangan hapus diri sendiri)
        $team = $request->team_members ?? [];
        if (!in_array(Auth::id(), $team)) {
            array_push($team, Auth::id());
        }
        $project->users()->sync($team);

        return redirect()->route('projects.index')->with('success', 'Karya diperbarui!');
    }

    public function destroy(Project $project)
    {
        if (!$project->users->contains(Auth::id())) {
            abort(403);
        }

        if (File::exists(public_path('uploads/projects/' . $project->image))) {
            File::delete(public_path('uploads/projects/' . $project->image));
        }

        $project->delete();
        return back()->with('success', 'Project dihapus.');
    }

    public function toggleLike(Project $project)
    {
        $user = Auth::user();

        // Cek apakah sudah like
        $existingLike = ProjectLike::where('project_id', $project->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete(); // Unlike
            return response()->json(['status' => 'unliked']);
        } else {
            ProjectLike::create([
                'project_id' => $project->id,
                'user_id' => $user->id
            ]); // Like
            return response()->json(['status' => 'liked']);
        }
    }


}
