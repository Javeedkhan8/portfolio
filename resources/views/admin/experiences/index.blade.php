@extends('layouts.admin')

@section('title', 'Experience')
@section('heading', 'Experience')
@section('subheading', 'Your work history, newest first')

@section('header-actions')
    <a href="{{ route('admin.experiences.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Add experience
    </a>
@endsection

@section('content')
    <div class="panel overflow-hidden">
        @if ($experiences->isEmpty())
            <div class="px-5 py-14 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                    <i class="fas fa-briefcase text-xl"></i>
                </span>
                <p class="mt-4 font-semibold text-slate-900">No experience entries yet</p>
                <p class="mt-1 text-sm text-slate-500">Add your current role and past positions.</p>
                <a href="{{ route('admin.experiences.create') }}" class="btn-primary mt-5">Add experience</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="table-head">Role</th>
                            <th class="table-head hidden md:table-cell">Period</th>
                            <th class="table-head hidden lg:table-cell">Order</th>
                            <th class="table-head text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($experiences as $experience)
                            <tr class="{{ $experience->is_deleted ? 'bg-slate-50/70 opacity-60' : '' }}">
                                <td class="table-cell">
                                    <p class="font-semibold text-slate-900">
                                        {{ $experience->job_title }}
                                        @if ($experience->is_current)
                                            <span class="ml-1 rounded bg-emerald-100 px-1.5 py-0.5 text-[0.65rem] font-bold text-emerald-700">Current</span>
                                        @endif
                                        @if ($experience->is_deleted)
                                            <span class="ml-1 rounded bg-slate-200 px-1.5 py-0.5 text-[0.65rem] font-bold text-slate-600">Hidden</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ $experience->company }}@if ($experience->location) &middot; {{ $experience->location }}@endif
                                    </p>
                                </td>
                                <td class="table-cell hidden md:table-cell text-slate-600">{{ $experience->date_range ?: '—' }}</td>
                                <td class="table-cell hidden lg:table-cell text-slate-500">{{ $experience->sort_order }}</td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.experiences.edit', $experience) }}" class="btn-secondary !px-3 !py-1.5">
                                            <i class="fas fa-pen"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.experiences.destroy', $experience) }}"
                                              onsubmit="return confirm('Remove this experience from the public site?');">
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
