<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EducationRequest;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;

class EducationController extends Controller
{
    public function index()
    {
        return view('admin.educations.index', [
            'educations' => Education::query()->ordered()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.educations.create', [
            'education' => new Education,
        ]);
    }

    public function store(EducationRequest $request): RedirectResponse
    {
        Education::create($request->validated());

        return redirect()
            ->route('admin.educations.index')
            ->with('success', 'Education added successfully.');
    }

    public function edit(Education $education)
    {
        return view('admin.educations.edit', [
            'education' => $education,
        ]);
    }

    public function update(EducationRequest $request, Education $education): RedirectResponse
    {
        $education->fill($request->validated())->save();

        return redirect()
            ->route('admin.educations.index')
            ->with('success', 'Education updated successfully.');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $education->is_deleted = 1;
        $education->save();

        return redirect()
            ->route('admin.educations.index')
            ->with('success', 'Education removed successfully.');
    }
}
