@include('layouts.header')

@include('layouts.navbar')

<!-- Fintan-Style Booking Page -->
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 px-4 py-8">
    <div class="container mx-auto max-w-4xl">

        <!-- Fintan-Style Header -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors mb-4">
                <i class="fas fa-arrow-left"></i>
                Back to Home
            </a>
            <h1 class="text-3xl md:text-4xl font-bold dark:text-gray-100">
                Book with Dr. Fintan Ekochin
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-300">
                Complete your consultation booking in 4 simple steps
            </p>
        </div>

        <!-- Main Booking Card -->
        <div class="bg-white dark:bg-gray-800/95 rounded-2xl shadow-xl border-0 dark:border-gray-700">
            <div class="p-6 md:p-8">

                <!-- Progress Indicator -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex flex-col items-center relative z-10 flex-1">
                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-medium transition-all mb-2" id="step-1-indicator">
                                1
                            </div>
                            <span class="text-xs text-center text-blue-600 dark:text-blue-400 font-medium">Consultation Type</span>
                        </div>
                        <div class="flex flex-col items-center relative z-10 flex-1">
                            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center font-medium transition-all mb-2" id="step-2-indicator">
                                2
                            </div>
                            <span class="text-xs text-center text-gray-500 dark:text-gray-400">Date & Time</span>
                        </div>
                        <div class="flex flex-col items-center relative z-10 flex-1">
                            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center font-medium transition-all mb-2" id="step-3-indicator">
                                3
                            </div>
                            <span class="text-xs text-center text-gray-500 dark:text-gray-400">Your Information</span>
                        </div>
                        <div class="flex flex-col items-center relative z-10 flex-1">
                            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center font-medium transition-all mb-2" id="step-4-indicator">
                                4
                            </div>
                            <span class="text-xs text-center text-gray-500 dark:text-gray-400">Confirmation</span>
                        </div>
                    </div>
                    <!-- Progress line -->
                    <div class="relative h-1 bg-gray-200 dark:bg-gray-700 rounded">
                        <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-blue-600 to-indigo-600 rounded transition-all duration-300 ease-in-out" style="width: 25%" id="progress-bar"></div>
                    </div>
                </div>

                <!-- Step Content -->
                <form id="appointmentForm">
                    @csrf

            <!-- Step 1: Consultation Type Selection -->
            <div class="booking-step" id="step-1">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">
                        Choose Your Consultation Type
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        Select the consultation format that works best for you
                    </p>
                </div>

                <div class="grid gap-6 md:grid-cols-2 max-w-4xl mx-auto">
                    <!-- Video Consultation -->
                    <div class="consultation-type-card relative cursor-pointer transition-all duration-200 hover:shadow-lg border-2 border-gray-200 dark:border-gray-700 rounded-xl p-6 bg-white dark:bg-gray-800" data-type="video">
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-medium">
                                Recommended
                            </span>
                        </div>

                        <div class="text-center mb-4">
                            <div class="w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center mx-auto mb-3 transition-colors">
                                <i class="fas fa-video text-blue-600 dark:text-blue-400 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">
                                Video Consultation
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Face-to-face consultation with full visual examination
                            </p>
                        </div>

                        <div class="space-y-4">
                            <!-- Pricing and Duration -->
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock text-gray-500 text-sm"></i>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">30 minutes</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-dollar-sign text-gray-500 text-sm"></i>
                                    <span class="text-lg font-semibold text-blue-600 dark:text-blue-400">$75</span>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="space-y-2">
                                <h4 class="text-sm font-medium flex items-center gap-2 text-gray-900 dark:text-gray-100">
                                    <i class="fas fa-shield-alt text-sm"></i>
                                    What's included:
                                </h4>
                                <ul class="space-y-1">
                                    <li class="text-sm text-gray-600 dark:text-gray-300 flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-blue-600 rounded-full"></div>
                                        HD video call
                                    </li>
                                    <li class="text-sm text-gray-600 dark:text-gray-300 flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-blue-600 rounded-full"></div>
                                        Visual examination
                                    </li>
                                    <li class="text-sm text-gray-600 dark:text-gray-300 flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-blue-600 rounded-full"></div>
                                        Screen sharing
                                    </li>
                                    <li class="text-sm text-gray-600 dark:text-gray-300 flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-blue-600 rounded-full"></div>
                                        Recording available
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <button type="button" class="w-full mt-6 py-3 px-6 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all hover:bg-gray-200 dark:hover:bg-gray-600 consultation-select-btn">
                            Select This Option
                        </button>
                    </div>

                    <!-- Audio Consultation -->
                    <div class="consultation-type-card relative cursor-pointer transition-all duration-200 hover:shadow-lg border-2 border-gray-200 dark:border-gray-700 rounded-xl p-6 bg-white dark:bg-gray-800" data-type="audio">
                        <div class="text-center mb-4">
                            <div class="w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/50 flex items-center justify-center mx-auto mb-3 transition-colors">
                                <i class="fas fa-phone text-green-600 dark:text-green-400 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">
                                Audio Consultation
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Voice-only consultation for follow-ups and general advice
                            </p>
                        </div>

                        <div class="space-y-4">
                            <!-- Pricing and Duration -->
                            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock text-gray-500 text-sm"></i>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">20 minutes</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-dollar-sign text-gray-500 text-sm"></i>
                                    <span class="text-lg font-semibold text-green-600 dark:text-green-400">$45</span>
                                </div>
                            </div>

                            <!-- Features -->
                            <div class="space-y-2">
                                <h4 class="text-sm font-medium flex items-center gap-2 text-gray-900 dark:text-gray-100">
                                    <i class="fas fa-shield-alt text-sm"></i>
                                    What's included:
                                </h4>
                                <ul class="space-y-1">
                                    <li class="text-sm text-gray-600 dark:text-gray-300 flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-green-600 rounded-full"></div>
                                        High-quality audio
                                    </li>
                                    <li class="text-sm text-gray-600 dark:text-gray-300 flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-green-600 rounded-full"></div>
                                        Secure connection
                                    </li>
                                    <li class="text-sm text-gray-600 dark:text-gray-300 flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-green-600 rounded-full"></div>
                                        Text chat support
                                    </li>
                                    <li class="text-sm text-gray-600 dark:text-gray-300 flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-green-600 rounded-full"></div>
                                        Lower bandwidth
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <button type="button" class="w-full mt-6 py-3 px-6 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all hover:bg-gray-200 dark:hover:bg-gray-600 consultation-select-btn">
                            Select This Option
                        </button>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 mt-8 max-w-4xl mx-auto">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-users text-blue-600 dark:text-blue-400 text-lg mt-0.5"></i>
                        <div>
                            <h4 class="font-medium mb-2 text-gray-900 dark:text-gray-100">
                                All consultations include:
                            </h4>
                            <ul class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                <li>• Secure, HIPAA-compliant platform</li>
                                <li>• Consultation summary and recommendations</li>
                                <li>• Follow-up support via message</li>
                                <li>• Prescription services when appropriate</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="consultation_type" id="consultation_type" value="">
            </div>

            <!-- Step 2: Date & Time Selection -->
            <div class="booking-step hidden" id="step-2">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">
                        Schedule Your Consultation
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        Choose the perfect time that works for you
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <!-- Calendar Card -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                        <div class="flex items-center gap-2 mb-6">
                            <i class="fas fa-calendar text-blue-600 dark:text-blue-400"></i>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Select Date</h3>
                        </div>
                            
                            <!-- Calendar Navigation -->
                            <div class="flex items-center justify-between mb-4">
                                <button type="button" id="prevMonth" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <i class="fas fa-chevron-left text-gray-600 dark:text-gray-400"></i>
                                </button>
                                <h4 id="currentMonth" class="text-lg font-medium text-gray-900 dark:text-gray-100"></h4>
                                <button type="button" id="nextMonth" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <i class="fas fa-chevron-right text-gray-600 dark:text-gray-400"></i>
                                </button>
                            </div>
                            
                            <!-- Calendar Grid -->
                            <div class="grid grid-cols-7 gap-1 mb-2">
                                <div class="text-center text-xs font-medium text-gray-500 dark:text-gray-400 py-2">Sun</div>
                                <div class="text-center text-xs font-medium text-gray-500 dark:text-gray-400 py-2">Mon</div>
                                <div class="text-center text-xs font-medium text-gray-500 dark:text-gray-400 py-2">Tue</div>
                                <div class="text-center text-xs font-medium text-gray-500 dark:text-gray-400 py-2">Wed</div>
                                <div class="text-center text-xs font-medium text-gray-500 dark:text-gray-400 py-2">Thu</div>
                                <div class="text-center text-xs font-medium text-gray-500 dark:text-gray-400 py-2">Fri</div>
                                <div class="text-center text-xs font-medium text-gray-500 dark:text-gray-400 py-2">Sat</div>
                            </div>
                            
                            <!-- Calendar Days -->
                            <div class="grid grid-cols-7 gap-1" id="calendar-days">
                                <!-- Days will be populated by JavaScript -->
                            </div>
                    </div>

                    <!-- Time Slots Card -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                        <div class="flex items-center gap-2 mb-6">
                            <i class="fas fa-clock text-blue-600 dark:text-blue-400"></i>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Available Times</h3>
                        </div>
                        <div id="time-slots-container" class="hidden">
                            <div class="grid grid-cols-3 gap-3" id="all-time-slots">
                                <!-- Time slots will be populated by JavaScript -->
                            </div>
                        </div>
                            
                        <div id="no-date-selected" class="text-center py-12">
                            <i class="fas fa-calendar-day text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-400">Please select a date to view available time slots</p>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" name="date" id="selectedDate" required>
                <input type="hidden" name="time" id="selectedTime" required>
            </div>

            <!-- Step 3: Patient Information -->
            <div class="booking-step hidden" id="step-3">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">
                        Your Information
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        Please provide your details for the consultation
                    </p>
                </div>

                <div class="space-y-6">
                    <!-- Doctor Selection -->
                    <div class="space-y-2">
                        <label for="doctor" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Doctor</label>
                        <select name="doctor" id="doctor" class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-base ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" required>
                            @if(isset($doctors) && $doctors->count() > 0)
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ $doctor->name === 'Dr. Fintan' ? 'selected' : '' }}>
                                        {{ $doctor->name }} - {{ $doctor->department }}
                                    </option>
                                @endforeach
                            @else
                                <option value="1" selected>Dr. Fintan Ekochin - Neurology</option>
                            @endif
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="patient_name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Full Name</label>
                            <input type="text" id="patient_name" name="patient_name" required class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 dark:placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm">
                        </div>
                        <div class="space-y-2">
                            <label for="phone" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Phone Number</label>
                            <input type="tel" id="phone" name="phone" required class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 dark:placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email Address</label>
                            <input type="email" id="email" name="email" required class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 dark:placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm">
                        </div>
                        <div class="space-y-2">
                            <label for="password" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Password</label>
                            <input type="password" id="password" name="password" required class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 dark:placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="message" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Reason for Consultation</label>
                        <textarea id="message" name="message" rows="4" required class="flex min-h-[80px] w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-base ring-offset-background placeholder:text-gray-500 dark:placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" placeholder="Please describe your symptoms or reason for consultation..."></textarea>
                    </div>

                    <div class="space-y-2">
                        <label for="image" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Profile Image (Optional)</label>
                        <input type="file" id="image" name="image" accept="image/*" class="flex h-10 w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 dark:placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm">
                    </div>
                </div>
            </div>

            <!-- Step 4: Confirmation & Payment -->
            <div class="booking-step hidden" id="step-4">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">
                        Confirm Your Appointment
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        Please review your appointment details
                    </p>
                </div>

                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-2xl p-8 border border-blue-200/50 dark:border-blue-600/50">
                            <div class="grid md:grid-cols-2 gap-8">
                                <!-- Appointment Details -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Appointment Details</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-video text-blue-600 dark:text-blue-400"></i>
                                            <span class="text-gray-700 dark:text-gray-300">Type: <span id="confirm-consultation-type" class="font-medium"></span></span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-dollar-sign text-blue-600 dark:text-blue-400"></i>
                                            <span class="text-gray-700 dark:text-gray-300">Price: <span id="confirm-price" class="font-medium text-green-600 dark:text-green-400"></span></span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-user-md text-blue-600 dark:text-blue-400"></i>
                                            <span class="text-gray-700 dark:text-gray-300">Doctor: <span id="confirm-doctor" class="font-medium"></span></span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-calendar text-blue-600 dark:text-blue-400"></i>
                                            <span class="text-gray-700 dark:text-gray-300">Date: <span id="confirm-date" class="font-medium"></span></span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-clock text-blue-600 dark:text-blue-400"></i>
                                            <span class="text-gray-700 dark:text-gray-300">Time: <span id="confirm-time" class="font-medium"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Patient Details -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Patient Information</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
                                            <span class="text-gray-700 dark:text-gray-300">Name: <span id="confirm-name" class="font-medium"></span></span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-phone text-blue-600 dark:text-blue-400"></i>
                                            <span class="text-gray-700 dark:text-gray-300">Phone: <span id="confirm-phone" class="font-medium"></span></span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-envelope text-blue-600 dark:text-blue-400"></i>
                                            <span class="text-gray-700 dark:text-gray-300">Email: <span id="confirm-email" class="font-medium"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8">
                    <button type="button" id="prevBtn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-gray-300 dark:border-gray-600 bg-white dark:bg-transparent hover:bg-gray-50 dark:hover:bg-blue-600/20 hover:text-gray-900 dark:hover:text-gray-100 h-10 px-8 py-2 dark:text-gray-100 hidden">
                        Previous
                    </button>

                    <button type="button" id="nextBtn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-blue-600 text-white hover:bg-blue-600/90 dark:bg-blue-500 dark:hover:bg-blue-500/90 h-10 px-8 py-2">
                        Continue
                    </button>

                    <button type="button" id="paymentBtn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-blue-600 text-white hover:bg-blue-600/90 dark:bg-blue-500 dark:hover:bg-blue-500/90 h-10 px-8 py-2 hidden">
                        <span id="payment-spinner" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Processing...
                        </span>
                        <span id="payment-button-text">
                            Review & Pay
                        </span>
                    </button>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Alert container -->
<div id="alertContainer" class="fixed top-4 right-4 z-50"></div>

<!-- Availability Status -->
<div id="availabilityStatus" class="fixed top-20 right-4 z-50 p-3 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-lg hidden">
    <div class="flex items-center gap-2">
        <i class="fas fa-spinner fa-spin text-blue-600 dark:text-blue-400"></i>
        <span class="text-gray-800 dark:text-gray-200 text-sm font-medium">Checking availability...</span>
    </div>
</div>

@include('layouts.footer')

<script>
// Fintan-style booking functionality
let currentStep = 1;
const totalSteps = 4;
let currentDate = new Date();
let selectedConsultationType = '';
let consultationPrice = 0;

document.addEventListener('DOMContentLoaded', function() {
    initializeCalendar();
    initializeBookingInterface();
    updateStepDisplay();
});

function initializeCalendar() {
    generateCalendarDays(currentDate.getFullYear(), currentDate.getMonth());

    // Month navigation
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        generateCalendarDays(currentDate.getFullYear(), currentDate.getMonth());
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        generateCalendarDays(currentDate.getFullYear(), currentDate.getMonth());
    });
}

function generateCalendarDays(year, month) {
    const calendarDays = document.getElementById('calendar-days');
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"];

    document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDate = new Date(firstDay);
    startDate.setDate(startDate.getDate() - firstDay.getDay());

    calendarDays.innerHTML = '';

    for (let i = 0; i < 42; i++) {
        const date = new Date(startDate);
        date.setDate(startDate.getDate() + i);

        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day text-center p-3 cursor-pointer rounded-xl transition-all duration-300 font-medium text-sm border border-transparent hover:shadow-md';
        dayElement.textContent = date.getDate();

        if (date.getMonth() !== month) {
            dayElement.className += ' text-gray-400 dark:text-gray-600 cursor-not-allowed opacity-50';
        } else if (date < new Date().setHours(0,0,0,0)) {
            dayElement.className += ' text-gray-400 dark:text-gray-600 cursor-not-allowed opacity-50';
        } else {
            dayElement.className += ' text-gray-900 dark:text-gray-100 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-blue-900/20 dark:hover:to-indigo-900/20 hover:border-blue-200 dark:hover:border-blue-700 hover:scale-105';
            dayElement.addEventListener('click', () => selectDate(date));
        }

        if (date.toDateString() === new Date().toDateString()) {
            dayElement.className += ' bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 border-blue-600 shadow-lg ring-2 ring-blue-500/20';
        }

        calendarDays.appendChild(dayElement);
    }
}

function selectDate(date) {
    // Update selected date
    document.getElementById('selectedDate').value = date.toISOString().split('T')[0];

    // Update visual selection
    document.querySelectorAll('.calendar-day').forEach(day => {
        day.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-indigo-600', 'text-white', 'ring-2', 'ring-blue-500', 'border-blue-600', 'shadow-lg', 'from-blue-700', 'to-indigo-700');
    });
    event.target.classList.add('bg-gradient-to-r', 'from-blue-600', 'to-indigo-600', 'text-white', 'ring-2', 'ring-blue-500', 'border-blue-600', 'shadow-lg', 'hover:from-blue-700', 'hover:to-indigo-700');

    // Show time slots
    generateTimeSlots();
    document.getElementById('time-slots-container').classList.remove('hidden');
    document.getElementById('no-date-selected').classList.add('hidden');
}

function generateTimeSlots() {
    const allTimeSlotsContainer = document.getElementById('all-time-slots');

    // Clear existing slots
    allTimeSlotsContainer.innerHTML = '';

    // All available time slots (30-minute intervals)
    const allTimes = [
        '08:00 AM', '08:30 AM', '09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM',
        '11:00 AM', '11:30 AM', '01:00 PM', '01:30 PM', '02:00 PM', '02:30 PM',
        '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM', '05:00 PM', '05:30 PM'
    ];

    allTimes.forEach(time => {
        const slot = createTimeSlot(time);
        allTimeSlotsContainer.appendChild(slot);
    });
}

function createTimeSlot(time) {
    const slot = document.createElement('button');
    slot.type = 'button';
    slot.className = 'time-slot py-3 px-4 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 rounded-lg hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all text-center font-medium text-sm text-gray-900 dark:text-gray-100';
    slot.textContent = time;
    slot.dataset.time = time;

    slot.addEventListener('click', function() {
        // Remove selection from all slots
        document.querySelectorAll('.time-slot').forEach(s => {
            s.classList.remove('border-blue-600', 'bg-blue-600', 'text-white');
            s.classList.add('border-gray-300', 'dark:border-gray-600', 'bg-white', 'dark:bg-gray-800', 'text-gray-900', 'dark:text-gray-100');
        });

        // Add selection to clicked slot
        this.classList.remove('border-gray-300', 'dark:border-gray-600', 'bg-white', 'dark:bg-gray-800', 'text-gray-900', 'dark:text-gray-100');
        this.classList.add('border-blue-600', 'bg-blue-600', 'text-white');
        document.getElementById('selectedTime').value = time;

        // Check availability
        checkAvailability();
    });

    return slot;
}

function initializeBookingInterface() {
    // Navigation buttons
    document.getElementById('nextBtn').addEventListener('click', nextStep);
    document.getElementById('prevBtn').addEventListener('click', prevStep);

    // Consultation type selection
    document.querySelectorAll('.consultation-type-card').forEach(card => {
        card.addEventListener('click', function() {
            const type = this.dataset.type;
            selectedConsultationType = type;
            consultationPrice = type === 'video' ? 75 : 45;

            // Remove selection from all cards
            document.querySelectorAll('.consultation-type-card').forEach(c => {
                c.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                c.querySelector('.consultation-select-btn').textContent = 'Select This Option';
                c.querySelector('.consultation-select-btn').classList.remove('bg-blue-600', 'text-white');
                c.querySelector('.consultation-select-btn').classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
            });

            // Add selection to clicked card
            this.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
            this.querySelector('.consultation-select-btn').textContent = 'Selected';
            this.querySelector('.consultation-select-btn').classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
            this.querySelector('.consultation-select-btn').classList.add('bg-blue-600', 'text-white');

            // Update hidden field
            document.getElementById('consultation_type').value = type;

            // Enable next button
            updateNavigationButtons();
        });
    });

    // Doctor selection change event
    document.querySelector('select[name="doctor"]').addEventListener('change', checkAvailability);
}

function nextStep() {
    if (validateCurrentStep()) {
        if (currentStep < totalSteps) {
            currentStep++;
            updateStepDisplay();
            if (currentStep === 4) {
                updateConfirmationDetails();
            }
        }
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        updateStepDisplay();
    }
}

function validateCurrentStep() {
    switch(currentStep) {
        case 1:
            // Consultation type selection
            if (!selectedConsultationType) {
                showAlert('Please select a consultation type', 'error');
                return false;
            }
            break;
        case 2:
            // Date and time selection
            if (!document.getElementById('selectedDate').value || !document.getElementById('selectedTime').value) {
                showAlert('Please select both date and time', 'error');
                return false;
            }
            break;
        case 3:
            // Patient information
            const requiredFields = ['doctor', 'patient_name', 'phone', 'email', 'password'];
            for (let field of requiredFields) {
                if (!document.querySelector(`[name="${field}"]`).value) {
                    showAlert('Please fill in all required fields', 'error');
                    return false;
                }
            }
            break;
    }
    return true;
}

function updateStepDisplay() {
    // Hide all steps
    document.querySelectorAll('.booking-step').forEach(step => {
        step.classList.add('hidden');
    });

    // Show current step
    document.getElementById(`step-${currentStep}`).classList.remove('hidden');

    // Update step indicators (Fintan style)
    for (let i = 1; i <= totalSteps; i++) {
        const indicator = document.getElementById(`step-${i}-indicator`);
        const stepText = indicator.nextElementSibling;

        if (i < currentStep) {
            // Completed step
            indicator.innerHTML = '<i class="fas fa-check text-sm"></i>';
            indicator.className = 'w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-medium transition-all mb-2';
            stepText.className = 'text-xs text-center text-green-600 dark:text-green-400 font-medium';
        } else if (i === currentStep) {
            // Current step
            indicator.textContent = i;
            indicator.className = 'w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-medium transition-all mb-2';
            stepText.className = 'text-xs text-center text-blue-600 dark:text-blue-400 font-medium';
        } else {
            // Future step
            indicator.textContent = i;
            indicator.className = 'w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center font-medium transition-all mb-2';
            stepText.className = 'text-xs text-center text-gray-500 dark:text-gray-400';
        }
    }

    // Update progress bar
    const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
    document.getElementById('progress-bar').style.width = `${progress}%`;

    // Update navigation buttons
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const paymentBtn = document.getElementById('paymentBtn');

    if (currentStep === 1) {
        prevBtn.classList.add('hidden');
    } else {
        prevBtn.classList.remove('hidden');
    }

    if (currentStep === totalSteps) {
        nextBtn.classList.add('hidden');
        paymentBtn.classList.remove('hidden');
    } else {
        nextBtn.classList.remove('hidden');
        paymentBtn.classList.add('hidden');
    }
}

function updateConfirmationDetails() {
    // Get selected doctor name
    const doctorSelect = document.querySelector('select[name="doctor"]');
    const doctorName = doctorSelect.options[doctorSelect.selectedIndex].text;

    // Update confirmation display
    document.getElementById('confirm-consultation-type').textContent = selectedConsultationType.charAt(0).toUpperCase() + selectedConsultationType.slice(1) + ' Consultation';
    document.getElementById('confirm-price').textContent = '$' + consultationPrice;
    document.getElementById('confirm-doctor').textContent = doctorName;
    document.getElementById('confirm-date').textContent = document.getElementById('selectedDate').value;
    document.getElementById('confirm-time').textContent = document.getElementById('selectedTime').value;
    document.getElementById('confirm-name').textContent = document.querySelector('[name="patient_name"]').value;
    document.getElementById('confirm-phone').textContent = document.querySelector('[name="phone"]').value;
    document.getElementById('confirm-email').textContent = document.querySelector('[name="email"]').value;
}

function checkAvailability() {
    const doctorSelect = document.querySelector('select[name="doctor"]');
    const dateInput = document.getElementById('selectedDate');
    const timeInput = document.getElementById('selectedTime');
    const statusDiv = document.getElementById('availabilityStatus');

    const doctorId = doctorSelect.value;
    const date = dateInput.value;
    const time = timeInput.value;

    if (doctorId && date && time) {
        statusDiv.classList.remove('hidden');
        statusDiv.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas fa-spinner fa-spin text-blue-600 dark:text-blue-400"></i>
                <span class="text-blue-800 dark:text-blue-200 font-medium">Checking availability...</span>
            </div>
        `;

        fetch(`/check-doctor-availability?doctor_id=${doctorId}&date=${date}&time=${encodeURIComponent(time)}`)
            .then(response => response.json())
            .then(data => {
                if (data.available) {
                    statusDiv.innerHTML = `
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-green-800 dark:text-green-200 font-medium">Doctor is available ✅</span>
                        </div>
                    `;
                    statusDiv.className = 'mt-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700';
                } else {
                    statusDiv.innerHTML = `
                        <div class="flex items-center gap-3">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                            <span class="text-red-800 dark:text-red-200 font-medium">Doctor is not available ❌</span>
                        </div>
                    `;
                    statusDiv.className = 'mt-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700';
                }
            })
            .catch(error => {
                console.error('Error checking availability:', error);
                statusDiv.innerHTML = `
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                        <span class="text-yellow-800 dark:text-yellow-200 font-medium">Error checking availability</span>
                    </div>
                `;
                statusDiv.className = 'mt-6 p-4 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700';
            });
    } else {
        statusDiv.classList.add('hidden');
    }
}

function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    const alertClass = type === 'error' ? 'bg-red-50 border-red-200 text-red-800 dark:bg-red-900/20' :
                     type === 'success' ? 'bg-green-50 border-green-200 text-green-800 dark:bg-green-900/20' :
                     'bg-blue-50 border-blue-200 text-blue-800 dark:bg-blue-900/20';

    const iconClass = type === 'error' ? 'fa-exclamation-circle text-red-500' :
                     type === 'success' ? 'fa-check-circle text-green-500' :
                     'fa-info-circle text-blue-500';

    alertContainer.innerHTML = `
        <div class="${alertClass} border rounded-xl p-4">
            <div class="flex items-center">
                <i class="fas ${iconClass} text-xl mr-3"></i>
                <span>${message}</span>
            </div>
        </div>
    `;

    setTimeout(() => {
        alertContainer.innerHTML = '';
    }, 5000);
}

// Payment processing
document.getElementById('paymentBtn').addEventListener('click', function (event) {
    event.preventDefault();

    const form = document.getElementById('appointmentForm');
    const formData = new FormData(form);
    const spinner = document.getElementById('payment-spinner');
    const buttonText = document.getElementById('payment-button-text');

    // Add consultation type and amount to form data
    formData.append('consultation_type', selectedConsultationType);

    // Show loading state
    spinner.classList.remove('hidden');
    buttonText.classList.add('hidden');

    // Initialize payment
    fetch("{{ route('appointment.payment.initialize') }}", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw err;
            });
        }
        return response.json();
    })
    .then(data => {
        // Hide loading state
        spinner.classList.add('hidden');
        buttonText.classList.remove('hidden');

        if (data.success && data.payment_url) {
            // Redirect to Paystack payment page
            showAlert('Redirecting to payment...', 'success');
            setTimeout(() => {
                window.location.href = data.payment_url;
            }, 1000);
        } else {
            showAlert(data.message || 'Payment initialization failed. Please try again.', 'error');
        }
    })
    .catch(error => {
        // Hide loading state
        spinner.classList.add('hidden');
        buttonText.classList.remove('hidden');

        if (error.errors) {
            let errorMessages = [];
            for (const [field, messages] of Object.entries(error.errors)) {
                errorMessages.push(...messages);
            }
            showAlert('Please fix the following errors: ' + errorMessages.join(', '), 'error');
        } else {
            showAlert('Something went wrong. Please try again later.', 'error');
        }
    });
});
</script>
</body>
</html>
