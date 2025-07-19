@include('layouts.header')

<body>
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


    <!--============================
        APPOINTMENT PAGE START
    ==============================-->
    <section class="appointment_page pt_100 xs_pt_65 pb_100 xs_pb_70">
        <div class="container">
            <div class="appointment_content">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 wow fadeInLeft" data-wow-duration="1s">
                        <div class="appointment_page_img">
                            <img src="https://media.istockphoto.com/id/1073728878/photo/focused-on-saving-a-life.jpg?s=612x612&w=0&k=20&c=MGUPBEHFr9sFWO4VsKy0VnsVcskdNT51u1bpaHi8oSs=" alt="appointment" class="img-fluid w-100">
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6 wow fadeInRight" data-wow-duration="1s">
                        <div class="appointment_page_text">
                        <form id="appointmentForm">
                            @csrf <!-- Add the CSRF token -->
                            <h2>Book Appointment</h2>
                            <p>Schedule your visit with ease! Our online booking system allows you to choose a convenient date and time for your appointment. Whether it's a routine check-up or a specialized consultation, we’re here to provide you with the best care at your convenience.</p>
                            <!-- Modern Form Grid -->
                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                <!-- Doctor Selection -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Select Doctor & Department</label>
                                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($doctors as $doctor)
                                        <div class="doctor-card group cursor-pointer border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 hover:border-blue-500 hover:shadow-lg transition-all duration-300 bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-blue-900/20" data-doctor-id="{{ $doctor->id }}">
                                            <div class="text-center">
                                                <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-blue-900/50 dark:to-indigo-900/50 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <i class="fas fa-user-md text-blue-600 dark:text-blue-400"></i>
                                                </div>
                                                <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 mb-1">{{ $doctor->name }}</h4>
                                                <p class="text-blue-600 dark:text-blue-400 text-xs font-medium">{{ $doctor->department }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <select name="doctor" id="selectedDoctor" class="hidden" required>
                                        <option value="">Select Doctor</option>
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
                                    <input type="text" name="phone" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" placeholder="Enter your phone number" required>
                                </div>

                                <!-- Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Appointment Date *</label>
                                    <input type="date" name="date" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" required>
                                </div>

                                <!-- Time -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Appointment Time *</label>
                                    <select name="time" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" required>
                                        <option value="">Select Time</option>
                                        <option value="10.00 am to 11.00 am">10.00 am to 11.00 am</option>
                                        <option value="11.00 am to 12.00 pm">11.00 am to 12.00 pm</option>
                                        <option value="3.00 pm to 4.00 pm">3.00 pm to 4.00 pm</option>
                                        <option value="4.00 pm to 5.00 pm">4.00 pm to 5.00 pm</option>
                                    </select>
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

                            <!-- Availability Status -->
                            <div id="availabilityStatus" class="mb-6 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 hidden">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-info-circle text-blue-600 dark:text-blue-400"></i>
                                    <span class="text-blue-800 dark:text-blue-200 font-medium">Checking availability...</span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 text-lg">
                                    <span id="spinner" class="hidden">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                        Booking Appointment...
                                    </span>
                                    <span id="buttonText">
                                        <i class="fas fa-calendar-check mr-2"></i>
                                        Book Appointment
                                    </span>
                                </button>
                            </div>

                            <!-- Alert container -->
                            <div id="alertContainer" class="mt-6"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        APPOINTMENT PAGE END
    ==============================-->

@include('layouts.footer')

<script>
// Modern appointment booking functionality
document.addEventListener('DOMContentLoaded', function () {
    initializeBookingInterface();
});

function initializeBookingInterface() {
    // Doctor card selection
    document.querySelectorAll('.doctor-card').forEach(card => {
        card.addEventListener('click', function() {
            // Remove selection from all cards
            document.querySelectorAll('.doctor-card').forEach(c => {
                c.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20', 'ring-2', 'ring-blue-500');
            });

            // Add selection to clicked card
            this.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20', 'ring-2', 'ring-blue-500');

            // Update hidden select field
            const doctorId = this.dataset.doctorId;
            document.getElementById('selectedDoctor').value = doctorId;

            // Check availability when doctor is selected
            checkAvailability();
        });
    });

    // Check availability when date or time changes
    const dateInput = document.querySelector('input[name="date"]');
    const timeSelect = document.querySelector('select[name="time"]');

    if (dateInput) dateInput.addEventListener('change', checkAvailability);
    if (timeSelect) timeSelect.addEventListener('change', checkAvailability);
}

function checkAvailability() {
    const doctorSelect = document.getElementById('selectedDoctor');
    const dateInput = document.querySelector('input[name="date"]');
    const timeSelect = document.querySelector('select[name="time"]');
    const statusDiv = document.getElementById('availabilityStatus');

    const doctorId = doctorSelect.value;
    const date = dateInput.value;
    const time = timeSelect.value;

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
                    statusDiv.className = 'mb-6 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700';
                } else {
                    statusDiv.innerHTML = `
                        <div class="flex items-center gap-3">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                            <span class="text-red-800 dark:text-red-200 font-medium">Doctor is not available ❌</span>
                        </div>
                    `;
                    statusDiv.className = 'mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700';
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
                statusDiv.className = 'mb-6 p-4 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700';
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

// Form submission with modern styling
document.getElementById('appointmentForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const form = this;
    const formData = new FormData(form);
    const spinner = document.getElementById('spinner');
    const buttonText = document.getElementById('buttonText');

    // Validate doctor selection
    if (!document.getElementById('selectedDoctor').value) {
        showAlert('Please select a doctor before booking', 'error');
        return;
    }

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
                // Reset doctor selection
                document.querySelectorAll('.doctor-card').forEach(c => {
                    c.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20', 'ring-2', 'ring-blue-500');
                });
                document.getElementById('selectedDoctor').value = '';
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