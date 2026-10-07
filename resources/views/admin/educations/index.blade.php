@extends('layouts.admin')

@section('title', 'Education')
@section('heading', 'Education')
@section('subheading', 'Degrees, courses and certifications')

@section('header-actions')
    <a href="{{ route('admin.educations.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Add education
    </a>
@endsection

@section('content')
    <div class="panel overflow-hidden">
        @if ($educations->isEmpty())
            <div class="px-5 py-14 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </span>
                <p class="mt-4 font-semibold text-slate-900">No education entries yet</p>
                <p class="mt-1 text-sm text-slate-500">Add your degrees or certifications.</p>
                <a href="{{ route('admin.educations.create') }}" class="btn-primary mt-5">Add education</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="table-head">Qualification</th>
                            <th class="table-head hidden sm:table-cell">Institution</th>
                            <th class="table-head hidden lg:table-cell">Years</th>
                            <th class="table-head text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($educations as $education)
                            <tr class="{{ $education->is_deleted ? 'bg-slate-50/70 opacity-60' : '' }}">
                                <td class="table-cell">
                                    <p class="font-semibold text-slate-900">
                                        {{ $education->degree }}
                                        @if ($education->is_deleted)
                                            <span class="ml-1 rounded bg-slate-200 px-1.5 py-0.5 text-[0.65rem] font-bold text-slate-600">Hidden</span>
                                        @endif
                                    </p>
                                </td>
                                <td class="table-cell hidden sm:table-cell text-slate-600">
                                    {{ $education->institution }}
                                    @if ($education->location)
                                        <span class="block text-xs text-slate-400">{{ $education->location }}</span>
                                    @endif
                                </td>
                                <td class="table-cell hidden lg:table-cell text-slate-600">{{ $education->year_range ?: '—' }}</td>
                                <td class="table-cell">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.educations.edit', $education) }}" class="btn-secondary !px-3 !py-1.5">
                                            <i class="fas fa-pen"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.educations.destroy', $education) }}"
                                              onsubmit="return confirm('Remove this education entry from the public site?');">
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
