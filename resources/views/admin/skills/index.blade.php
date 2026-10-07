@extends('layouts.admin')

@section('title', 'Skills')
@section('heading', 'Skills')
@section('subheading', 'Group your tools and set a proficiency level')

@section('header-actions')
    <a href="{{ route('admin.skills.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Add skill
    </a>
@endsection

@section('content')
    <div class="panel overflow-hidden">
        @if ($skills->isEmpty())
            <div class="px-5 py-14 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                    <i class="fas fa-bolt text-xl"></i>
                </span>
                <p class="mt-4 font-semibold text-slate-900">No skills yet</p>
                <p class="mt-1 text-sm text-slate-500">Add the technologies you want to highlight.</p>
                <a href="{{ route('admin.skills.create') }}" class="btn-primary mt-5">Add skill</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="table-head">Skill</th>
                            <th class="table-head hidden sm:table-cell">Category</th>
                            <th class="table-head w-56">Proficiency</th>
                            <th class="table-head hidden lg:table-cell">Order</th>
                            <th class="table-head text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($skills as $skill)
                            <tr class="{{ $skill->is_deleted ? 'bg-slate-50/70 opacity-60' : '' }}">
                                <td class="table-cell">
                                    <p class="font-semibold text-slate-900">
                                        {{ $skill->name }}
                                        @if ($skill->is_deleted)
                                            <span class="ml-1 rounded bg-slate-200 px-1.5 py-0.5 text-[0.65rem] font-bold text-slate-600">Hidden</span>
                                        @endif
                                    </p>
                                </td>
                                <td class="table-cell hidden sm:table-cell text-slate-600">{{ $skill->category ?: '—' }}</td>
                                <td class="table-cell">
                                    <div class="flex items-center gap-2">
                                        <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-100">
                                            <div class="h-full rounded-full bg-indigo-500" style="width: {{ $skill->proficiency }}%"></div>
                                        </div>
                                        <span class="w-9 shrink-0 text-right text-xs font-semibold text-slate-500">{{ $skill->proficiency }}%</span>
                                    </div>
                                </td>
                                <td class="table-cell hidden lg:table-cell text-slate-500">{{ $skill->sort_order }}</td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.skills.edit', $skill) }}" class="btn-secondary !px-3 !py-1.5">
                                            <i class="fas fa-pen"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}"
                                              onsubmit="return confirm('Remove this skill from the public site?');">
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
