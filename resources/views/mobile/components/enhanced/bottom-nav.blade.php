{{-- Enhanced Bottom Navigation with Professional UI Components --}}
<nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-gray-200 dark:bg-gray-800/95 dark:border-gray-700 bottom-nav-safe">
    <div class="flex items-center justify-around px-2 py-2">
        @guest
            <!-- Guest Navigation -->
            <x-mobile.components.ui.button 
                href="{{ route('mobile.home') }}" 
                variant="ghost" 
                size="sm"
                class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.home') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                <i class="fas fa-home text-lg mb-1"></i>
                <span class="text-xs font-medium">Home</span>
            </x-mobile.components.ui.button>
            
            <x-mobile.components.ui.button 
                href="{{ route('mobile.about') }}" 
                variant="ghost" 
                size="sm"
                class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.about') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                <i class="fas fa-user-md text-lg mb-1"></i>
                <span class="text-xs font-medium">About</span>
            </x-mobile.components.ui.button>
            
            <x-mobile.components.ui.button 
                href="{{ route('mobile.auth.appointment') }}" 
                variant="primary" 
                size="sm"
                class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors">
                <i class="fas fa-calendar-plus text-lg mb-1"></i>
                <span class="text-xs font-medium">Book</span>
            </x-mobile.components.ui.button>
            
            <x-mobile.components.ui.button 
                href="{{ route('mobile.contact') }}" 
                variant="ghost" 
                size="sm"
                class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.contact') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                <i class="fas fa-envelope text-lg mb-1"></i>
                <span class="text-xs font-medium">Contact</span>
            </x-mobile.components.ui.button>
            
            <x-mobile.components.ui.button 
                href="{{ route('mobile.auth.login') }}" 
                variant="ghost" 
                size="sm"
                class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.auth.login') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                <i class="fas fa-sign-in-alt text-lg mb-1"></i>
                <span class="text-xs font-medium">Login</span>
            </x-mobile.components.ui.button>
        @endguest
        
        @auth
            @if(Auth::user()->role === 'admin')
                <!-- Admin Navigation -->
                <x-mobile.components.ui.button 
                    href="{{ route('mobile.admin.dashboard') }}" 
                    variant="ghost" 
                    size="sm"
                    class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.admin.dashboard') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                    <i class="fas fa-tachometer-alt text-lg mb-1"></i>
                    <span class="text-xs font-medium">Dashboard</span>
                </x-mobile.components.ui.button>
                
                <x-mobile.components.ui.button 
                    href="{{ route('mobile.admin.appointments') }}" 
                    variant="ghost" 
                    size="sm"
                    class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.admin.appointments') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                    <i class="fas fa-calendar-check text-lg mb-1"></i>
                    <span class="text-xs font-medium">Appointments</span>
                </x-mobile.components.ui.button>
                
                <x-mobile.components.ui.button 
                    href="{{ route('mobile.admin.doctors') }}" 
                    variant="ghost" 
                    size="sm"
                    class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.admin.doctors') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                    <i class="fas fa-user-md text-lg mb-1"></i>
                    <span class="text-xs font-medium">Doctors</span>
                </x-mobile.components.ui.button>
                
                <x-mobile.components.ui.button 
                    href="{{ route('mobile.admin.patients') }}" 
                    variant="ghost" 
                    size="sm"
                    class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.admin.patients') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                    <i class="fas fa-users text-lg mb-1"></i>
                    <span class="text-xs font-medium">Patients</span>
                </x-mobile.components.ui.button>
                
            @elseif(Auth::user()->role === 'doctor')
                <!-- Doctor Navigation -->
                <x-mobile.components.ui.button 
                    href="{{ route('mobile.doctor.dashboard') }}" 
                    variant="ghost" 
                    size="sm"
                    class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.doctor.dashboard') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                    <i class="fas fa-tachometer-alt text-lg mb-1"></i>
                    <span class="text-xs font-medium">Dashboard</span>
                </x-mobile.components.ui.button>
                
                <x-mobile.components.ui.button 
                    href="{{ route('mobile.doctor.appointments') }}" 
                    variant="ghost" 
                    size="sm"
                    class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.doctor.appointments') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                    <i class="fas fa-calendar-check text-lg mb-1"></i>
                    <span class="text-xs font-medium">Appointments</span>
                </x-mobile.components.ui.button>
                
                <x-mobile.components.ui.button 
                    href="{{ route('mobile.doctor.profile') }}" 
                    variant="ghost" 
                    size="sm"
                    class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.doctor.profile') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                    <i class="fas fa-user-md text-lg mb-1"></i>
                    <span class="text-xs font-medium">Profile</span>
                </x-mobile.components.ui.button>
                
            @elseif(Auth::user()->role === 'patient')
                <!-- Patient Navigation -->
                <x-mobile.components.ui.button 
                    href="{{ route('mobile.user.dashboard') }}" 
                    variant="ghost" 
                    size="sm"
                    class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.user.dashboard') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                    <i class="fas fa-tachometer-alt text-lg mb-1"></i>
                    <span class="text-xs font-medium">Dashboard</span>
                </x-mobile.components.ui.button>
                
                <x-mobile.components.ui.button 
                    href="{{ route('mobile.user.appointments') }}" 
                    variant="ghost" 
                    size="sm"
                    class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.user.appointments') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                    <i class="fas fa-calendar-check text-lg mb-1"></i>
                    <span class="text-xs font-medium">Appointments</span>
                </x-mobile.components.ui.button>
                
                <!-- Book Appointment - Highlighted -->
                <x-mobile.components.ui.button 
                    href="{{ route('mobile.user.book_appointment') }}" 
                    variant="primary" 
                    size="sm"
                    class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors">
                    <i class="fas fa-plus-circle text-lg mb-1"></i>
                    <span class="text-xs font-medium">Book</span>
                </x-mobile.components.ui.button>
                
                <x-mobile.components.ui.button 
                    href="{{ route('mobile.user.profile') }}" 
                    variant="ghost" 
                    size="sm"
                    class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('mobile.user.profile') ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-primary-600' }}">
                    <i class="fas fa-user text-lg mb-1"></i>
                    <span class="text-xs font-medium">Profile</span>
                </x-mobile.components.ui.button>
            @endif
        @endauth
    </div>
</nav>
