<!-- Navbar -->
<nav class="bg-indigo-600 lg:hidden">
    <div class="flex items-center justify-between px-4 py-2">
        <!-- Mobile menu button -->
        <button 
            @click="sidebarOpen = true"
            class="text-white focus:outline-none focus:ring-2 focus:ring-white"
        >
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        
        <!-- Logo -->
        <div class="flex-shrink-0">
            <h1 class="text-white text-lg font-bold">SalonPro</h1>
        </div>
        
        <!-- User menu for mobile -->
        <div class="relative" x-data="{ open: false }">
            <button 
                @click="open = !open"
                class="flex items-center text-sm text-white focus:outline-none"
            >
                <span class="sr-only">Open user menu</span>
                <div class="w-8 h-8 bg-indigo-400 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white"></i>
                </div>
            </button>
            
            <!-- Dropdown menu -->
            <div 
                x-show="open" 
                @click.away="open = false"
                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1"
            >
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-user mr-2"></i>Your Profile
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-cog mr-2"></i>Settings
                </a>
                <form method="POST" action="#">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>