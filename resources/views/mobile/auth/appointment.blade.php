@extends('mobile.layouts.app')

@section('title', 'Book Appointment - Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="appointmentBooking()">
    <!-- Progress Header -->
    <div class="bg-white shadow-sm px-4 py-4">
        <div class="flex items-center justify-between">
            <button @click="goBack()" class="p-2 -ml-2 touch-target">
                <i class="fas fa-arrow-left text-gray-600"></i>
            </button>
            <h1 class="text-lg font-semibold text-gray-900">Book Appointment</h1>
            <div class="w-8"></div> <!-- Spacer -->
        </div>
        
        <!-- Progress Bar -->
        <div class="mt-4">
            <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                <span :class="step >= 1 ? 'text-mobile-primary font-medium' : ''">Service</span>
                <span :class="step >= 2 ? 'text-mobile-primary font-medium' : ''">Date & Time</span>
                <span :class="step >= 3 ? 'text-mobile-primary font-medium' : ''">Details</span>
                <span :class="step >= 4 ? 'text-mobile-primary font-medium' : ''">Confirm</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-mobile-primary h-2 rounded-full transition-all duration-300" 
                     :style="`width: ${(step / 4) * 100}%`"></div>
            </div>
        </div>
    </div>

    <!-- Step Content -->
    <div class="flex-1 p-4">
        <!-- Step 1: Service Selection -->
        <div x-show="step === 1" x-transition class="space-y-4">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Select Service</h2>
                <p class="text-gray-600">Choose the type of consultation you need</p>
            </div>

            <div class="space-y-3">
                <div class="bg-white rounded-xl p-4 shadow-sm border-2 transition-colors"
                     :class="selectedService === 'video' ? 'border-mobile-primary bg-blue-50' : 'border-gray-200'"
                     @click="selectService('video')">
                    <div class="flex items-center">
                        <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-video text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">Video Consultation</h3>
                            <p class="text-sm text-gray-600">Online consultation from anywhere</p>
                            <p class="text-sm font-medium text-mobile-primary mt-1">€50</p>
                        </div>
                        <div class="ml-2">
                            <i class="fas fa-check-circle text-mobile-primary" 
                               x-show="selectedService === 'video'"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-2 transition-colors"
                     :class="selectedService === 'inperson' ? 'border-mobile-primary bg-blue-50' : 'border-gray-200'"
                     @click="selectService('inperson')">
                    <div class="flex items-center">
                        <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user-md text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">In-Person Consultation</h3>
                            <p class="text-sm text-gray-600">Visit our clinic in Dublin</p>
                            <p class="text-sm font-medium text-mobile-primary mt-1">€75</p>
                        </div>
                        <div class="ml-2">
                            <i class="fas fa-check-circle text-mobile-primary" 
                               x-show="selectedService === 'inperson'"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-2 transition-colors"
                     :class="selectedService === 'followup' ? 'border-mobile-primary bg-blue-50' : 'border-gray-200'"
                     @click="selectService('followup')">
                    <div class="flex items-center">
                        <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-redo text-purple-600"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">Follow-up Consultation</h3>
                            <p class="text-sm text-gray-600">Follow-up on previous visit</p>
                            <p class="text-sm font-medium text-mobile-primary mt-1">€35</p>
                        </div>
                        <div class="ml-2">
                            <i class="fas fa-check-circle text-mobile-primary" 
                               x-show="selectedService === 'followup'"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Date & Time Selection -->
        <div x-show="step === 2" x-transition class="space-y-4">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Select Date & Time</h2>
                <p class="text-gray-600">Choose your preferred appointment slot</p>
            </div>

            <!-- Calendar Component -->
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="flex items-center justify-between mb-4">
                    <button @click="previousMonth()" class="p-2 touch-target">
                        <i class="fas fa-chevron-left text-gray-600"></i>
                    </button>
                    <h3 class="font-semibold text-gray-900" x-text="currentMonthYear"></h3>
                    <button @click="nextMonth()" class="p-2 touch-target">
                        <i class="fas fa-chevron-right text-gray-600"></i>
                    </button>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-1 mb-4">
                    <template x-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">
                        <div class="text-center text-xs font-medium text-gray-500 py-2" x-text="day"></div>
                    </template>
                    <template x-for="date in calendarDates">
                        <button class="aspect-square flex items-center justify-center text-sm rounded-lg transition-colors"
                                :class="getDateClasses(date)"
                                @click="selectDate(date)"
                                :disabled="!date.available">
                            <span x-text="date.day"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Time Slots -->
            <div x-show="selectedDate" class="bg-white rounded-xl shadow-sm p-4">
                <h4 class="font-semibold text-gray-900 mb-3">Available Times</h4>
                <div class="grid grid-cols-3 gap-2">
                    <template x-for="time in availableTimes">
                        <button class="py-3 px-2 text-sm font-medium rounded-lg border-2 transition-colors"
                                :class="selectedTime === time ? 'border-mobile-primary bg-blue-50 text-mobile-primary' : 'border-gray-200 text-gray-700'"
                                @click="selectTime(time)">
                            <span x-text="time"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Step 3: Patient Details -->
        <div x-show="step === 3" x-transition class="space-y-4">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Patient Details</h2>
                <p class="text-gray-600">Please provide your information</p>
            </div>

            <form class="space-y-4">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" 
                           x-model="patientDetails.name"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                           placeholder="Enter your full name">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" 
                           x-model="patientDetails.email"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                           placeholder="Enter your email">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" 
                           x-model="patientDetails.phone"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                           placeholder="Enter your phone number">
                </div>

                <!-- Date of Birth -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                    <input type="date" 
                           x-model="patientDetails.dateOfBirth"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary">
                </div>

                <!-- Reason for Visit -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Visit</label>
                    <textarea x-model="patientDetails.reason"
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                              placeholder="Briefly describe your symptoms or reason for consultation"></textarea>
                </div>
            </form>
        </div>

        <!-- Step 4: Confirmation -->
        <div x-show="step === 4" x-transition class="space-y-4">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Confirm Appointment</h2>
                <p class="text-gray-600">Please review your appointment details</p>
            </div>

            <!-- Appointment Summary -->
            <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Service</span>
                    <span class="font-medium" x-text="getServiceName()"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Date</span>
                    <span class="font-medium" x-text="getFormattedDate()"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Time</span>
                    <span class="font-medium" x-text="selectedTime"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Patient</span>
                    <span class="font-medium" x-text="patientDetails.name"></span>
                </div>
                <div class="border-t pt-4">
                    <div class="flex items-center justify-between text-lg font-semibold">
                        <span>Total</span>
                        <span class="text-mobile-primary" x-text="getServicePrice()"></span>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h4 class="font-semibold text-gray-900 mb-4">Payment Method</h4>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="radio" name="payment" value="card" x-model="paymentMethod" class="mr-3">
                        <i class="fas fa-credit-card mr-2 text-gray-600"></i>
                        <span>Credit/Debit Card</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="payment" value="paypal" x-model="paymentMethod" class="mr-3">
                        <i class="fab fa-paypal mr-2 text-blue-600"></i>
                        <span>PayPal</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bg-white border-t px-4 py-4 space-y-3">
        <div class="flex space-x-3">
            <button x-show="step > 1" 
                    @click="previousStep()"
                    class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-semibold active:scale-95 transition-transform">
                Back
            </button>
            <button x-show="step < 4" 
                    @click="nextStep()"
                    :disabled="!canProceed()"
                    :class="canProceed() ? 'bg-mobile-primary text-white' : 'bg-gray-300 text-gray-500'"
                    class="flex-1 py-3 px-6 rounded-xl font-semibold active:scale-95 transition-transform">
                Continue
            </button>
            <button x-show="step === 4" 
                    @click="bookAppointment()"
                    class="flex-1 bg-mobile-primary text-white py-3 px-6 rounded-xl font-semibold active:scale-95 transition-transform">
                Book Appointment
            </button>
        </div>
    </div>
</div>

<script>
function appointmentBooking() {
    return {
        step: 1,
        selectedService: '',
        selectedDate: null,
        selectedTime: '',
        paymentMethod: 'card',
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        patientDetails: {
            name: '',
            email: '',
            phone: '',
            dateOfBirth: '',
            reason: ''
        },

        get currentMonthYear() {
            const months = ['January', 'February', 'March', 'April', 'May', 'June',
                          'July', 'August', 'September', 'October', 'November', 'December'];
            return `${months[this.currentMonth]} ${this.currentYear}`;
        },

        get calendarDates() {
            const firstDay = new Date(this.currentYear, this.currentMonth, 1);
            const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());
            
            const dates = [];
            const today = new Date();
            
            for (let i = 0; i < 42; i++) {
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);
                
                dates.push({
                    day: date.getDate(),
                    date: date,
                    isCurrentMonth: date.getMonth() === this.currentMonth,
                    isToday: date.toDateString() === today.toDateString(),
                    available: date >= today && date.getMonth() === this.currentMonth
                });
            }
            
            return dates;
        },

        get availableTimes() {
            if (!this.selectedDate) return [];
            return ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', 
                   '14:00', '14:30', '15:00', '15:30', '16:00', '16:30'];
        },

        selectService(service) {
            this.selectedService = service;
        },

        selectDate(date) {
            if (date.available) {
                this.selectedDate = date.date;
                this.selectedTime = '';
            }
        },

        selectTime(time) {
            this.selectedTime = time;
        },

        getDateClasses(date) {
            let classes = '';
            if (!date.isCurrentMonth) {
                classes += 'text-gray-300 ';
            } else if (!date.available) {
                classes += 'text-gray-400 cursor-not-allowed ';
            } else if (this.selectedDate && date.date.toDateString() === this.selectedDate.toDateString()) {
                classes += 'bg-mobile-primary text-white ';
            } else if (date.isToday) {
                classes += 'bg-blue-100 text-mobile-primary ';
            } else {
                classes += 'text-gray-700 hover:bg-gray-100 ';
            }
            return classes;
        },

        previousMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
        },

        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
        },

        canProceed() {
            switch (this.step) {
                case 1: return this.selectedService !== '';
                case 2: return this.selectedDate && this.selectedTime;
                case 3: return this.patientDetails.name && this.patientDetails.email && this.patientDetails.phone;
                case 4: return this.paymentMethod;
                default: return false;
            }
        },

        nextStep() {
            if (this.canProceed() && this.step < 4) {
                this.step++;
            }
        },

        previousStep() {
            if (this.step > 1) {
                this.step--;
            }
        },

        goBack() {
            if (this.step > 1) {
                this.previousStep();
            } else {
                window.history.back();
            }
        },

        getServiceName() {
            const services = {
                'video': 'Video Consultation',
                'inperson': 'In-Person Consultation',
                'followup': 'Follow-up Consultation'
            };
            return services[this.selectedService] || '';
        },

        getServicePrice() {
            const prices = {
                'video': '€50',
                'inperson': '€75',
                'followup': '€35'
            };
            return prices[this.selectedService] || '';
        },

        getFormattedDate() {
            if (!this.selectedDate) return '';
            return this.selectedDate.toLocaleDateString('en-IE', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        },

        async bookAppointment() {
            try {
                // Show loading state
                this.$dispatch('show-loading');
                
                const appointmentData = {
                    service: this.selectedService,
                    doctor: this.selectedDoctor,
                    date: this.selectedDate.toISOString().split('T')[0],
                    time: this.selectedTime,
                    message: this.patientDetails.message,
                    payment_method: this.paymentMethod
                };

                // Real API call to mobile booking endpoint
                const response = await fetch('/mobile-api/appointments/book', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(appointmentData)
                });

                const result = await window.MobileUtils.apiCall('/mobile-api/appointments/book', {
                    method: 'POST',
                    body: JSON.stringify(appointmentData)
                });

                window.MobileUtils.hideLoading();

                if (result.success) {
                    window.MobileUtils.showToast('Appointment booked successfully!', 'success');

                    // Redirect to mobile dashboard
                    setTimeout(() => {
                        window.location.href = '/mobile/user/dashboard';
                    }, 1500);
                } else {
                    throw new Error(result.message || 'Booking failed');
                }

            } catch (error) {
                this.$dispatch('hide-loading');
                this.$dispatch('show-toast', { 
                    message: error.message || 'Failed to book appointment. Please try again.', 
                    type: 'error' 
                });
            }
        },

        // Fetch available time slots for selected doctor and date
        async fetchAvailableSlots() {
            if (!this.selectedDoctor || !this.selectedDate) {
                this.availableSlots = [];
                return;
            }

            this.loadingSlots = true;
            try {
                const dateString = this.selectedDate.toISOString().split('T')[0];
                this.availableSlots = await window.MobileUtils.fetchAvailableSlots(this.selectedDoctor, dateString);
                
                if (this.availableSlots.length === 0) {
                    window.MobileUtils.showToast('No available slots for selected date', 'warning');
                }
            } catch (error) {
                console.error('Error fetching slots:', error);
                this.availableSlots = [];
                window.MobileUtils.showToast('Error loading available times', 'error');
            } finally {
                this.loadingSlots = false;
            }
        }
    }
}
</script>
@endsection
