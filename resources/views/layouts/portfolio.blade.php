<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portfolio')</title>
    <meta name="description" content="@yield('meta_description', 'Personal portfolio')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
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
            .section-title {
                @apply text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900;
            }
            .section-eyebrow {
                @apply text-xs font-bold uppercase tracking-[0.2em] text-indigo-600;
            }
            .btn-primary {
                @apply inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2;
            }
            .btn-secondary {
                @apply inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2;
            }
            .card-shell {
                @apply rounded-2xl border border-slate-200 bg-white shadow-sm;
            }
            .field-label {
                @apply block text-sm font-semibold text-slate-700;
            }
            .field-input {
                @apply mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm;
            }
            .field-error {
                @apply mt-1 text-sm text-rose-600;
            }
        }
    </style>
</head>
<body class="h-full bg-slate-50 font-sans text-slate-800 antialiased">
    @yield('body')

    @stack('scripts')
</body>
</html>
