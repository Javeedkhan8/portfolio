<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Salon Management')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="h-full" x-data="{ sidebarOpen: false, userMenuOpen: false }">
    <div class="min-h-full">
        <!-- Navigation -->
        @include('layouts.navbar')
        
        <!-- Sidebar -->
        @include('layouts.sidebar')
        
        <!-- Main Content -->
        <div class="lg:pl-64 flex flex-col flex-1">
            <main class="flex-1 pb-8">
                <!-- Page Header -->
                <div class="bg-white shadow">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="py-6 md:flex md:items-center md:justify-between">
                            <div class="min-w-0 flex-1">
                                <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                                    @yield('page-title', 'Dashboard')
                                </h1>
                                @hasSection('page-description')
                                <p class="mt-1 text-sm text-gray-500">
                                    @yield('page-description')
                                </p>
                                @endif
                            </div>
                            <div class="mt-4 flex md:ml-4 md:mt-0">
                                @yield('header-actions')
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Page Content -->
                <div class="mt-8">
                    <div class="px-4 sm:px-6 lg:px-8">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>