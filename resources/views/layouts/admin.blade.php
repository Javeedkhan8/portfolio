<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Control Panel') &middot; Portfolio Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Figtree', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                },
            },
        };
    </script>
    <style type="text/tailwindcss">
        @layer components {
            .field-label {
                @apply block text-sm font-semibold text-slate-700;
            }
            .field-input {
                @apply mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm;
            }
            .field-hint {
                @apply mt-1 text-xs text-slate-500;
            }
            .field-error {
                @apply mt-1 text-sm text-rose-600;
            }
            .panel {
                @apply rounded-xl border border-slate-200 bg-white shadow-sm;
            }
            .btn-primary {
                @apply inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50;
            }
            .btn-secondary {
                @apply inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2;
            }
            .btn-danger {
                @apply inline-flex items-center gap-2 rounded-lg border border-rose-200 bg-white px-3 py-1.5 text-sm font-semibold text-rose-600 shadow-sm transition hover:bg-rose-50 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2;
            }
            .side-link {
                @apply flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900;
            }
            .side-link-active {
                @apply bg-indigo-50 text-indigo-700 hover:bg-indigo-50 hover:text-indigo-700;
            }
            .table-head {
                @apply px-4 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500;
            }
            .table-cell {
                @apply px-4 py-3 align-middle text-sm text-slate-700;
            }
        }
    </style>
</head>
<body class="h-full" x-data="{ sidebarOpen: false, userMenuOpen: false }">
<div class="min-h-full">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col border-r border-slate-200 bg-white lg:flex">
        <div class="flex h-16 shrink-0 items-center gap-2 border-b border-slate-200 px-6">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600 text-white">
                <i class="fas fa-briefcase"></i>
            </span>
            <div>
                <p class="text-sm font-bold leading-tight text-slate-900">Portfolio</p>
                <p class="text-xs text-slate-500">Control Panel</p>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
            <p class="px-3 pb-1 text-[0.65rem] font-bold uppercase tracking-wider text-slate-400">Overview</p>
            <a href="{{ route('admin.dashboard') }}" class="side-link {{ request()->routeIs('admin.dashboard') ? 'side-link-active' : '' }}">
                <i class="fas fa-gauge w-5 text-center text-slate-400"></i> Dashboard
            </a>

            <p class="px-3 pb-1 pt-5 text-[0.65rem] font-bold uppercase tracking-wider text-slate-400">Content</p>
            <a href="{{ route('admin.profile.edit') }}" class="side-link {{ request()->routeIs('admin.profile.*') ? 'side-link-active' : '' }}">
                <i class="fas fa-user w-5 text-center text-slate-400"></i> Profile &amp; About
            </a>
            <a href="{{ route('admin.projects.index') }}" class="side-link {{ request()->routeIs('admin.projects.*') ? 'side-link-active' : '' }}">
                <i class="fas fa-layer-group w-5 text-center text-slate-400"></i> Projects
            </a>
            <a href="{{ route('admin.skills.index') }}" class="side-link {{ request()->routeIs('admin.skills.*') ? 'side-link-active' : '' }}">
                <i class="fas fa-bolt w-5 text-center text-slate-400"></i> Skills
            </a>
            <a href="{{ route('admin.experiences.index') }}" class="side-link {{ request()->routeIs('admin.experiences.*') ? 'side-link-active' : '' }}">
                <i class="fas fa-briefcase w-5 text-center text-slate-400"></i> Experience
            </a>
            <a href="{{ route('admin.educations.index') }}" class="side-link {{ request()->routeIs('admin.educations.*') ? 'side-link-active' : '' }}">
                <i class="fas fa-graduation-cap w-5 text-center text-slate-400"></i> Education
            </a>

            <p class="px-3 pb-1 pt-5 text-[0.65rem] font-bold uppercase tracking-wider text-slate-400">Shortcuts</p>
            <a href="{{ route('portfolio.index') }}" target="_blank" rel="noopener" class="side-link">
                <i class="fas fa-external-link-alt w-5 text-center text-slate-400"></i> View live site
            </a>
            <a href="{{ route('profile.edit') }}" class="side-link">
                <i class="fas fa-id-card w-5 text-center text-slate-400"></i> My account
            </a>
        </nav>

        <div class="border-t border-slate-200 p-3">
            <a href="{{ route('portfolio.index') }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-xs font-bold text-slate-600">
                    {{ Str::of(auth()->user()->name ?? 'A')->substr(0, 1)->upper() }}
                </span>
                <span class="truncate">{{ auth()->user()->name }}</span>
            </a>
        </div>
    </aside>

    <!-- Mobile sidebar -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-40 lg:hidden" role="dialog" aria-modal="true">
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/50" @click="sidebarOpen = false"></div>
        <div class="fixed inset-0 flex">
            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 class="flex w-full max-w-xs flex-1 flex-col bg-white">
                <div class="flex h-16 items-center justify-between border-b border-slate-200 px-4">
                    <span class="text-sm font-bold text-slate-900">Portfolio Admin</span>
                    <button @click="sidebarOpen = false" class="text-slate-500 hover:text-slate-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
                    <a href="{{ route('admin.dashboard') }}" class="side-link {{ request()->routeIs('admin.dashboard') ? 'side-link-active' : '' }}"><i class="fas fa-gauge w-5 text-center"></i> Dashboard</a>
                    <a href="{{ route('admin.profile.edit') }}" class="side-link {{ request()->routeIs('admin.profile.*') ? 'side-link-active' : '' }}"><i class="fas fa-user w-5 text-center"></i> Profile &amp; About</a>
                    <a href="{{ route('admin.projects.index') }}" class="side-link {{ request()->routeIs('admin.projects.*') ? 'side-link-active' : '' }}"><i class="fas fa-layer-group w-5 text-center"></i> Projects</a>
                    <a href="{{ route('admin.skills.index') }}" class="side-link {{ request()->routeIs('admin.skills.*') ? 'side-link-active' : '' }}"><i class="fas fa-bolt w-5 text-center"></i> Skills</a>
                    <a href="{{ route('admin.experiences.index') }}" class="side-link {{ request()->routeIs('admin.experiences.*') ? 'side-link-active' : '' }}"><i class="fas fa-briefcase w-5 text-center"></i> Experience</a>
                    <a href="{{ route('admin.educations.index') }}" class="side-link {{ request()->routeIs('admin.educations.*') ? 'side-link-active' : '' }}"><i class="fas fa-graduation-cap w-5 text-center"></i> Education</a>
                    <a href="{{ route('portfolio.index') }}" target="_blank" rel="noopener" class="side-link"><i class="fas fa-external-link-alt w-5 text-center"></i> View live site</a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="flex min-h-full flex-col lg:pl-64">
        <header class="sticky top-0 z-20 flex h-16 shrink-0 items-center justify-between gap-4 border-b border-slate-200 bg-white px-4 sm:px-6">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="text-slate-500 hover:text-slate-700 lg:hidden">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <div>
                    <h1 class="text-base font-bold leading-tight text-slate-900">@yield('heading', 'Dashboard')</h1>
                    @hasSection('subheading')
                        <p class="text-xs text-slate-500">@yield('subheading')</p>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3">
                @yield('header-actions')

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 rounded-lg px-2 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-100">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-xs font-bold text-white">
                            {{ Str::of(auth()->user()->name ?? 'A')->substr(0, 1)->upper() }}
                        </span>
                        <span class="hidden sm:inline">{{ Str::before(auth()->user()->name ?? 'Account', ' ') }}</span>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                         class="absolute right-0 mt-2 w-52 origin-top-right rounded-lg border border-slate-200 bg-white py-1 shadow-lg">
                        <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                            Portfolio profile
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                            Account settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-rose-600 hover:bg-rose-50">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
            @include('admin.partials.flash')

            @yield('content')
        </main>

        <footer class="border-t border-slate-200 px-4 py-4 text-center text-xs text-slate-400 sm:px-6 lg:px-8">
            Portfolio Control Panel &middot; Changes publish instantly to
            <a href="{{ route('portfolio.index') }}" target="_blank" rel="noopener" class="font-semibold text-indigo-600 hover:underline">the live site</a>.
        </footer>
    </div>
</div>

@stack('scripts')
</body>
</html>
