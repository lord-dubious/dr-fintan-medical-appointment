<!-- Mobile Header -->
<header class="fixed top-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-200 header-safe">
    <div class="flex items-center justify-between px-4 py-3">
        <!-- Left Section: Menu/Back Button -->
        <div class="flex items-center">
            @if(isset($showBack) && $showBack)
                <button onclick="history.back()" class="touch-target p-2 -ml-2 text-gray-600 hover:text-mobile-primary transition-colors">
                    <i class="fas fa-arrow-left text-lg"></i>
                </button>
            @else
                <button x-data @click="$dispatch('toggle-sidebar')" class="touch-target p-2 -ml-2 text-gray-600 hover:text-mobile-primary transition-colors">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            @endif
        </div>
        
        <!-- Center Section: Logo/Title -->
        <div class="flex items-center flex-1 justify-center">
            @if(isset($pageTitle))
                <h1 class="text-lg font-semibold text-gray-900 truncate max-w-48">{{ $pageTitle }}</h1>
            @else
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-mobile-primary to-mobile-primary-dark flex items-center justify-center text-white font-bold text-sm">
                        F
                    </div>
                    <span class="font-bold text-lg text-mobile-primary">Dr. Fintan</span>
                </a>
            @endif
        </div>
        
        <!-- Right Section: Actions -->
        <div class="flex items-center gap-1">
            @auth
                <!-- Notifications -->
                <button class="touch-target p-2 text-gray-600 hover:text-mobile-primary transition-colors relative">
                    <i class="fas fa-bell text-lg"></i>
                    @if(isset($notificationCount) && $notificationCount > 0)
                        <span class="absolute -top-1 -right-1 h-5 w-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                            {{ $notificationCount > 9 ? '9+' : $notificationCount }}
                        </span>
                    @endif
                </button>
                
                <!-- Profile -->
                <button x-data @click="$dispatch('toggle-profile-menu')" class="touch-target p-1 ml-1">
                    @if(Auth::user()->role === 'patient' && isset($patient) && $patient->image)
                        <img src="{{ asset('storage/public/images/' . $patient->image) }}" 
                             alt="Profile" 
                             class="h-8 w-8 rounded-full object-cover border-2 border-mobile-primary">
                    @elseif(Auth::user()->role === 'doctor' && isset($doctor))
                        @php
                            $initials = strtoupper(substr($doctor->name, 0, 2));
                            $bgColor = '#' . substr(md5($doctor->name), 0, 6);
                        @endphp
                        <div class="h-8 w-8 rounded-full flex items-center justify-center text-white font-bold text-sm border-2 border-mobile-primary" 
                             style="background-color: {{ $bgColor }};">
                            {{ $initials }}
                        </div>
                    @else
                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center border-2 border-mobile-primary">
                            <i class="fas fa-user text-gray-600 text-sm"></i>
                        </div>
                    @endif
                </button>
            @else
                <!-- Login Button -->
                <a href="{{ route('login') }}" class="touch-target px-4 py-2 bg-mobile-primary text-white text-sm font-medium rounded-full">
                    Login
                </a>
            @endauth
        </div>
    </div>
    
    <!-- Profile Dropdown Menu -->
    @auth
    <div x-data="{ open: false }" 
         @toggle-profile-menu.window="open = !open"
         @click.away="open = false"
         x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute top-full right-4 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
         style="display: none;">
        
        <!-- User Info -->
        <div class="px-4 py-3 border-b border-gray-100">
            <p class="text-sm font-medium text-gray-900">
                {{ Auth::user()->role === 'patient' ? ($patient->name ?? Auth::user()->name) : ($doctor->name ?? Auth::user()->name) }}
            </p>
            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            <span class="inline-block mt-1 px-2 py-1 text-xs font-medium rounded-full
                {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                {{ Auth::user()->role === 'doctor' ? 'bg-blue-100 text-blue-800' : '' }}
                {{ Auth::user()->role === 'patient' ? 'bg-green-100 text-green-800' : '' }}">
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
        
        <!-- Menu Items -->
        <div class="py-1">
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-tachometer-alt w-5 text-gray-400 mr-3"></i>
                    Dashboard
                </a>
            @elseif(Auth::user()->role === 'doctor')
                <a href="{{ route('doctor.dashboard') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-tachometer-alt w-5 text-gray-400 mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('doctor.appointment') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-calendar-check w-5 text-gray-400 mr-3"></i>
                    Appointments
                </a>
            @elseif(Auth::user()->role === 'patient')
                <a href="{{ route('patient.dashboard') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-tachometer-alt w-5 text-gray-400 mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('patient.appointment') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-calendar-check w-5 text-gray-400 mr-3"></i>
                    My Appointments
                </a>
                <a href="{{ route('patient.book_appointment') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-plus-circle w-5 text-gray-400 mr-3"></i>
                    Book Appointment
                </a>
            @endif
            
            <div class="border-t border-gray-100 my-1"></div>
            
            <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-cog w-5 text-gray-400 mr-3"></i>
                Settings
            </a>
            
            <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-question-circle w-5 text-gray-400 mr-3"></i>
                Help & Support
            </a>
            
            <div class="border-t border-gray-100 my-1"></div>
            
            <form action="{{ route('logout') }}" method="POST" class="block">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                    <i class="fas fa-sign-out-alt w-5 text-red-400 mr-3"></i>
                    Sign Out
                </button>
            </form>
        </div>
    </div>
    @endauth
</header>

<!-- Header Spacer -->
<div class="h-16 header-safe"></div>
