<!-- Sidebar for mobile -->
<div 
    x-show="sidebarOpen" 
    class="relative z-40 lg:hidden"
    role="dialog"
    aria-modal="true"
>
    <div 
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-600 bg-opacity-75"
    ></div>

    <div class="fixed inset-0 z-40 flex">
        <div 
            x-show="sidebarOpen"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="relative flex w-full max-w-xs flex-1 flex-col bg-indigo-700"
        >
            <!-- Close button -->
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button 
                    @click="sidebarOpen = false"
                    class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-white"
                >
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Sidebar content -->
            <div class="h-0 flex-1 overflow-y-auto pt-5 pb-4">
                @include('layouts.sidebar-content')
            </div>
        </div>
    </div>
</div>

<!-- Static sidebar for desktop -->
<div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
    <div class="flex flex-grow flex-col overflow-y-auto bg-indigo-700 pt-5">
        @include('layouts.sidebar-content')
    </div>
</div>