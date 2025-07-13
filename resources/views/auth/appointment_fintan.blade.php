@include('layouts.header')

<body class="bg-gradient-to-br from-blue-50/30 to-indigo-50/30 dark:from-gray-900 dark:to-gray-800 min-h-screen font-inter">
    @include('layouts.navbar')

    <!-- Fintan-Style Booking Page -->
    <div class="py-8 px-4">
        <div class="container mx-auto max-w-4xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Book Your Consultation</h1>
                <p class="text-gray-600 dark:text-gray-300">Schedule your appointment with Dr. Fintan</p>
            </div>

            <!-- Main Booking Card -->
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-2xl shadow-2xl border-0 overflow-hidden">
                <div class="p-6 md:p-8">
                    <!-- Step Progress -->
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
                    <div id="step-content">
                        <!-- Step 1: Consultation Type -->
                        <div id="step-1" class="booking-step">
                            <div class="text-center mb-8">
                                <h2 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">
                                    Choose Your Consultation Type
                                </h2>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Select the consultation format that works best for you
                                </p>
                            </div>

                            <div class="grid gap-6 md:grid-cols-2">
                                <!-- Video Consultation -->
                                <div class="consultation-type-card relative cursor-pointer transition-all duration-200 hover:shadow-lg border-2 border-gray-200 dark:border-gray-700 rounded-xl p-6" data-type="video">
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

                                    <button class="w-full mt-6 py-3 px-6 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all hover:bg-gray-200 dark:hover:bg-gray-600 consultation-select-btn">
                                        Select This Option
                                    </button>
                                </div>

                                <!-- Audio Consultation -->
                                <div class="consultation-type-card relative cursor-pointer transition-all duration-200 hover:shadow-lg border-2 border-gray-200 dark:border-gray-700 rounded-xl p-6" data-type="audio">
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

                                    <button class="w-full mt-6 py-3 px-6 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all hover:bg-gray-200 dark:hover:bg-gray-600 consultation-select-btn">
                                        Select This Option
                                    </button>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 mt-8">
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
                        </div>

                        <!-- Step 2: Date & Time (Hidden initially) -->
                        <div id="step-2" class="booking-step hidden">
                            <div class="text-center mb-8">
                                <h2 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">
                                    Select Date & Time
                                </h2>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Choose your preferred appointment slot
                                </p>
                            </div>

                            <div class="grid lg:grid-cols-2 gap-8">
                                <!-- Calendar -->
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                    <div class="flex items-center gap-2 mb-6">
                                        <i class="fas fa-calendar text-blue-600 dark:text-blue-400"></i>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Select Date</h3>
                                    </div>

                                    <!-- Calendar Navigation -->
                                    <div class="flex items-center justify-between mb-4">
                                        <button type="button" id="prevMonth" class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                                            <i class="fas fa-chevron-left text-gray-600 dark:text-gray-400"></i>
                                        </button>
                                        <h4 id="currentMonth" class="text-lg font-medium text-gray-900 dark:text-gray-100"></h4>
                                        <button type="button" id="nextMonth" class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
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

                                <!-- Time Slots -->
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                    <div class="flex items-center gap-2 mb-6">
                                        <i class="fas fa-clock text-blue-600 dark:text-blue-400"></i>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Select Time</h3>
                                    </div>

                                    <div id="time-slots-container" class="hidden space-y-6">
                                        <!-- Morning Slots -->
                                        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-xl p-4 border border-yellow-200/50 dark:border-yellow-700/50">
                                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                                                <i class="fas fa-sun text-yellow-500 text-lg"></i>
                                                Morning (9 AM - 12 PM)
                                            </h4>
                                            <div class="grid grid-cols-2 gap-3" id="morning-slots">
                                                <!-- Morning time slots will be populated by JavaScript -->
                                            </div>
                                        </div>

                                        <!-- Afternoon Slots -->
                                        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl p-4 border border-blue-200/50 dark:border-blue-700/50">
                                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                                                <i class="fas fa-cloud-sun text-blue-500 text-lg"></i>
                                                Afternoon (2 PM - 5 PM)
                                            </h4>
                                            <div class="grid grid-cols-2 gap-3" id="afternoon-slots">
                                                <!-- Afternoon time slots will be populated by JavaScript -->
                                            </div>
                                        </div>

                                        <!-- Evening Slots -->
                                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl p-4 border border-purple-200/50 dark:border-purple-700/50">
                                            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                                                <i class="fas fa-moon text-purple-500 text-lg"></i>
                                                Evening (6 PM - 8 PM)
                                            </h4>
                                            <div class="grid grid-cols-2 gap-3" id="evening-slots">
                                                <!-- Evening time slots will be populated by JavaScript -->
                                            </div>
                                        </div>
                                    </div>

                                    <div id="no-date-selected" class="text-center py-12">
                                        <i class="fas fa-calendar-day text-gray-400 text-4xl mb-4"></i>
                                        <p class="text-gray-500 dark:text-gray-400">Please select a date to view available time slots</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Patient Information (Hidden initially) -->
                        <div id="step-3" class="booking-step hidden">
                            <div class="text-center mb-8">
                                <h2 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">
                                    Your Information
                                </h2>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Please provide your details for the consultation
                                </p>
                            </div>

                            <form id="patient-info-form" class="space-y-6">
                                @csrf

                                <!-- Doctor Selection -->
                                <div>
                                    <label for="doctor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Doctor & Department</label>
                                    <select name="doctor" id="doctor" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                                        @if(isset($doctors) && $doctors->count() > 0)
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}" {{ $doctor->name === 'Dr. Fintan' ? 'selected' : '' }}>
                                                    {{ $doctor->name }} - {{ $doctor->department }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="1" selected>Dr. Fintan - Neurology</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="firstName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name</label>
                                        <input type="text" id="firstName" name="firstName" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                    <div>
                                        <label for="lastName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Name</label>
                                        <input type="text" id="lastName" name="lastName" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                </div>

                                <div>
                                    <label for="dateOfBirth" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date of Birth</label>
                                    <input type="date" id="dateOfBirth" name="dateOfBirth" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                </div>

                                <div>
                                    <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reason for Consultation</label>
                                    <textarea id="reason" name="reason" rows="4" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="Please describe your symptoms or reason for consultation..."></textarea>
                                </div>

                                <input type="hidden" id="selectedDate" name="selectedDate">
                                <input type="hidden" id="selectedTime" name="selectedTime">
                                <input type="hidden" id="consultationType" name="consultationType">
                                <input type="hidden" id="selectedDoctor" name="selectedDoctor">
                            </form>
                        </div>

                        <!-- Step 4: Confirmation (Hidden initially) -->
                        <div id="step-4" class="booking-step hidden">
                            <div class="text-center mb-8">
                                <h2 class="text-2xl font-bold mb-2 text-gray-900 dark:text-gray-100">
                                    Confirm Your Appointment
                                </h2>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Please review your appointment details
                                </p>
                            </div>

                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200/50 dark:border-blue-700/50">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Appointment Summary</h3>
                                <div id="appointment-summary" class="space-y-3">
                                    <!-- Summary will be populated by JavaScript -->
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="button" id="confirm-appointment" class="w-full py-4 px-6 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl font-semibold text-lg transition-all transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Confirm Appointment
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button id="prev-btn" class="px-6 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors" style="display: none;">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Previous
                        </button>
                        <div class="flex-1"></div>
                        <button id="next-btn" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-medium transition-all transform hover:scale-105 shadow-lg" disabled>
                            Next Step
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    let currentStep = 1;
    let selectedConsultationType = '';
    let selectedDate = null;
    let selectedTime = '';
    const totalSteps = 4;
    const currentDate = new Date();

    // Consultation type selection
    document.querySelectorAll('.consultation-type-card').forEach(card => {
        card.addEventListener('click', function() {
            const type = this.dataset.type;
            selectedConsultationType = type;

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

            // Enable next button
            enableNextButton();
        });
    });

    // Navigation
    document.getElementById('next-btn').addEventListener('click', function() {
        if (currentStep < totalSteps && validateCurrentStep()) {
            currentStep++;
            updateStepDisplay();
            updateProgressBar();

            if (currentStep === 2) {
                initializeCalendar();
            }
        }
    });

    document.getElementById('prev-btn').addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateStepDisplay();
            updateProgressBar();
        }
    });

    function validateCurrentStep() {
        switch (currentStep) {
            case 1:
                return selectedConsultationType !== '';
            case 2:
                return selectedDate !== null && selectedTime !== '';
            case 3:
                const form = document.getElementById('patient-info-form');
                return form.checkValidity();
            default:
                return true;
        }
    }

    function updateStepDisplay() {
        // Hide all steps
        document.querySelectorAll('.booking-step').forEach(step => {
            step.classList.add('hidden');
        });

        // Show current step
        document.getElementById(`step-${currentStep}`).classList.remove('hidden');

        // Update step indicators
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

        // Update navigation buttons
        document.getElementById('prev-btn').style.display = currentStep > 1 ? 'block' : 'none';

        const nextBtn = document.getElementById('next-btn');
        if (currentStep === totalSteps) {
            nextBtn.style.display = 'none';
        } else {
            nextBtn.style.display = 'block';
            if (validateCurrentStep()) {
                enableNextButton();
            } else {
                disableNextButton();
            }
        }
    }

    function updateProgressBar() {
        const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
        document.getElementById('progress-bar').style.width = `${progress}%`;
    }

    function enableNextButton() {
        const btn = document.getElementById('next-btn');
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
    }

    function disableNextButton() {
        const btn = document.getElementById('next-btn');
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
    }

    // Calendar functionality
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
        selectedDate = date;
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
        const morningSlots = document.getElementById('morning-slots');
        const afternoonSlots = document.getElementById('afternoon-slots');
        const eveningSlots = document.getElementById('evening-slots');

        // Clear existing slots
        morningSlots.innerHTML = '';
        afternoonSlots.innerHTML = '';
        eveningSlots.innerHTML = '';

        // Morning slots (9 AM - 12 PM)
        const morningTimes = ['09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM'];
        morningTimes.forEach(time => {
            const slot = createTimeSlot(time);
            morningSlots.appendChild(slot);
        });

        // Afternoon slots (2 PM - 5 PM)
        const afternoonTimes = ['02:00 PM', '02:30 PM', '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM'];
        afternoonTimes.forEach(time => {
            const slot = createTimeSlot(time);
            afternoonSlots.appendChild(slot);
        });

        // Evening slots (6 PM - 8 PM)
        const eveningTimes = ['06:00 PM', '06:30 PM', '07:00 PM', '07:30 PM'];
        eveningTimes.forEach(time => {
            const slot = createTimeSlot(time);
            eveningSlots.appendChild(slot);
        });
    }

    function createTimeSlot(time) {
        const slot = document.createElement('button');
        slot.type = 'button';
        slot.className = 'time-slot p-4 border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 rounded-xl hover:border-blue-500 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-blue-900/20 dark:hover:to-indigo-900/20 hover:shadow-lg transition-all duration-300 text-center font-semibold text-sm text-gray-900 dark:text-gray-100 shadow-sm hover:scale-105';
        slot.textContent = time;
        slot.dataset.time = time;

        slot.addEventListener('click', function() {
            selectedTime = time;
            document.getElementById('selectedTime').value = time;

            // Remove selection from all slots
            document.querySelectorAll('.time-slot').forEach(s => {
                s.classList.remove('border-blue-500', 'bg-gradient-to-r', 'from-blue-600', 'to-indigo-600', 'text-white', 'ring-2', 'ring-blue-500', 'shadow-lg', 'scale-105');
                s.classList.add('border-gray-300', 'dark:border-gray-600', 'bg-white', 'dark:bg-gray-800', 'text-gray-900', 'dark:text-gray-100');
            });

            // Add selection to clicked slot
            this.classList.remove('border-gray-300', 'dark:border-gray-600', 'bg-white', 'dark:bg-gray-800', 'text-gray-900', 'dark:text-gray-100');
            this.classList.add('border-blue-500', 'bg-gradient-to-r', 'from-blue-600', 'to-indigo-600', 'text-white', 'ring-2', 'ring-blue-500', 'shadow-lg', 'scale-105');

            // Enable next button
            enableNextButton();
        });

        return slot;
    }

    // Form validation for step 3
    document.getElementById('patient-info-form').addEventListener('input', function() {
        if (currentStep === 3) {
            // Update hidden fields
            document.getElementById('consultationType').value = selectedConsultationType;
            document.getElementById('selectedDoctor').value = document.getElementById('doctor').value;

            if (this.checkValidity()) {
                enableNextButton();
            } else {
                disableNextButton();
            }
        }
    });

    // Doctor selection change
    document.getElementById('doctor').addEventListener('change', function() {
        if (currentStep === 3) {
            document.getElementById('selectedDoctor').value = this.value;
            checkFormValidity();
        }
    });

    // Update appointment summary in step 4
    function updateAppointmentSummary() {
        const doctorSelect = document.getElementById('doctor');
        const doctorName = doctorSelect.options[doctorSelect.selectedIndex].text;
        const consultationType = selectedConsultationType;
        const date = selectedDate ? selectedDate.toLocaleDateString() : '';
        const time = selectedTime;
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;

        const summaryHTML = `
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-300">Doctor:</span>
                    <span class="font-medium text-gray-900 dark:text-gray-100">${doctorName}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-300">Consultation Type:</span>
                    <span class="font-medium text-gray-900 dark:text-gray-100 capitalize">${consultationType}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-300">Date:</span>
                    <span class="font-medium text-gray-900 dark:text-gray-100">${date}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-300">Time:</span>
                    <span class="font-medium text-gray-900 dark:text-gray-100">${time}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-300">Patient:</span>
                    <span class="font-medium text-gray-900 dark:text-gray-100">${firstName} ${lastName}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-300">Email:</span>
                    <span class="font-medium text-gray-900 dark:text-gray-100">${email}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-300">Phone:</span>
                    <span class="font-medium text-gray-900 dark:text-gray-100">${phone}</span>
                </div>
                <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                    <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Cost:</span>
                    <span class="text-lg font-bold text-blue-600 dark:text-blue-400">${consultationType === 'video' ? '$75' : '$45'}</span>
                </div>
            </div>
        `;

        document.getElementById('appointment-summary').innerHTML = summaryHTML;
    }

    function checkFormValidity() {
        const form = document.getElementById('patient-info-form');
        if (currentStep === 3 && form.checkValidity()) {
            enableNextButton();
        } else if (currentStep === 3) {
            disableNextButton();
        }
    }

    // Initialize
    disableNextButton();
    updateStepDisplay();

    // Update summary when moving to step 4
    document.getElementById('next-btn').addEventListener('click', function() {
        if (currentStep === 3) {
            setTimeout(() => {
                updateAppointmentSummary();
            }, 100);
        }
    });

    // Confirm appointment submission
    document.getElementById('confirm-appointment').addEventListener('click', function() {
        const formData = new FormData();

        // Add all form data
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('patient_name', document.getElementById('firstName').value + ' ' + document.getElementById('lastName').value);
        formData.append('phone', document.getElementById('phone').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('doctor', document.getElementById('doctor').value);
        formData.append('date', document.getElementById('selectedDate').value);
        formData.append('time', document.getElementById('selectedTime').value);
        formData.append('consultation_type', selectedConsultationType);
        formData.append('message', document.getElementById('reason').value);
        formData.append('password', 'TempPassword123!'); // Temporary password

        // Create a temporary image file for validation (required by backend)
        const canvas = document.createElement('canvas');
        canvas.width = 100;
        canvas.height = 100;
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#f0f0f0';
        ctx.fillRect(0, 0, 100, 100);
        ctx.fillStyle = '#333';
        ctx.font = '12px Arial';
        ctx.fillText('Profile', 30, 50);

        canvas.toBlob(function(blob) {
            formData.append('image', blob, 'profile.png');

            // Submit the form
            fetch('{{ route("appointment.store") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    document.getElementById('appointment-summary').innerHTML = `
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check text-green-600 dark:text-green-400 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Appointment Confirmed!</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">${data.message}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">You will receive a confirmation email shortly.</p>
                        </div>
                    `;

                    // Hide confirm button
                    document.getElementById('confirm-appointment').style.display = 'none';

                    // Redirect after 3 seconds
                    setTimeout(() => {
                        window.location.href = data.redirect || '/login';
                    }, 3000);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while booking the appointment. Please try again.');
            });
        }, 'image/png');
    });
    </script>
</body>
</html>
