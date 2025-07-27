<!-- Mobile Sidebar/Drawer -->
<div x-data="{ open: false }" 
     @toggle-sidebar.window="open = !open"
     @keydown.escape.window="open = false"
     class="relative z-50">
    
    <!-- Backdrop -->
    <div x-show="open" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false"
         class="fixed inset-0 bg-gray-600 bg-opacity-75"
         style="display: none;"></div>
    
    <!-- Sidebar -->
    <div x-show="open"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed top-0 left-0 z-50 h-full w-80 max-w-xs bg-white shadow-xl mobile-safe-area"
         style="display: none;">
        
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 header-safe">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-mobile-primary to-mobile-primary-dark flex items-center justify-center text-white font-bold">
                    F
                </div>
                <div>
                    <h2 class="font-bold text-lg text-gray-900">Dr. Fintan</h2>
                    <p class="text-sm text-gray-500">Medical Care</p>
                </div>
            </div>
            <button @click="open = false" class="touch-target p-2 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <!-- Sidebar Content -->
        <div class="flex-1 overflow-y-auto mobile-scroll">
            @auth
                <!-- User Info Section -->
                <div class="p-4 bg-gradient-to-r from-mobile-primary/5 to-mobile-primary-dark/5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        @if(Auth::user()->role === 'patient' && isset($patient) && $patient->image)
                            <img src="{{ asset('storage/public/images/' . $patient->image) }}" 
                                 alt="Profile" 
                                 class="h-12 w-12 rounded-full object-cover border-2 border-mobile-primary">
                        @elseif(Auth::user()->role === 'doctor' && isset($doctor))
                            @php
                                $initials = strtoupper(substr($doctor->name, 0, 2));
                                $bgColor = '#' . substr(md5($doctor->name), 0, 6);
                            @endphp
                            <div class="h-12 w-12 rounded-full flex items-center justify-center text-white font-bold border-2 border-mobile-primary" 
                                 style="background-color: {{ $bgColor }};">
                                {{ $initials }}
                            </div>
                        @else
                            <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center border-2 border-mobile-primary">
                                <i class="fas fa-user text-gray-600"></i>
                            </div>
                        @endif
                        
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate">
                                {{ Auth::user()->role === 'patient' ? ($patient->name ?? Auth::user()->name) : ($doctor->name ?? Auth::user()->name) }}
                            </p>
                            <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            <span class="inline-block mt-1 px-2 py-1 text-xs font-medium rounded-full
                                {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ Auth::user()->role === 'doctor' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ Auth::user()->role === 'patient' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endauth
            
            <!-- Navigation Menu -->
            <nav class="py-4">
                @guest
                    <!-- Guest Menu -->
                    <div class="px-4 mb-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Navigation</h3>
                        <div class="space-y-1">
                            <a href="{{ route('home') }}" 
                               class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors
                                      {{ request()->routeIs('home') ? 'bg-mobile-primary/10 text-mobile-primary' : '' }}">
                                <i class="fas fa-home w-5 mr-3"></i>
                                <span class="font-medium">Home</span>
                            </a>
                            
                            <a href="{{ route('about') }}" 
                               class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors
                                      {{ request()->routeIs('about') ? 'bg-mobile-primary/10 text-mobile-primary' : '' }}">
                                <i class="fas fa-user-md w-5 mr-3"></i>
                                <span class="font-medium">About Dr. Fintan</span>
                            </a>
                            
                            <a href="{{ route('appointment') }}" 
                               class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors
                                      {{ request()->routeIs('appointment') ? 'bg-mobile-primary/10 text-mobile-primary' : '' }}">
                                <i class="fas fa-calendar-plus w-5 mr-3"></i>
                                <span class="font-medium">Book Appointment</span>
                            </a>
                            
                            <a href="{{ route('contact') }}" 
                               class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors
                                      {{ request()->routeIs('contact') ? 'bg-mobile-primary/10 text-mobile-primary' : '' }}">
                                <i class="fas fa-envelope w-5 mr-3"></i>
                                <span class="font-medium">Contact Us</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 px-4 pt-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Account</h3>
                        <div class="space-y-1">
                            <a href="{{ route('login') }}" 
                               class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-sign-in-alt w-5 mr-3"></i>
                                <span class="font-medium">Sign In</span>
                            </a>
                            
                            <a href="{{ route('register') }}" 
                               class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user-plus w-5 mr-3"></i>
                                <span class="font-medium">Sign Up</span>
                            </a>
                        </div>
                    </div>
                @endguest
                
                @auth
                    @if(Auth::user()->role === 'admin')
                        <!-- Admin Menu -->
                        <div class="px-4 mb-4">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Admin Panel</h3>
                            <div class="space-y-1">
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors
                                          {{ request()->routeIs('admin.dashboard') ? 'bg-mobile-primary/10 text-mobile-primary' : '' }}">
                                    <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                                    <span class="font-medium">Dashboard</span>
                                </a>
                                
                                <a href="{{ route('admin.appointments.index') }}" 
                                   class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors
                                          {{ request()->routeIs('admin.appointments.*') ? 'bg-mobile-primary/10 text-mobile-primary' : '' }}">
                                    <i class="fas fa-calendar-check w-5 mr-3"></i>
                                    <span class="font-medium">Appointments</span>
                                </a>
                                
                                <a href="{{ route('admin.doctors.index') }}" 
                                   class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors
                                          {{ request()->routeIs('admin.doctors.*') ? 'bg-mobile-primary/10 text-mobile-primary' : '' }}">
                                    <i class="fas fa-user-md w-5 mr-3"></i>
                                    <span class="font-medium">Doctors</span>
                                </a>
                                
                                <a href="{{ route('admin.patients.index') }}" 
                                   class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors
                                          {{ request()->routeIs('admin.patients.*') ? 'bg-mobile-primary/10 text-mobile-primary' : '' }}">
                                    <i class="fas fa-users w-5 mr-3"></i>
                                    <span class="font-medium">Patients</span>
                                </a>
                            </div>
                        </div>
                        
                    @elseif(Auth::user()->role === 'doctor')
                        <!-- Doctor Menu -->
                        <div class="px-4 mb-4">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Doctor Portal</h3>
                            <div class="space-y-1">
                                <a href="{{ route('doctor.dashboard') }}" 
                                   class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors
                                          {{ request()->routeIs('doctor.dashboard') ? 'bg-mobile-primary/10 text-mobile-primary' : '' }}">
                                    <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                                    <span class="font-medium">Dashboard</span>
                                </a>
                                
                                <a href="{{ route('doctor.appointment') }}" 
                                   class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors
                                          {{ request()->routeIs('doctor.appointment') ? 'bg-mobile-primary/10 text-mobile-primary' : '' }}">
                                    <i class="fas fa-calendar-check w-5 mr-3"></i>
                                    <span class="font-medium">Appointments</span>
                                </a>
                                
                                <a href="#" 
                                   class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-video w-5 mr-3"></i>
                                    <span class="font-medium">Video Calls</span>
                                </a>
                                
                                <a href="#" 
                                   class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-user-md w-5 mr-3"></i>
                                    <span class="font-medium">My Profile</span>
                                </a>
                            </div>
                        </div>
                        
                    @elseif(Auth::user()->role === 'patient')
                        <!-- Patient Menu -->
                        <div class="px-4 mb-4">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Patient Portal</h3>
                            <div class="space-y-1">
                                <a href="{{ route('patient.dashboard') }}" 
                                   class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors
                                          {{ request()->routeIs('patient.dashboard') ? 'bg-mobile-primary/10 text-mobile-primary' : '' }}">
                                    <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                                    <span class="font-medium">Dashboard</span>
                                </a>
                                
                                <a href="{{ route('patient.appointment') }}" 
                                   class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors
                                          {{ request()->routeIs('patient.appointment') ? 'bg-mobile-primary/10 text-mobile-primary' : '' }}">
                                    <i class="fas fa-calendar-check w-5 mr-3"></i>
                                    <span class="font-medium">My Appointments</span>
                                </a>
                                
                                <a href="{{ route('patient.book_appointment') }}" 
                                   class="flex items-center px-3 py-3 text-mobile-primary bg-mobile-primary/10 rounded-lg hover:bg-mobile-primary/20 transition-colors
                                          {{ request()->routeIs('patient.book_appointment') ? 'bg-mobile-primary text-white' : '' }}">
                                    <i class="fas fa-plus-circle w-5 mr-3"></i>
                                    <span class="font-medium">Book Appointment</span>
                                </a>
                                
                                <a href="#" 
                                   class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-video w-5 mr-3"></i>
                                    <span class="font-medium">Video Calls</span>
                                </a>
                                
                                <a href="#" 
                                   class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-user w-5 mr-3"></i>
                                    <span class="font-medium">My Profile</span>
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Common Authenticated Menu -->
                    <div class="border-t border-gray-200 px-4 pt-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Support</h3>
                        <div class="space-y-1">
                            <a href="#" 
                               class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-cog w-5 mr-3"></i>
                                <span class="font-medium">Settings</span>
                            </a>
                            
                            <a href="#" 
                               class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-question-circle w-5 mr-3"></i>
                                <span class="font-medium">Help & Support</span>
                            </a>
                            
                            <a href="#" 
                               class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-shield-alt w-5 mr-3"></i>
                                <span class="font-medium">Privacy Policy</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Logout -->
                    <div class="border-t border-gray-200 px-4 pt-4 pb-4">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center w-full px-3 py-3 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                <span class="font-medium">Sign Out</span>
                            </button>
                        </form>
                    </div>
                @endauth
            </nav>
        </div>
        
        <!-- Sidebar Footer -->
        <div class="border-t border-gray-200 p-4">
            <div class="text-center">
                <p class="text-xs text-gray-500">Dr. Fintan Medical Care</p>
                <p class="text-xs text-gray-400">Version 1.0.0</p>
            </div>
        </div>
    </div>
</div>
