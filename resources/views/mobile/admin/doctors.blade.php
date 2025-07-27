@extends('mobile.layouts.app')

@section('title', 'Doctors - Admin')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="adminDoctors()">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">Doctors</h1>
                <p class="text-blue-100 text-sm">Manage medical staff</p>
            </div>
            <div class="flex space-x-2">
                <button @click="showFilters = !showFilters" class="p-2 bg-white/20 rounded-lg touch-target">
                    <i class="fas fa-filter"></i>
                </button>
                <button @click="refreshData()" class="p-2 bg-white/20 rounded-lg touch-target">
                    <i class="fas fa-sync-alt" :class="{ 'fa-spin': isRefreshing }"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="px-4 py-4">
        <div class="grid grid-cols-3 gap-3">
            <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                <div class="text-lg font-bold text-blue-600" x-text="stats.total"></div>
                <div class="text-xs text-gray-600">Total Doctors</div>
            </div>
            <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                <div class="text-lg font-bold text-green-600" x-text="stats.available"></div>
                <div class="text-xs text-gray-600">Available</div>
            </div>
            <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                <div class="text-lg font-bold text-yellow-600" x-text="stats.busy"></div>
                <div class="text-xs text-gray-600">Busy</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div x-show="showFilters" x-transition class="px-4 pb-4">
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <h3 class="font-semibold text-gray-900 mb-3">Filter Doctors</h3>
            <div class="grid grid-cols-2 gap-3">
                <select x-model="filters.status" @change="applyFilters()" 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="available">Available</option>
                    <option value="busy">Busy</option>
                    <option value="offline">Offline</option>
                </select>
                <select x-model="filters.specialization" @change="applyFilters()"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-transparent">
                    <option value="">All Specializations</option>
                    <option value="general">General Practice</option>
                    <option value="cardiology">Cardiology</option>
                    <option value="dermatology">Dermatology</option>
                    <option value="pediatrics">Pediatrics</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Doctors List -->
    <div class="px-4 pb-6">
        <div class="space-y-3">
            <template x-for="doctor in filteredDoctors" :key="doctor.id">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <!-- Doctor Header -->
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="relative">
                                    <div class="h-12 w-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold">
                                        <span x-text="getInitials(doctor.name)"></span>
                                    </div>
                                    <!-- Status Indicator -->
                                    <div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-2 border-white"
                                         :class="getStatusIndicator(doctor.status)"></div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900" x-text="'Dr. ' + doctor.name"></h3>
                                    <p class="text-sm text-gray-600" x-text="doctor.specialization"></p>
                                    <div class="flex items-center mt-1">
                                        <div class="flex text-yellow-400 text-xs">
                                            <template x-for="i in 5" :key="i">
                                                <i class="fas fa-star" :class="i <= doctor.rating ? 'text-yellow-400' : 'text-gray-300'"></i>
                                            </template>
                                        </div>
                                        <span class="text-xs text-gray-600 ml-1" x-text="doctor.rating + ' (' + doctor.reviews + ' reviews)'"></span>
                                    </div>
                                </div>
                            </div>
                            <button @click="toggleDoctorDetails(doctor.id)" class="p-2 text-gray-400 hover:text-gray-600 touch-target">
                                <i class="fas fa-chevron-down transition-transform" 
                                   :class="{ 'rotate-180': expandedDoctor === doctor.id }"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Doctor Details (Expandable) -->
                    <div x-show="expandedDoctor === doctor.id" x-transition class="border-t border-gray-100">
                        <div class="p-4 space-y-4">
                            <!-- Contact & Availability -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2">Contact</h4>
                                    <div class="space-y-1 text-sm">
                                        <div class="flex items-center">
                                            <i class="fas fa-envelope text-gray-400 w-4 mr-2"></i>
                                            <span x-text="doctor.email"></span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-phone text-gray-400 w-4 mr-2"></i>
                                            <span x-text="doctor.phone"></span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2">Availability</h4>
                                    <div class="text-sm">
                                        <div class="text-gray-600">Today</div>
                                        <div class="font-medium" x-text="doctor.availability_today"></div>
                                        <div class="text-gray-600 mt-1">Next Available</div>
                                        <div class="font-medium" x-text="doctor.next_available"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Experience & Qualifications -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Professional Info</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <div class="text-gray-600">Experience</div>
                                        <div class="font-medium" x-text="doctor.experience + ' years'"></div>
                                    </div>
                                    <div>
                                        <div class="text-gray-600">License</div>
                                        <div class="font-medium" x-text="doctor.license_number"></div>
                                    </div>
                                    <div>
                                        <div class="text-gray-600">Consultation Fee</div>
                                        <div class="font-medium text-green-600" x-text="'€' + doctor.consultation_fee"></div>
                                    </div>
                                    <div>
                                        <div class="text-gray-600">Languages</div>
                                        <div class="font-medium" x-text="doctor.languages.join(', ')"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Statistics -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Recent Activity</h4>
                                <div class="grid grid-cols-3 gap-4 text-sm">
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-blue-600" x-text="doctor.appointments_today"></div>
                                        <div class="text-gray-600">Today</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-green-600" x-text="doctor.appointments_week"></div>
                                        <div class="text-gray-600">This Week</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-purple-600" x-text="doctor.total_patients"></div>
                                        <div class="text-gray-600">Total Patients</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2 pt-2">
                                <button @click="viewDoctorProfile(doctor)" 
                                        class="flex-1 bg-mobile-primary text-white py-2 px-4 rounded-lg font-medium touch-target">
                                    View Profile
                                </button>
                                <button @click="viewSchedule(doctor)" 
                                        class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg font-medium touch-target">
                                    Schedule
                                </button>
                                <button @click="editDoctor(doctor)" 
                                        class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium touch-target">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Empty State -->
            <div x-show="filteredDoctors.length === 0" class="text-center py-12">
                <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-md text-gray-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No doctors found</h3>
                <p class="text-gray-600">Try adjusting your filters or check back later.</p>
            </div>
        </div>
    </div>

    <!-- Add Doctor Button -->
    <div class="fixed bottom-6 right-6">
        <button @click="addNewDoctor()" 
                class="h-14 w-14 bg-mobile-primary text-white rounded-full shadow-lg flex items-center justify-center touch-target">
            <i class="fas fa-plus text-xl"></i>
        </button>
    </div>

    <!-- Loading State -->
    <div x-show="isLoading" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 text-center">
            <div class="animate-spin h-8 w-8 border-4 border-mobile-primary border-t-transparent rounded-full mx-auto mb-4"></div>
            <p class="text-gray-600">Loading doctors...</p>
        </div>
    </div>
</div>

<script>
function adminDoctors() {
    return {
        isLoading: false,
        isRefreshing: false,
        showFilters: false,
        expandedDoctor: null,
        doctors: [],
        filteredDoctors: [],
        stats: {
            total: 0,
            available: 0,
            busy: 0
        },
        filters: {
            status: '',
            specialization: ''
        },

        init() {
            this.loadDoctors();
        },

        async loadDoctors() {
            this.isLoading = true;
            try {
                // Simulate API call - replace with actual endpoint
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                // Mock data - replace with actual API response
                this.doctors = [
                    {
                        id: 1,
                        name: 'Fintan O\'Sullivan',
                        email: 'fintan@drfintan.ie',
                        phone: '+353 87 123 4567',
                        specialization: 'General Practice',
                        status: 'available',
                        rating: 4.8,
                        reviews: 156,
                        experience: 15,
                        license_number: 'IMC-12345',
                        consultation_fee: 75,
                        languages: ['English', 'Irish'],
                        availability_today: '9:00 AM - 5:00 PM',
                        next_available: 'Today 2:30 PM',
                        appointments_today: 8,
                        appointments_week: 32,
                        total_patients: 245
                    },
                    {
                        id: 2,
                        name: 'Sarah Murphy',
                        email: 'sarah.murphy@clinic.ie',
                        phone: '+353 87 987 6543',
                        specialization: 'Cardiology',
                        status: 'busy',
                        rating: 4.9,
                        reviews: 89,
                        experience: 12,
                        license_number: 'IMC-67890',
                        consultation_fee: 120,
                        languages: ['English', 'French'],
                        availability_today: '10:00 AM - 4:00 PM',
                        next_available: 'Tomorrow 9:00 AM',
                        appointments_today: 6,
                        appointments_week: 24,
                        total_patients: 178
                    },
                    {
                        id: 3,
                        name: 'David Kelly',
                        email: 'david.kelly@clinic.ie',
                        phone: '+353 87 555 1234',
                        specialization: 'Dermatology',
                        status: 'offline',
                        rating: 4.7,
                        reviews: 67,
                        experience: 8,
                        license_number: 'IMC-11111',
                        consultation_fee: 95,
                        languages: ['English', 'Spanish'],
                        availability_today: 'Not available',
                        next_available: 'Monday 10:00 AM',
                        appointments_today: 0,
                        appointments_week: 18,
                        total_patients: 134
                    }
                ];

                this.updateStats();
                this.applyFilters();
            } catch (error) {
                console.error('Error loading doctors:', error);
                this.showToast('Error loading doctors', 'error');
            } finally {
                this.isLoading = false;
            }
        },

        async refreshData() {
            this.isRefreshing = true;
            await this.loadDoctors();
            this.isRefreshing = false;
            this.showToast('Doctors refreshed', 'success');
        },

        applyFilters() {
            this.filteredDoctors = this.doctors.filter(doctor => {
                if (this.filters.status && doctor.status !== this.filters.status) return false;
                if (this.filters.specialization && !doctor.specialization.toLowerCase().includes(this.filters.specialization.toLowerCase())) return false;
                return true;
            });
        },

        updateStats() {
            this.stats.total = this.doctors.length;
            this.stats.available = this.doctors.filter(d => d.status === 'available').length;
            this.stats.busy = this.doctors.filter(d => d.status === 'busy').length;
        },

        toggleDoctorDetails(doctorId) {
            this.expandedDoctor = this.expandedDoctor === doctorId ? null : doctorId;
        },

        getInitials(name) {
            return name.split(' ').map(n => n[0]).join('').toUpperCase();
        },

        getStatusIndicator(status) {
            const indicators = {
                'available': 'bg-green-500',
                'busy': 'bg-yellow-500',
                'offline': 'bg-gray-400'
            };
            return indicators[status] || 'bg-gray-400';
        },

        viewDoctorProfile(doctor) {
            // Navigate to doctor profile
            window.location.href = `/admin/doctors/${doctor.id}`;
        },

        viewSchedule(doctor) {
            // Navigate to doctor schedule
            window.location.href = `/admin/doctors/${doctor.id}/schedule`;
        },

        editDoctor(doctor) {
            // Navigate to edit doctor
            window.location.href = `/admin/doctors/${doctor.id}/edit`;
        },

        addNewDoctor() {
            // Navigate to add new doctor
            window.location.href = '/admin/doctors/create';
        },

        showToast(message, type = 'info') {
            window.dispatchEvent(new CustomEvent('show-toast', {
                detail: { message, type }
            }));
        }
    }
}
</script>
@endsection