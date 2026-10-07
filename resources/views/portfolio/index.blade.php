@extends('layouts.portfolio')

@section('title', $profile?->full_name ?? 'Portfolio')
@section('meta_description', $profile?->headline ?? 'Personal portfolio')

@section('body')
    @php
        $name = $profile?->full_name ?? 'Your Name';
        $initials = Str::of($name)->explode(' ')->take(2)->map(fn ($part) => Str::upper(Str::substr($part, 0, 1)))->implode('');
        $socials = $profile?->socialLinks() ?? [];
        $socialIcons = ['github' => 'fab fa-github', 'linkedin' => 'fab fa-linkedin', 'twitter' => 'fab fa-twitter', 'website' => 'fas fa-globe'];
    @endphp

    <!-- Header -->
    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/80 backdrop-blur">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4 sm:px-6">
            <a href="#home" class="flex items-center gap-2 font-extrabold tracking-tight text-slate-900">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-sm text-white">{{ $initials }}</span>
                <span>{{ $name }}</span>
            </a>

            <nav class="hidden items-center gap-6 text-sm font-semibold text-slate-600 md:flex">
                <a href="#about" class="hover:text-indigo-600">About</a>
                @if ($projects->isNotEmpty())
                    <a href="#projects" class="hover:text-indigo-600">Projects</a>
                @endif
                @if ($skills->isNotEmpty())
                    <a href="#skills" class="hover:text-indigo-600">Skills</a>
                @endif
                @if ($experiences->isNotEmpty())
                    <a href="#experience" class="hover:text-indigo-600">Experience</a>
                @endif
                @if ($educations->isNotEmpty())
                    <a href="#education" class="hover:text-indigo-600">Education</a>
                @endif
                <a href="#contact" class="hover:text-indigo-600">Contact</a>
            </nav>

            @auth
                @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="btn-primary !px-3 !py-2">
                        <i class="fas fa-sliders"></i>
                        <span class="hidden sm:inline">Control Panel</span>
                    </a>
                @endif
            @endauth
        </div>
    </header>

    <!-- Hero -->
    <section id="home" class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(60%_60%_at_50%_0%,rgba(99,102,241,0.18),transparent)]"></div>

        <div class="relative mx-auto max-w-5xl px-4 py-20 text-center sm:px-6 sm:py-28">
            @if ($profile?->availability)
                <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    {{ $profile->availability }}
                </span>
            @endif

            <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-slate-900 sm:text-6xl">
                {{ $name }}
            </h1>

            @if ($profile?->headline)
                <p class="mx-auto mt-4 max-w-2xl text-lg text-slate-600 sm:text-xl">{{ $profile->headline }}</p>
            @endif

            <div class="mt-6 flex flex-wrap items-center justify-center gap-3 text-sm text-slate-600">
                @if ($profile?->location)
                    <span class="inline-flex items-center gap-1.5"><i class="fas fa-location-dot text-slate-400"></i>{{ $profile->location }}</span>
                @endif
                @if ($profile?->email)
                    <a href="mailto:{{ $profile->email }}" class="inline-flex items-center gap-1.5 hover:text-indigo-600">
                        <i class="fas fa-envelope text-slate-400"></i>{{ $profile->email }}
                    </a>
                @endif
                @if ($profile?->phone)
                    <span class="inline-flex items-center gap-1.5"><i class="fas fa-phone text-slate-400"></i>{{ $profile->phone }}</span>
                @endif
            </div>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                @if ($profile?->resume_url)
                    <a href="{{ $profile->resume_url }}" target="_blank" rel="noopener" class="btn-primary">
                        <i class="fas fa-file-arrow-down"></i> Download Resume
                    </a>
                @endif
                @if ($profile?->email)
                    <a href="#contact" class="btn-secondary">Get in touch</a>
                @endif
            </div>

            @if ($socials)
                <div class="mt-8 flex items-center justify-center gap-3">
                    @foreach ($socials as $network => $url)
                        <a href="{{ $url }}" target="_blank" rel="noopener" title="{{ ucfirst($network) }}"
                           class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-indigo-300 hover:text-indigo-600">
                            <i class="{{ $socialIcons[$network] ?? 'fas fa-link' }}"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- About -->
    @if ($profile?->bio)
        <section id="about" class="border-t border-slate-200 bg-white py-20">
            <div class="mx-auto max-w-5xl px-4 sm:px-6">
                <p class="section-eyebrow">About</p>
                <h2 class="section-title mt-2">A little about me</h2>
                <div class="mt-6 grid gap-10 md:grid-cols-3">
                    @if ($profile->avatar_url)
                        <div class="md:col-span-1">
                            <img src="{{ $profile->avatar_url }}" alt="{{ $profile->full_name }}"
                                 class="aspect-square w-full rounded-2xl border border-slate-200 object-cover shadow-sm">
                        </div>
                    @endif
                    <div class="{{ $profile->avatar_url ? 'md:col-span-2' : 'md:col-span-3' }}">
                        <div class="space-y-4 text-base leading-relaxed text-slate-600">
                            @foreach (preg_split('/\n\s*\n/', trim($profile->bio)) as $paragraph)
                                @if (trim($paragraph) !== '')
                                    <p>{{ trim($paragraph) }}</p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Skills -->
    @if ($skills->isNotEmpty())
        <section id="skills" class="py-20">
            <div class="mx-auto max-w-5xl px-4 sm:px-6">
                <p class="section-eyebrow">Toolkit</p>
                <h2 class="section-title mt-2">Skills &amp; tools</h2>

                <div class="mt-8 grid gap-8 sm:grid-cols-2">
                    @foreach ($skills as $category => $items)
                        <div class="card-shell p-6">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500">{{ $category }}</h3>
                            <ul class="mt-4 space-y-4">
                                @foreach ($items as $skill)
                                    <li>
                                        <div class="flex items-center justify-between text-sm font-medium text-slate-700">
                                            <span>{{ $skill->name }}</span>
                                            <span class="text-xs text-slate-400">{{ $skill->proficiency }}%</span>
                                        </div>
                                        <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-slate-100">
                                            <div class="h-full rounded-full bg-indigo-500" style="width: {{ $skill->proficiency }}%"></div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Projects -->
    @if ($projects->isNotEmpty())
        <section id="projects" class="border-t border-slate-200 bg-white py-20">
            <div class="mx-auto max-w-5xl px-4 sm:px-6">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="section-eyebrow">Work</p>
                        <h2 class="section-title mt-2">Projects</h2>
                    </div>
                </div>

                <div class="mt-8 grid gap-6 sm:grid-cols-2">
                    @foreach ($projects as $project)
                        <article class="card-shell flex flex-col overflow-hidden transition hover:shadow-md">
                            @if ($project->image_url)
                                <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="aspect-video w-full object-cover">
                            @endif

                            <div class="flex flex-1 flex-col p-6">
                                <div class="flex items-start justify-between gap-3">
                                    <h3 class="text-lg font-bold text-slate-900">{{ $project->title }}</h3>
                                    @if ($project->featured)
                                        <span class="shrink-0 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-bold text-amber-700">Featured</span>
                                    @endif
                                </div>

                                @if ($project->summary)
                                    <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $project->summary }}</p>
                                @elseif ($project->description)
                                    <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ Str::limit(strip_tags($project->description), 160) }}</p>
                                @endif

                                @if ($project->tech_list)
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach ($project->tech_list as $tech)
                                            <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                @if ($project->live_url || $project->repo_url)
                                    <div class="mt-auto flex items-center gap-4 pt-5 text-sm font-semibold">
                                        @if ($project->live_url)
                                            <a href="{{ $project->live_url }}" target="_blank" rel="noopener" class="text-indigo-600 hover:text-indigo-500">
                                                <i class="fas fa-arrow-up-right-from-square mr-1"></i> Live demo
                                            </a>
                                        @endif
                                        @if ($project->repo_url)
                                            <a href="{{ $project->repo_url }}" target="_blank" rel="noopener" class="text-slate-600 hover:text-slate-900">
                                                <i class="fab fa-github mr-1"></i> Code
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Experience -->
    @if ($experiences->isNotEmpty())
        <section id="experience" class="py-20">
            <div class="mx-auto max-w-5xl px-4 sm:px-6">
                <p class="section-eyebrow">Career</p>
                <h2 class="section-title mt-2">Experience</h2>

                <ol class="mt-8 space-y-6 border-l border-slate-200 pl-6">
                    @foreach ($experiences as $experience)
                        <li class="relative">
                            <span class="absolute -left-[1.94rem] top-1.5 flex h-3 w-3 rounded-full border-2 border-white bg-indigo-500 ring-1 ring-indigo-200"></span>
                            <div class="flex flex-wrap items-baseline justify-between gap-2">
                                <h3 class="text-base font-bold text-slate-900">{{ $experience->job_title }}</h3>
                                <span class="text-xs font-semibold text-slate-400">{{ $experience->date_range }}</span>
                            </div>
                            <p class="text-sm font-medium text-indigo-600">
                                @if ($experience->company_url)
                                    <a href="{{ $experience->company_url }}" target="_blank" rel="noopener" class="hover:underline">{{ $experience->company }}</a>
                                @else
                                    {{ $experience->company }}
                                @endif
                                @if ($experience->location)
                                    <span class="font-normal text-slate-400">&middot; {{ $experience->location }}</span>
                                @endif
                            </p>
                            @if ($experience->description)
                                <ul class="mt-2 space-y-1.5 text-sm leading-relaxed text-slate-600">
                                    @foreach (preg_split('/\r?\n/', trim($experience->description)) as $line)
                                        @if (trim($line) !== '')
                                            <li class="flex gap-2">
                                                <span class="text-indigo-400">&bull;</span>
                                                <span>{{ preg_match('/^[•\-\*]\s*/', trim($line)) ? preg_replace('/^[•\-\*]\s*/', '', trim($line)) : trim($line) }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>
    @endif

    <!-- Education -->
    @if ($educations->isNotEmpty())
        <section id="education" class="border-t border-slate-200 bg-white py-20">
            <div class="mx-auto max-w-5xl px-4 sm:px-6">
                <p class="section-eyebrow">Academic</p>
                <h2 class="section-title mt-2">Education</h2>

                <div class="mt-8 grid gap-6 sm:grid-cols-2">
                    @foreach ($educations as $education)
                        <div class="card-shell p-6">
                            <div class="flex items-start gap-4">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                    <i class="fas fa-graduation-cap"></i>
                                </span>
                                <div>
                                    <h3 class="text-base font-bold text-slate-900">{{ $education->degree }}</h3>
                                    <p class="text-sm font-medium text-indigo-600">
                                        @if ($education->institution_url)
                                            <a href="{{ $education->institution_url }}" target="_blank" rel="noopener" class="hover:underline">{{ $education->institution }}</a>
                                        @else
                                            {{ $education->institution }}
                                        @endif
                                    </p>
                                    <p class="mt-0.5 text-xs font-semibold text-slate-400">
                                        {{ $education->year_range }}@if ($education->location) &middot; {{ $education->location }}@endif
                                    </p>
                                    @if ($education->description)
                                        <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $education->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Contact -->
    <section id="contact" class="py-20">
        <div class="mx-auto max-w-3xl px-4 text-center sm:px-6">
            <p class="section-eyebrow">Contact</p>
            <h2 class="section-title mt-2">Let's work together</h2>
            @if ($profile?->bio)
                <p class="mt-4 text-slate-600">I'm always open to new projects and interesting conversations.</p>
            @endif

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                @if ($profile?->email)
                    <a href="mailto:{{ $profile->email }}" class="btn-primary">
                        <i class="fas fa-envelope"></i> {{ $profile->email }}
                    </a>
                @endif
                @foreach ($socials as $network => $url)
                    <a href="{{ $url }}" target="_blank" rel="noopener" class="btn-secondary">
                        <i class="{{ $socialIcons[$network] ?? 'fas fa-link' }}"></i> {{ ucfirst($network) }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto flex max-w-5xl flex-col items-center justify-between gap-3 px-4 py-8 text-sm text-slate-500 sm:flex-row sm:px-6">
            <p>&copy; {{ date('Y') }} {{ $name }}. All rights reserved.</p>
            <p>Built with Laravel</p>
        </div>
    </footer>
@endsection
