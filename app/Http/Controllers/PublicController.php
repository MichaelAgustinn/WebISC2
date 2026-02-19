<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\Project;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Halaman List Karya (Creation)
    public function creation(Request $request)
    {
        $query = Project::where('status', true)->with('users')->latest();

        // 1. Search
        if ($request->has('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // 2. Filter Category
        if ($request->has('category')) {
            $query->where('division', $request->category);
        }

        $projects = $query->paginate(6);
        $recentProjects = Project::where('status', true)->latest()->take(3)->get();

        // Hitung jumlah project per divisi untuk Sidebar
        $categories = [
            'mobile' => Project::where('division', 'mobile')->where('status', true)->count(),
            'website' => Project::where('division', 'website')->where('status', true)->count(),
            'uiux' => Project::where('division', 'uiux')->where('status', true)->count(),
            'iot' => Project::where('division', 'iot')->where('status', true)->count(),
            'sistem_cerdas' => Project::where('division', 'sistem_cerdas')->where('status', true)->count(),
        ];

        $landingData = LandingPage::pluck('value', 'key')->toArray();

        return view('creation.creation', ['projects' => $projects, 'recentProjects' => $recentProjects, 'categories' => $categories, 'data' => $landingData]);
    }

    // Halaman Detail Karya
    public function creationDetail($slug)
    {
        $project = Project::where('status', true)->with('users')->where('slug', $slug)->firstOrFail();

        // Logic Next/Prev Project
        $prevProject = Project::where('id', '<', $project->id)->orderBy('id', 'desc')->first();
        $nextProject = Project::where('id', '>', $project->id)->orderBy('id', 'asc')->first();
        $landingData = LandingPage::pluck('value', 'key')->toArray();
        return view('creation.creation-detail', ['project' => $project, 'prevProject' => $prevProject, 'nextProject' => $nextProject, 'data' => $landingData]);
    }
}
