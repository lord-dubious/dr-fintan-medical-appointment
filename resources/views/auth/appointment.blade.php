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
        </div>
    </div>
</section>

<!-- Fintan-Style Booking Flow -->
<section class="py-16 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div class="container mx-auto max-w-6xl px-4">
        
        <!-- Booking Progress -->
        <div class="mb-8">
            <div class="fintan-card-sm shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Book Your Consultation
                    </h2>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Step <span id="current-step">1</span> of 3
                    </span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Step 1: Date & Time -->
                    <div class="flex items-center">
                        <div class="step-indicator w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-semibold" data-step="1">
                            1
                        </div>
                        <span class="ml-2 text-sm font-medium text-blue-600 dark:text-blue-400">Date & Time</span>
                    </div>
                    
                    <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 rounded step-line" data-step="1"></div>
                    
                    <!-- Step 2: Your Info -->
                    <div class="flex items-center">
                        <div class="step-indicator w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold" data-step="2">
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Your Info</span>
                    </div>
                    
                    <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 rounded step-line" data-step="2"></div>
                    
                    <!-- Step 3: Confirm -->
                    <div class="flex items-center">
                        <div class="step-indicator w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold" data-step="3">
                            3
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Confirm</span>
                    </div>
                </div>
            </div>
        </div>

        <form id="appointmentForm">
            @csrf
            
            <!-- Step 1: Date & Time Selection -->
            <div class="booking-step" id="step-1">
                <div class="grid lg:grid-cols-2 gap-8">
                    
                    <!-- Calendar Card -->
                    <div class="fintan-card shadow-lg">
                        <div class="p-6">
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
                    </div>
                    
                    <!-- Time Slots Card -->
                    <div class="fintan-card shadow-lg">
                        <div class="p-6">
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
                                        <!-- Morning time slots -->
                                    </div>
                                </div>

                                <!-- Afternoon Slots -->
                                <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-xl p-4 border border-orange-200/50 dark:border-orange-700/50">
                                    <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                                        <i class="fas fa-sun text-orange-500 text-lg"></i>
                                        Afternoon (1 PM - 5 PM)
                                    </h4>
                                    <div class="grid grid-cols-2 gap-3" id="afternoon-slots">
                                        <!-- Afternoon time slots -->
                                    </div>
                                </div>

                                <!-- Evening Slots -->
                                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl p-4 border border-indigo-200/50 dark:border-indigo-700/50">
                                    <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                                        <i class="fas fa-moon text-indigo-500 text-lg"></i>
                                        Evening (6 PM - 8 PM)
                                    </h4>
                                    <div class="grid grid-cols-2 gap-3" id="evening-slots">
                                        <!-- Evening time slots -->
                                    </div>
                                </div>
                            </div>
                            
                            <div id="no-date-selected" class="text-center py-12 text-gray-500 dark:text-gray-400">
                                <div class="bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-calendar-plus text-3xl text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <p class="text-lg font-medium">Please select a date to view available times</p>
                                <p class="text-sm mt-2 opacity-75">Choose from the calendar on the left</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" name="date" id="selectedDate" required>
                <input type="hidden" name="time" id="selectedTime" required>
            </div>

            <!-- Step 2: Patient Information -->
            <div class="booking-step hidden" id="step-2">
                <div class="fintan-card shadow-lg">
                    <div class="p-8">
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold mb-3 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                Your Information
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Please provide your details for the appointment
                            </p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Doctor Selection -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Doctor & Department *</label>
                                <select name="doctor" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" required>
                                    <option value="">Select Doctor & Department</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->department }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Patient Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Patient Name *</label>
                                <input type="text" name="patient_name" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" placeholder="Enter your full name" required>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number *</label>
                                <input type="tel" name="phone" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" placeholder="Enter your phone number" required>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                                <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" placeholder="Enter your email" required>
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password *</label>
                                <input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" placeholder="Create a password" required>
                            </div>

                            <!-- Profile Image -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile Image</label>
                                <input type="file" name="image" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" accept="image/*">
                            </div>

                            <!-- Message -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message</label>
                                <textarea name="message" rows="4" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" placeholder="Tell us how you feel or any specific concerns..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Confirmation -->
            <div class="booking-step hidden" id="step-3">
                <div class="fintan-card shadow-lg">
                    <div class="p-8">
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold mb-3 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                Confirm Your Appointment
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Please review your appointment details before confirming
                            </p>
                        </div>

                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-2xl p-8 border border-blue-200/50 dark:border-blue-600/50">
                            <div class="grid md:grid-cols-2 gap-8">
                                <!-- Appointment Details -->
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Appointment Details</h4>
                                    <div class="space-y-3">
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
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center mt-8">
                <button type="button" id="prevBtn" class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl font-medium transition-all duration-200 hidden">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Previous
                </button>

                <div class="flex-1"></div>

                <button type="button" id="nextBtn" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                    Next Step
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>

                <button type="submit" id="submitBtn" class="px-8 py-3 bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 hidden">
                    <span id="spinner" class="hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Booking...
                    </span>
                    <span id="buttonText">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Confirm Appointment
                    </span>
                </button>
            </div>

            <!-- Availability Status -->
            <div id="availabilityStatus" class="mt-6 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 hidden">
                <div class="flex items-center gap-3">
                    <i class="fas fa-info-circle text-blue-600 dark:text-blue-400"></i>
                    <span class="text-blue-800 dark:text-blue-200 font-medium">Checking availability...</span>
                </div>
            </div>

            <!-- Alert container -->
            <div id="alertContainer" class="mt-6"></div>
        </form>
    </div>
</section>

@include('layouts.footer')

<script>
// Fintan-style booking functionality
let currentStep = 1;
const totalSteps = 3;
let currentDate = new Date();

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
        dayElement.className = 'calendar-day text-center p-3 cursor-pointer rounded-lg transition-all duration-200 font-medium text-sm border border-transparent';
        dayElement.textContent = date.getDate();

        if (date.getMonth() !== month) {
            dayElement.className += ' text-gray-400 dark:text-gray-600 cursor-not-allowed';
        } else if (date < new Date().setHours(0,0,0,0)) {
            dayElement.className += ' text-gray-400 dark:text-gray-600 cursor-not-allowed';
        } else {
            dayElement.className += ' text-gray-900 dark:text-gray-100 hover:bg-blue-100 dark:hover:bg-blue-800/50 hover:border-blue-300 dark:hover:border-blue-600 hover:scale-105';
            dayElement.addEventListener('click', () => selectDate(date));
        }

        if (date.toDateString() === new Date().toDateString()) {
            dayElement.className += ' bg-blue-600 text-white hover:bg-blue-700 border-blue-600';
        }

        calendarDays.appendChild(dayElement);
    }
}

function selectDate(date) {
    // Update selected date
    document.getElementById('selectedDate').value = date.toISOString().split('T')[0];

    // Update visual selection
    document.querySelectorAll('.calendar-day').forEach(day => {
        day.classList.remove('bg-blue-600', 'text-white', 'ring-2', 'ring-blue-500', 'border-blue-600');
    });
    event.target.classList.add('bg-blue-600', 'text-white', 'ring-2', 'ring-blue-500', 'border-blue-600');

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
    const morningTimes = ['09:00 AM', '10:00 AM', '11:00 AM'];
    morningTimes.forEach(time => {
        const slot = createTimeSlot(time);
        morningSlots.appendChild(slot);
    });

    // Afternoon slots (1 PM - 5 PM)
    const afternoonTimes = ['01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM'];
    afternoonTimes.forEach(time => {
        const slot = createTimeSlot(time);
        afternoonSlots.appendChild(slot);
    });

    // Evening slots (6 PM - 8 PM)
    const eveningTimes = ['06:00 PM', '07:00 PM'];
    eveningTimes.forEach(time => {
        const slot = createTimeSlot(time);
        eveningSlots.appendChild(slot);
    });
}

function createTimeSlot(time) {
    const slot = document.createElement('button');
    slot.type = 'button';
    slot.className = 'time-slot p-4 border-2 border-gray-300 dark:border-gray-500 bg-white dark:bg-gray-700 rounded-xl hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-600/20 hover:shadow-md transition-all duration-200 text-center font-semibold text-sm text-gray-900 dark:text-gray-100 shadow-sm';
    slot.textContent = time;
    slot.dataset.time = time;

    slot.addEventListener('click', function() {
        // Remove selection from all slots
        document.querySelectorAll('.time-slot').forEach(s => {
            s.classList.remove('border-blue-500', 'bg-blue-500', 'text-white', 'dark:bg-blue-500', 'ring-2', 'ring-blue-500', 'shadow-lg');
            s.classList.add('border-gray-300', 'dark:border-gray-500', 'bg-white', 'dark:bg-gray-700', 'text-gray-900', 'dark:text-gray-100');
        });

        // Add selection to clicked slot
        this.classList.remove('border-gray-300', 'dark:border-gray-500', 'bg-white', 'dark:bg-gray-700', 'text-gray-900', 'dark:text-gray-100');
        this.classList.add('border-blue-500', 'bg-blue-500', 'text-white', 'dark:bg-blue-500', 'ring-2', 'ring-blue-500', 'shadow-lg');
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

    // Doctor selection change event
    document.querySelector('select[name="doctor"]').addEventListener('change', checkAvailability);
}

function nextStep() {
    if (validateCurrentStep()) {
        if (currentStep < totalSteps) {
            currentStep++;
            updateStepDisplay();
            if (currentStep === 3) {
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
            if (!document.getElementById('selectedDate').value || !document.getElementById('selectedTime').value) {
                showAlert('Please select both date and time', 'error');
                return false;
            }
            break;
        case 2:
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

    // Update progress indicators
    document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
        const stepNum = index + 1;
        if (stepNum <= currentStep) {
            indicator.classList.remove('bg-gray-300', 'text-gray-600');
            indicator.classList.add('bg-blue-600', 'text-white');
            indicator.nextElementSibling.classList.remove('text-gray-500');
            indicator.nextElementSibling.classList.add('text-blue-600', 'dark:text-blue-400');
        } else {
            indicator.classList.remove('bg-blue-600', 'text-white');
            indicator.classList.add('bg-gray-300', 'text-gray-600');
            indicator.nextElementSibling.classList.remove('text-blue-600', 'dark:text-blue-400');
            indicator.nextElementSibling.classList.add('text-gray-500');
        }
    });

    // Update step lines
    document.querySelectorAll('.step-line').forEach((line, index) => {
        if (index < currentStep - 1) {
            line.classList.remove('bg-gray-200', 'dark:bg-gray-700');
            line.classList.add('bg-blue-600');
        } else {
            line.classList.remove('bg-blue-600');
            line.classList.add('bg-gray-200', 'dark:bg-gray-700');
        }
    });

    // Update current step number
    document.getElementById('current-step').textContent = currentStep;

    // Update navigation buttons
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');

    if (currentStep === 1) {
        prevBtn.classList.add('hidden');
    } else {
        prevBtn.classList.remove('hidden');
    }

    if (currentStep === totalSteps) {
        nextBtn.classList.add('hidden');
        submitBtn.classList.remove('hidden');
    } else {
        nextBtn.classList.remove('hidden');
        submitBtn.classList.add('hidden');
    }
}

function updateConfirmationDetails() {
    // Get selected doctor name
    const doctorSelect = document.querySelector('select[name="doctor"]');
    const doctorName = doctorSelect.options[doctorSelect.selectedIndex].text;

    // Update confirmation display
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

// Form submission
document.getElementById('appointmentForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const form = this;
    const formData = new FormData(form);
    const spinner = document.getElementById('spinner');
    const buttonText = document.getElementById('buttonText');

    // Show loading state
    spinner.classList.remove('hidden');
    buttonText.classList.add('hidden');

    // Submit form data via fetch
    fetch("{{ route('appointment.store') }}", {
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

        if (data.success) {
            showAlert('Appointment booked successfully! You will receive a confirmation email and SMS.', 'success');

            // Reset form after delay
            setTimeout(() => {
                form.reset();
                currentStep = 1;
                updateStepDisplay();
                // Reset selections
                document.querySelectorAll('.calendar-day').forEach(day => {
                    day.classList.remove('bg-blue-600', 'text-white', 'ring-2', 'ring-blue-500', 'border-blue-600');
                });
                document.querySelectorAll('.time-slot').forEach(slot => {
                    slot.classList.remove('border-blue-500', 'bg-blue-500', 'text-white', 'dark:bg-blue-500', 'ring-2', 'ring-blue-500', 'shadow-lg');
                    slot.classList.add('border-gray-300', 'dark:border-gray-500', 'bg-white', 'dark:bg-gray-700', 'text-gray-900', 'dark:text-gray-100');
                });
                document.getElementById('time-slots-container').classList.add('hidden');
                document.getElementById('no-date-selected').classList.remove('hidden');
                document.getElementById('availabilityStatus').classList.add('hidden');

                // Redirect if provided
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            }, 3000);
        } else {
            showAlert(data.message || 'Booking failed. Please try again.', 'error');
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
