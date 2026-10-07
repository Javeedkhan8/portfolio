<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        return view('admin.projects.index', [
            'projects' => Project::query()->ordered()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.projects.create', [
            'project' => new Project,
        ]);
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeUpload($request->file('image'), 'projects');
        }

        Project::create($data);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', [
            'project' => $project,
        ]);
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteUpload($project->image);
            $data['image'] = $this->storeUpload($request->file('image'), 'projects');
        }

        if ($request->boolean('remove_image')) {
            $this->deleteUpload($project->image);
            $data['image'] = null;
        }

        $project->fill($data)->save();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->is_deleted = 1;
        $project->save();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project removed successfully.');
    }
}
