@extends('mobile.layouts.app')

@section('title', 'Appointments - Admin')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="adminAppointments()">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">Appointments</h1>
                <p class="text-blue-100 text-sm">Manage all appointments</p>
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
        <div class="grid grid-cols-4 gap-3">
            <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                <div class="text-lg font-bold text-blue-600" x-text="stats.total"></div>
                <div class="text-xs text-gray-600">Total</div>
            </div>
            <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                <div class="text-lg font-bold text-green-600" x-text="stats.confirmed"></div>
                <div class="text-xs text-gray-600">Confirmed</div>
            </div>
            <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                <div class="text-lg font-bold text-yellow-600" x-text="stats.pending"></div>
                <div class="text-xs text-gray-600">Pending</div>
            </div>
            <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                <div class="text-lg font-bold text-red-600" x-text="stats.cancelled"></div>
                <div class="text-xs text-gray-600">Cancelled</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div x-show="showFilters" x-transition class="px-4 pb-4">
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <h3 class="font-semibold text-gray-900 mb-3">Filter Appointments</h3>
            <div class="grid grid-cols-2 gap-3">
                <select x-model="filters.status" @change="applyFilters()" 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <select x-model="filters.type" @change="applyFilters()"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="video">Video Call</option>
                    <option value="in-person">In-Person</option>
                </select>
            </div>
            <div class="mt-3">
                <input type="date" x-model="filters.date" @change="applyFilters()"
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-transparent">
            </div>
        </div>
    </div>

    <!-- Appointments List -->
    <div class="px-4 pb-6">
        <div class="space-y-3">
            <template x-for="appointment in filteredAppointments" :key="appointment.id">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <!-- Appointment Header -->
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900" x-text="appointment.patient_name"></h3>
                                    <p class="text-sm text-gray-600" x-text="appointment.doctor_name"></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                      :class="getStatusColor(appointment.status)" x-text="appointment.status"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Details -->
                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <div class="text-gray-600">Date & Time</div>
                                <div class="font-medium" x-text="formatDateTime(appointment.appointment_date, appointment.appointment_time)"></div>
                            </div>
                            <div>
                                <div class="text-gray-600">Type</div>
                                <div class="font-medium flex items-center">
                                    <i :class="appointment.type === 'video' ? 'fas fa-video text-blue-600' : 'fas fa-clinic-medical text-green-600'" class="mr-1"></i>
                                    <span x-text="appointment.type === 'video' ? 'Video Call' : 'In-Person'"></span>
                                </div>
                            </div>
                            <div>
                                <div class="text-gray-600">Duration</div>
                                <div class="font-medium" x-text="appointment.duration + ' minutes'"></div>
                            </div>
                            <div>
                                <div class="text-gray-600">Fee</div>
                                <div class="font-medium text-green-600" x-text="'€' + appointment.fee"></div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4 flex space-x-2">
                            <button @click="viewAppointment(appointment)" 
                                    class="flex-1 bg-mobile-primary text-white py-2 px-4 rounded-lg font-medium touch-target">
                                View Details
                            </button>
                            <button @click="editAppointment(appointment)" 
                                    class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium touch-target">
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Empty State -->
            <div x-show="filteredAppointments.length === 0" class="text-center py-12">
                <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-times text-gray-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No appointments found</h3>
                <p class="text-gray-600">Try adjusting your filters or check back later.</p>
            </div>
        </div>
    </div>

    <!-- Loading State -->
    <div x-show="isLoading" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 text-center">
            <div class="animate-spin h-8 w-8 border-4 border-mobile-primary border-t-transparent rounded-full mx-auto mb-4"></div>
            <p class="text-gray-600">Loading appointments...</p>
        </div>
    </div>
</div>

<script>
function adminAppointments() {
    return {
        isLoading: false,
        isRefreshing: false,
        showFilters: false,
        appointments: [],
        filteredAppointments: [],
        stats: {
            total: 0,
            confirmed: 0,
            pending: 0,
            cancelled: 0
        },
        filters: {
            status: '',
            type: '',
            date: ''
        },

        init() {
            this.loadAppointments();
        },

        async loadAppointments() {
            this.isLoading = true;
            try {
                // Simulate API call - replace with actual endpoint
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                // Mock data - replace with actual API response
                this.appointments = [
                    {
                        id: 1,
                        patient_name: 'John Doe',
                        doctor_name: 'Dr. Fintan',
                        appointment_date: '2024-01-15',
                        appointment_time: '10:00',
                        type: 'video',
                        status: 'confirmed',
                        duration: 30,
                        fee: 50
                    },
                    {
                        id: 2,
                        patient_name: 'Jane Smith',
                        doctor_name: 'Dr. Fintan',
                        appointment_date: '2024-01-15',
                        appointment_time: '14:30',
                        type: 'in-person',
                        status: 'pending',
                        duration: 45,
                        fee: 75
                    }
                ];

                this.updateStats();
                this.applyFilters();
            } catch (error) {
                console.error('Error loading appointments:', error);
                this.showToast('Error loading appointments', 'error');
            } finally {
                this.isLoading = false;
            }
        },

        async refreshData() {
            this.isRefreshing = true;
            await this.loadAppointments();
            this.isRefreshing = false;
            this.showToast('Appointments refreshed', 'success');
        },

        applyFilters() {
            this.filteredAppointments = this.appointments.filter(appointment => {
                if (this.filters.status && appointment.status !== this.filters.status) return false;
                if (this.filters.type && appointment.type !== this.filters.type) return false;
                if (this.filters.date && appointment.appointment_date !== this.filters.date) return false;
                return true;
            });
        },

        updateStats() {
            this.stats.total = this.appointments.length;
            this.stats.confirmed = this.appointments.filter(a => a.status === 'confirmed').length;
            this.stats.pending = this.appointments.filter(a => a.status === 'pending').length;
            this.stats.cancelled = this.appointments.filter(a => a.status === 'cancelled').length;
        },

        getStatusColor(status) {
            const colors = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'confirmed': 'bg-green-100 text-green-800',
                'completed': 'bg-blue-100 text-blue-800',
                'cancelled': 'bg-red-100 text-red-800'
            };
            return colors[status] || 'bg-gray-100 text-gray-800';
        },

        formatDateTime(date, time) {
            const dateObj = new Date(date + 'T' + time);
            return dateObj.toLocaleDateString() + ' at ' + dateObj.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        },

        viewAppointment(appointment) {
            // Navigate to appointment details
            window.location.href = `/admin/appointments/${appointment.id}`;
        },

        editAppointment(appointment) {
            // Navigate to edit appointment
            window.location.href = `/admin/appointments/${appointment.id}/edit`;
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
