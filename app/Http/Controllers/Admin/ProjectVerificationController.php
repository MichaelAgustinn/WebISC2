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

  public function verify(Project $project)
  {
    $project->status = true;
    $project->save();

    return back()->with('success', 'Project verified successfully.');
  }

  public function unverify(Project $project)
  {
    $project->status = false;
    $project->save();

    return back()->with('success', 'Project unverified successfully.');
  }
}
