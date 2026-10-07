<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;

class ExperienceController extends Controller
{
    public function index()
    {
        return view('admin.experiences.index', [
            'experiences' => Experience::query()->ordered()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.experiences.create', [
            'experience' => new Experience,
        ]);
    }

    public function store(ExperienceRequest $request): RedirectResponse
    {
        Experience::create($this->payload($request));

        return redirect()
            ->route('admin.experiences.index')
            ->with('success', 'Experience added successfully.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', [
            'experience' => $experience,
        ]);
    }

    public function update(ExperienceRequest $request, Experience $experience): RedirectResponse
    {
        $experience->fill($this->payload($request))->save();

        return redirect()
            ->route('admin.experiences.index')
            ->with('success', 'Experience updated successfully.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->is_deleted = 1;
        $experience->save();

        return redirect()
            ->route('admin.experiences.index')
            ->with('success', 'Experience removed successfully.');
    }

    private function payload(ExperienceRequest $request): array
    {
        return array_merge($request->validated(), [
            'is_current' => $request->boolean('is_current'),
        ]);
    }
}
