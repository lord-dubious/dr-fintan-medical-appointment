@include('layouts.header')

@include('layouts.navbar')

<!-- Modern Booking Header -->
<section class="py-12 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-white/5 bg-[radial-gradient(circle_at_50%_50%,rgba(255,255,255,0.1)_1px,transparent_1px)] bg-[length:20px_20px]"></div>
    
    <div class="container mx-auto px-4 relative">
        <div class="text-center max-w-4xl mx-auto">
            <div class="mb-6">
                <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-full px-6 py-3 mb-4">
                    <i class="fas fa-calendar-check text-white text-xl"></i>
                    <span class="text-white font-medium">Book Consultation</span>
                </div>
            </div>
            
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Schedule Your 
                <span class="bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">
                    Consultation
                </span>
            </h1>
            
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                Choose the perfect time that works for you with our intelligent scheduling system. 
                Experience personalized healthcare from the comfort of your home.
            </p>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl font-bold text-white mb-2">15min</div>
                    <div class="text-blue-100 text-sm">Average Booking Time</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl font-bold text-white mb-2">24/7</div>
                    <div class="text-blue-100 text-sm">Available Scheduling</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl font-bold text-white mb-2">98%</div>
                    <div class="text-blue-100 text-sm">Patient Satisfaction</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modern Multi-Step Booking -->
<section class="py-16 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-blue-900 min-h-screen">
    <div class="container mx-auto max-w-5xl px-4">
        <!-- Booking Progress -->
        <div class="mb-12">
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-xl border-0 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Booking Progress
                    </h2>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Step <span id="current-step">1</span> of 4
                    </span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Step 1: Doctor Selection -->
                    <div class="flex items-center">
                        <div class="step-indicator w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold" data-step="1">
                            1
                        </div>
                        <span class="ml-3 text-sm font-medium text-blue-600 dark:text-blue-400">Doctor</span>
                    </div>
                    
                    <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 rounded step-line" data-step="1"></div>
                    
                    <!-- Step 2: Date & Time -->
                    <div class="flex items-center">
                        <div class="step-indicator w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold" data-step="2">
                            2
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-500">Date & Time</span>
                    </div>
                    
                    <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 rounded step-line" data-step="2"></div>
                    
                    <!-- Step 3: Your Info -->
                    <div class="flex items-center">
                        <div class="step-indicator w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold" data-step="3">
                            3
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-500">Your Info</span>
                    </div>
                    
                    <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 rounded step-line" data-step="3"></div>
                    
                    <!-- Step 4: Confirm -->
                    <div class="flex items-center">
                        <div class="step-indicator w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold" data-step="4">
                            4
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-500">Confirm</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form Container -->
        <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-2xl shadow-2xl border-0">
            <form id="appointmentForm" class="p-8">
                @csrf
                
                <!-- Step 1: Doctor Selection -->
                <div class="booking-step" id="step-1">
                    <div class="text-center mb-8">
                        <h3 class="text-3xl font-bold mb-3 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Choose Your Doctor
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">
                            Select from our team of experienced healthcare professionals
                        </p>
                    </div>
                    
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($doctors as $doctor)
                        <div class="doctor-card group cursor-pointer border-2 border-gray-200 dark:border-gray-600 rounded-2xl p-6 hover:border-blue-500 hover:shadow-xl transition-all duration-300 transform hover:scale-105 bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-blue-900/20" data-doctor-id="{{ $doctor->id }}">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-blue-900/50 dark:to-indigo-900/50 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-user-md text-blue-600 dark:text-blue-400 text-2xl"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">{{ $doctor->name }}</h4>
                                <p class="text-blue-600 dark:text-blue-400 font-medium mb-3">{{ $doctor->department }}</p>
                                <div class="flex items-center justify-center gap-2 mb-4">
                                    <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 text-xs rounded-full font-medium">
                                        <i class="fas fa-circle text-green-500 text-xs mr-1"></i>
                                        Available
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <div class="flex items-center justify-center gap-1 mb-1">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <span>4.9 (127 reviews)</span>
                                    </div>
                                    <div class="flex items-center justify-center gap-1">
                                        <i class="fas fa-clock text-gray-400"></i>
                                        <span>Next available: Today</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="doctor" id="selectedDoctor" required>
                </div>
