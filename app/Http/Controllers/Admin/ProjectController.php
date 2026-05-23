<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresUploads;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use StoresUploads;
    public function index() { return view('admin.projects.index', ['projects' => Project::latest()->paginate(15)]); }
    public function create() { return view('admin.projects.form', ['project' => new Project()]); }
    public function edit(Project $project) { return view('admin.projects.form', compact('project')); }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['image'] = $this->uploadImage($request->file('image'));
        Project::create($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project saved successfully.');
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($path = $this->uploadImage($request->file('image'))) $data['image'] = $path;
        $project->update($data);
        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project) { $project->delete(); return back()->with('success', 'Project deleted successfully.'); }
    private function validated(Request $request): array { return $request->validate(['title' => 'required|max:160', 'description' => 'required|max:1200', 'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096']); }
}
