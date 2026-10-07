@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Everything on your public portfolio at a glance')

@section('header-actions')
    <a href="{{ route('portfolio.index') }}" target="_blank" rel="noopener" class="btn-secondary">
        <i class="fas fa-external-link-alt"></i> View live site
    </a>
@endsection

@section('content')
    @if (! $profile)
        <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-800">
            <p class="font-semibold">Your portfolio has no profile yet.</p>
            <p class="mt-1">Add your name, headline and bio so visitors know who you are.</p>
            <a href="{{ route('admin.profile.edit') }}" class="btn-primary mt-3 !py-1.5">Set up my profile</a>
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['label' => 'Projects', 'value' => $stats['projects'], 'icon' => 'fa-layer-group', 'route' => 'admin.projects.index', 'color' => 'bg-indigo-50 text-indigo-600'],
            ['label' => 'Skills', 'value' => $stats['skills'], 'icon' => 'fa-bolt', 'route' => 'admin.skills.index', 'color' => 'bg-amber-50 text-amber-600'],
            ['label' => 'Experience', 'value' => $stats['experiences'], 'icon' => 'fa-briefcase', 'route' => 'admin.experiences.index', 'color' => 'bg-emerald-50 text-emerald-600'],
            ['label' => 'Education', 'value' => $stats['educations'], 'icon' => 'fa-graduation-cap', 'route' => 'admin.educations.index', 'color' => 'bg-sky-50 text-sky-600'],
        ] as $card)
            <a href="{{ route($card['route']) }}" class="panel flex items-center gap-4 p-5 transition hover:border-indigo-200 hover:shadow">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl {{ $card['color'] }}">
                    <i class="fas {{ $card['icon'] }} text-lg"></i>
                </span>
                <div>
                    <p class="text-2xl font-extrabold text-slate-900">{{ $card['value'] }}</p>
                    <p class="text-sm text-slate-500">{{ $card['label'] }}</p>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="panel lg:col-span-2">
            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500">Latest projects</h2>
                <a href="{{ route('admin.projects.index') }}" class="text-sm font-semibold text-indigo-600 hover:underline">Manage all</a>
            </div>

            @if ($latestProjects->isEmpty())
                <div class="px-5 py-10 text-center text-sm text-slate-500">
                    No projects yet.
                    <a href="{{ route('admin.projects.create') }}" class="ml-1 font-semibold text-indigo-600 hover:underline">Add your first project</a>
                </div>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($latestProjects as $project)
                        <li class="flex items-center justify-between gap-4 px-5 py-4">
                            <div class="flex min-w-0 items-center gap-3">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                                    <i class="fas fa-code"></i>
                                </span>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-slate-900">{{ $project->title }}</p>
                                    <p class="truncate text-xs text-slate-500">{{ $project->summary ?: Str::limit(strip_tags((string) $project->description), 60) ?: 'No summary' }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn-secondary !px-3 !py-1.5 shrink-0">
                                Edit
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="space-y-6">
            <div class="panel p-5">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500">Quick actions</h2>
                <div class="mt-4 space-y-2">
                    @foreach ([
                        ['admin.profile.edit', 'fa-user', 'Edit profile & about'],
                        ['admin.projects.create', 'fa-plus', 'Add a project'],
                        ['admin.skills.create', 'fa-bolt', 'Add a skill'],
                        ['admin.experiences.create', 'fa-briefcase', 'Add experience'],
                        ['admin.educations.create', 'fa-graduation-cap', 'Add education'],
                    ] as [$route, $icon, $label])
                        <a href="{{ route($route) }}" class="flex items-center gap-3 rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 transition hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-700">
                            <i class="fas {{ $icon }} w-4 text-center text-slate-400"></i> {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            @if ($profile)
                <div class="panel p-5">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500">Live preview</h2>
                    <div class="mt-4 flex items-center gap-4">
                        @if ($profile->avatar_url)
                            <img src="{{ $profile->avatar_url }}" alt="" class="h-14 w-14 rounded-xl object-cover">
                        @else
                            <span class="flex h-14 w-14 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                                <i class="fas fa-user"></i>
                            </span>
                        @endif
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-slate-900">{{ $profile->full_name }}</p>
                            <p class="truncate text-sm text-slate-500">{{ $profile->headline ?: 'Add a headline' }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
