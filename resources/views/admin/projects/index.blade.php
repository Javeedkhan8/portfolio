@extends('layouts.admin')

@section('title', 'Projects')
@section('heading', 'Projects')
@section('subheading', 'Showcase the work you are proud of')

@section('header-actions')
    <a href="{{ route('admin.projects.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Add project
    </a>
@endsection

@section('content')
    <div class="panel overflow-hidden">
        @if ($projects->isEmpty())
            <div class="px-5 py-14 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                    <i class="fas fa-layer-group text-xl"></i>
                </span>
                <p class="mt-4 font-semibold text-slate-900">No projects yet</p>
                <p class="mt-1 text-sm text-slate-500">Add your first project to show it on the public portfolio.</p>
                <a href="{{ route('admin.projects.create') }}" class="btn-primary mt-5">Add project</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="table-head">Project</th>
                            <th class="table-head hidden md:table-cell">Stack</th>
                            <th class="table-head hidden lg:table-cell">Order</th>
                            <th class="table-head text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($projects as $project)
                            <tr class="{{ $project->is_deleted ? 'bg-slate-50/70 opacity-60' : '' }}">
                                <td class="table-cell">
                                    <div class="flex items-center gap-3">
                                        @if ($project->image_url)
                                            <img src="{{ $project->image_url }}" alt="" class="h-11 w-16 shrink-0 rounded-lg object-cover">
                                        @else
                                            <span class="flex h-11 w-16 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-400">
                                                <i class="fas fa-image"></i>
                                            </span>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-slate-900">
                                                {{ $project->title }}
                                                @if ($project->featured)
                                                    <span class="ml-1 rounded bg-amber-100 px-1.5 py-0.5 text-[0.65rem] font-bold text-amber-700">Featured</span>
                                                @endif
                                                @if ($project->is_deleted)
                                                    <span class="ml-1 rounded bg-slate-200 px-1.5 py-0.5 text-[0.65rem] font-bold text-slate-600">Hidden</span>
                                                @endif
                                            </p>
                                            <p class="truncate text-xs text-slate-500">{{ $project->summary ?: Str::limit(strip_tags((string) $project->description), 70) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell hidden md:table-cell">
                                    <div class="flex max-w-xs flex-wrap gap-1">
                                        @forelse ($project->tech_list as $tech)
                                            <span class="rounded bg-slate-100 px-1.5 py-0.5 text-xs text-slate-600">{{ $tech }}</span>
                                        @empty
                                            <span class="text-xs text-slate-400">&mdash;</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="table-cell hidden lg:table-cell text-slate-500">{{ $project->sort_order }}</td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn-secondary !px-3 !py-1.5">
                                            <i class="fas fa-pen"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                                              onsubmit="return confirm('Remove this project from the public site?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
