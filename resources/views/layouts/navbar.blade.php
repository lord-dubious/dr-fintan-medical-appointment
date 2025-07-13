<!-- Fintan-style Navbar -->
<nav class="bg-white dark:bg-gray-800 py-3 shadow-md sticky top-0 z-50 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">F</div>
            <span class="font-bold text-2xl text-blue-600 dark:text-blue-400">Dr. Fintan</span>
        </a>

        <!-- Navigation Links - Desktop -->
        <div class="hidden lg:flex items-center space-x-8">
            <a href="{{ route('home') }}"
               class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 font-medium transition-colors px-3 py-2 rounded-md hover:bg-blue-50 dark:hover:bg-gray-700 {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-gray-700' : '' }}">
                Home
            </a>
            <a href="/about"
               class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 font-medium transition-colors px-3 py-2 rounded-md hover:bg-blue-50 dark:hover:bg-gray-700 {{ request()->is('about') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-gray-700' : '' }}">
                About
            </a>
            <a href="/contact"
               class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 font-medium transition-colors px-3 py-2 rounded-md hover:bg-blue-50 dark:hover:bg-gray-700 {{ request()->is('contact') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-gray-700' : '' }}">
                Contact
            </a>
        </div>

        <!-- Auth & Action Buttons - Desktop -->
        <div class="hidden lg:flex items-center space-x-4">
            <!-- Theme Toggle Placeholder -->
            <button class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" onclick="toggleTheme()">
                <i class="fas fa-moon text-gray-600 dark:text-gray-300"></i>
            </button>

            <!-- Auth Buttons -->
            @if($isAuthenticated)
                <!-- Authenticated User Menu -->
                <div class="flex items-center space-x-3 border-r border-gray-200 dark:border-gray-700 pr-4">
                    <div class="relative group">
                        <button class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-700 font-medium rounded-md transition-all duration-200">
                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-sm mr-2">
                                {{ strtoupper(substr($currentUser->email, 0, 1)) }}
                            </div>
                            <span class="hidden md:inline">{{ $currentUser->email }}</span>
                            <i class="fas fa-chevron-down ml-2 text-xs"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="py-2">
                                @if($currentUser->role === 'patient')
                                    <a href="{{ route('patient.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                    </a>
                                @elseif($currentUser->role === 'doctor')
                                    <a href="{{ route('doctor.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                    </a>
                                @elseif($currentUser->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                    </a>
                                @endif
                                <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Guest User Buttons -->
                <div class="flex items-center space-x-3 border-r border-gray-200 dark:border-gray-700 pr-4">
                    <a href="{{ route('login') }}"
                       class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-gray-700 font-medium rounded-md transition-all duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="flex items-center px-4 py-2 border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white dark:border-blue-400 dark:text-blue-400 dark:hover:bg-blue-400 dark:hover:text-white font-medium rounded-md transition-all duration-200">
                        <i class="fas fa-user-plus mr-2"></i>
                        Sign Up
                    </a>
                </div>
            @endif

            <!-- CTA Button -->
            <a href="{{ route('appointment') }}"
               class="flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white dark:bg-blue-500 dark:hover:bg-blue-600 font-semibold rounded-md shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-calendar mr-2"></i>
                Book Consultation
            </a>
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="lg:hidden flex items-center gap-3">
            <!-- Theme Toggle for Mobile -->
            <button class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" onclick="toggleTheme()">
                <i class="fas fa-moon text-gray-600 dark:text-gray-300"></i>
            </button>
            <button onclick="toggleMobileMenu()"
                    class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <i id="mobile-menu-icon" class="fas fa-bars text-gray-600 dark:text-gray-300"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden bg-white dark:bg-gray-800 w-full py-6 px-6 shadow-lg hidden border-t border-gray-200 dark:border-gray-700">
        <div class="flex flex-col space-y-4">
            <a href="{{ route('home') }}"
               class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 font-medium py-3 px-4 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition-all">
                Home
            </a>
            <a href="/about"
               class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 font-medium py-3 px-4 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition-all">
                About
            </a>
            <a href="/contact"
               class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 font-medium py-3 px-4 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 transition-all">
                Contact
            </a>

            <div class="border-t dark:border-gray-700 my-4"></div>

            @if($isAuthenticated)
                <!-- Authenticated Mobile Menu -->
                <div class="flex flex-col space-y-3">
                    <div class="text-center py-3 px-4 bg-blue-50 dark:bg-gray-700 rounded-md">
                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-lg mx-auto mb-2">
                            {{ strtoupper(substr($currentUser->email, 0, 1)) }}
                        </div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $currentUser->email }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">{{ $currentUser->role }}</p>
                    </div>

                    @if($currentUser->role === 'patient')
                        <a href="{{ route('patient.dashboard') }}" class="w-full flex items-center justify-center py-3 px-4 border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white rounded-md font-medium transition-all duration-200">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @elseif($currentUser->role === 'doctor')
                        <a href="{{ route('doctor.dashboard') }}" class="w-full flex items-center justify-center py-3 px-4 border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white rounded-md font-medium transition-all duration-200">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @elseif($currentUser->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center justify-center py-3 px-4 border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white rounded-md font-medium transition-all duration-200">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @endif

                    <a href="{{ route('appointment') }}"
                       class="w-full flex items-center justify-center py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold transition-all duration-200">
                        <i class="fas fa-calendar mr-2"></i>
                        Book Consultation
                    </a>

                    <a href="{{ route('logout') }}"
                       class="w-full flex items-center justify-center py-3 px-4 border-2 border-red-600 text-red-600 hover:bg-red-600 hover:text-white dark:border-red-400 dark:text-red-400 dark:hover:bg-red-400 dark:hover:text-white rounded-md font-medium transition-all duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </a>
                </div>
            @else
                <!-- Guest Mobile Menu -->
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('login') }}"
                       class="w-full flex items-center justify-center py-3 px-4 border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white dark:border-blue-400 dark:text-blue-400 dark:hover:bg-blue-400 dark:hover:text-white rounded-md font-medium transition-all duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="w-full flex items-center justify-center py-3 px-4 border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white dark:border-indigo-400 dark:text-indigo-400 dark:hover:bg-indigo-400 dark:hover:text-white rounded-md font-medium transition-all duration-200">
                        <i class="fas fa-user-plus mr-2"></i>
                        Sign Up
                    </a>
                    <a href="{{ route('appointment') }}"
                       class="w-full flex items-center justify-center py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white dark:bg-blue-500 dark:hover:bg-blue-600 rounded-md font-semibold transition-all duration-200">
                        <i class="fas fa-calendar mr-2"></i>
                        Book Consultation
                    </a>
                </div>
            @endif
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const icon = document.getElementById('mobile-menu-icon');

    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
    } else {
        menu.classList.add('hidden');
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
    }
}

function toggleTheme() {
    const html = document.documentElement;
    if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    }
}

// Initialize theme
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    }
});
</script>