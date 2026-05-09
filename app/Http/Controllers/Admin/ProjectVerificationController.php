<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectVerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $projects = $query->latest()->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    public function allProject(Request $request)
    {
        $query = Project::where('status', true);

        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $projects = $query->latest()->paginate(15);

        return view('admin.projects.monitoring', compact('projects'));
    }

    public function verify(Project $project)
    {
        $project->status = true;
        $project->rejection_reason = null;
        $project->is_revised = false;
        $project->save();

        return back()->with('success', 'Project verified successfully.');
    }

    public function unverify(Request $request, Project $project)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi!',
        ]);

        $project->status = false;
        $project->rejection_reason = $request->rejection_reason;
        $project->is_revised = false;
        $project->save();

        return back()->with('success', 'Project unverified successfully.');
    }
}
