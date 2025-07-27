<!-- Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-gray-200 bottom-nav-safe">
    <div class="flex items-center justify-around px-2 py-2">
        @guest
            <!-- Guest Navigation -->
            <a href="{{ route('mobile.home') }}" 
               class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                      {{ request()->routeIs('mobile.home') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                <i class="fas fa-home text-lg mb-1"></i>
                <span class="text-xs font-medium">Home</span>
            </a>
            
            <a href="{{ route('mobile.about') }}" 
               class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                      {{ request()->routeIs('mobile.about') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                <i class="fas fa-user-md text-lg mb-1"></i>
                <span class="text-xs font-medium">About</span>
            </a>
            
            <a href="{{ route('mobile.auth.appointment') }}" 
               class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                      {{ request()->routeIs('mobile.auth.appointment') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                <i class="fas fa-calendar-plus text-lg mb-1"></i>
                <span class="text-xs font-medium">Book</span>
            </a>
            
            <a href="{{ route('mobile.contact') }}" 
               class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                      {{ request()->routeIs('mobile.contact') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                <i class="fas fa-envelope text-lg mb-1"></i>
                <span class="text-xs font-medium">Contact</span>
            </a>
            
            <a href="{{ route('mobile.auth.login') }}" 
               class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                      {{ request()->routeIs('mobile.auth.login') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                <i class="fas fa-sign-in-alt text-lg mb-1"></i>
                <span class="text-xs font-medium">Login</span>
            </a>
        @endguest
        
        @auth
            @if(Auth::user()->role === 'admin')
                <!-- Admin Navigation -->
                <a href="{{ route('mobile.admin.dashboard') }}" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                          {{ request()->routeIs('mobile.admin.dashboard') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                    <i class="fas fa-tachometer-alt text-lg mb-1"></i>
                    <span class="text-xs font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('mobile.admin.appointments') }}" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                          {{ request()->routeIs('mobile.admin.appointments') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                    <i class="fas fa-calendar-check text-lg mb-1"></i>
                    <span class="text-xs font-medium">Appointments</span>
                </a>
                
                <a href="{{ route('mobile.admin.doctors') }}" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                          {{ request()->routeIs('mobile.admin.doctors') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                    <i class="fas fa-user-md text-lg mb-1"></i>
                    <span class="text-xs font-medium">Doctors</span>
                </a>
                
                <a href="{{ route('mobile.admin.patients') }}" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                          {{ request()->routeIs('mobile.admin.patients') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                    <i class="fas fa-users text-lg mb-1"></i>
                    <span class="text-xs font-medium">Patients</span>
                </a>
                
            @elseif(Auth::user()->role === 'doctor')
                <!-- Doctor Navigation -->
                <a href="{{ route('mobile.doctor.dashboard') }}" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                          {{ request()->routeIs('mobile.doctor.dashboard') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                    <i class="fas fa-tachometer-alt text-lg mb-1"></i>
                    <span class="text-xs font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('mobile.doctor.appointments') }}" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                          {{ request()->routeIs('mobile.doctor.appointments') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                    <i class="fas fa-calendar-check text-lg mb-1"></i>
                    <span class="text-xs font-medium">Appointments</span>
                </a>
                
                <a href="#" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors text-gray-600 hover:text-mobile-primary">
                    <i class="fas fa-video text-lg mb-1"></i>
                    <span class="text-xs font-medium">Calls</span>
                </a>
                
                <a href="{{ route('mobile.doctor.profile') }}" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                          {{ request()->routeIs('mobile.doctor.profile') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                    <i class="fas fa-user-md text-lg mb-1"></i>
                    <span class="text-xs font-medium">Profile</span>
                </a>
                
            @elseif(Auth::user()->role === 'patient')
                <!-- Patient Navigation -->
                <a href="{{ route('mobile.user.dashboard') }}" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                          {{ request()->routeIs('mobile.user.dashboard') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                    <i class="fas fa-tachometer-alt text-lg mb-1"></i>
                    <span class="text-xs font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('mobile.user.appointments') }}" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                          {{ request()->routeIs('mobile.user.appointments') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                    <i class="fas fa-calendar-check text-lg mb-1"></i>
                    <span class="text-xs font-medium">Appointments</span>
                </a>
                
                <!-- Book Appointment - Highlighted -->
                <a href="{{ route('mobile.user.book_appointment') }}" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                          {{ request()->routeIs('mobile.user.book_appointment') ? 'text-white bg-mobile-primary' : 'text-mobile-primary bg-mobile-primary/10 hover:bg-mobile-primary hover:text-white' }}">
                    <i class="fas fa-plus-circle text-lg mb-1"></i>
                    <span class="text-xs font-medium">Book</span>
                </a>
                
                <a href="#" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors text-gray-600 hover:text-mobile-primary">
                    <i class="fas fa-video text-lg mb-1"></i>
                    <span class="text-xs font-medium">Calls</span>
                </a>
                
                <a href="{{ route('mobile.user.profile') }}" 
                   class="flex flex-col items-center justify-center touch-target px-3 py-2 rounded-lg transition-colors
                          {{ request()->routeIs('mobile.user.profile') ? 'text-mobile-primary bg-mobile-primary/10' : 'text-gray-600 hover:text-mobile-primary' }}">
                    <i class="fas fa-user text-lg mb-1"></i>
                    <span class="text-xs font-medium">Profile</span>
                </a>
            @endif
        @endauth
    </div>
</nav>
