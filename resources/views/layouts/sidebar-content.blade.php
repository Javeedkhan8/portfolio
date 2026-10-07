<!-- Logo -->
<div class="flex flex-shrink-0 items-center px-4">
    <h1 class="text-white text-xl font-bold">SalonPro</h1>
</div>

<!-- Navigation -->
<nav class="mt-8 flex-1 space-y-2 px-2">
    @php
        $navItems = [
            ['route' => 'dashboard', 'icon' => 'fas fa-home', 'label' => 'Dashboard'],
            ['route' => 'appointments.index', 'icon' => 'fas fa-calendar-alt', 'label' => 'Appointments'],
            ['route' => 'clients.index', 'icon' => 'fas fa-users', 'label' => 'Clients'],
            ['route' => 'staff.index', 'icon' => 'fas fa-user-tie', 'label' => 'Staff'],
            ['route' => 'services.index', 'icon' => 'fas fa-cut', 'label' => 'Services'],
            ['route' => 'inventory.index', 'icon' => 'fas fa-boxes', 'label' => 'Inventory'],
            ['route' => 'reports.index', 'icon' => 'fas fa-chart-bar', 'label' => 'Reports'],
            ['route' => 'settings', 'icon' => 'fas fa-cog', 'label' => 'Settings'],
        ];
    @endphp

    @foreach($navItems as $item)
        <a 
            href="#" 
            class="group flex items-center rounded-md px-2 py-2 text-sm font-medium 
                   {{ request()->routeIs($item['route'].'*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-600' }}"
        >
            <i class="{{ $item['icon'] }} mr-3 h-6 w-6 flex-shrink-0"></i>
            {{ $item['label'] }}
        </a>
    @endforeach
</nav>

<!-- User section -->
<div class="flex flex-shrink-0 border-t border-indigo-800 p-4">
    <div class="group block w-full flex-shrink-0">
        <div class="flex items-center">
            <div>
                <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white"></i>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'User' }}</p>
                <a 
                    href="#" 
                    class="text-xs font-medium text-indigo-200 group-hover:text-white"
                >
                    View profile
                </a>
            </div>
        </div>
    </div>
</div>