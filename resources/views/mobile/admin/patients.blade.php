@extends('mobile.layouts.app')

@section('title', 'Patients - Admin')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="adminPatients()">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">Patients</h1>
                <p class="text-blue-100 text-sm">Manage patient records</p>
            </div>
            <div class="flex space-x-2">
                <button @click="showSearch = !showSearch" class="p-2 bg-white/20 rounded-lg touch-target">
                    <i class="fas fa-search"></i>
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
                <div class="text-xs text-gray-600">Total Patients</div>
            </div>
            <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                <div class="text-lg font-bold text-green-600" x-text="stats.active"></div>
                <div class="text-xs text-gray-600">Active</div>
            </div>
            <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                <div class="text-lg font-bold text-yellow-600" x-text="stats.newThisMonth"></div>
                <div class="text-xs text-gray-600">New This Month</div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div x-show="showSearch" x-transition class="px-4 pb-4">
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <div class="relative">
                <input type="text" x-model="searchQuery" @input="searchPatients()" 
                       placeholder="Search patients by name, email, or phone..."
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Patients List -->
    <div class="px-4 pb-6">
        <div class="space-y-3">
            <template x-for="patient in filteredPatients" :key="patient.id">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <!-- Patient Header -->
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                    <span x-text="getInitials(patient.name)"></span>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900" x-text="patient.name"></h3>
                                    <p class="text-sm text-gray-600" x-text="patient.email"></p>
                                    <div class="flex items-center mt-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                              :class="patient.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'" 
                                              x-text="patient.status"></span>
                                    </div>
                                </div>
                            </div>
                            <button @click="togglePatientDetails(patient.id)" class="p-2 text-gray-400 hover:text-gray-600 touch-target">
                                <i class="fas fa-chevron-down transition-transform" 
                                   :class="{ 'rotate-180': expandedPatient === patient.id }"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Patient Details (Expandable) -->
                    <div x-show="expandedPatient === patient.id" x-transition class="border-t border-gray-100">
                        <div class="p-4 space-y-4">
                            <!-- Contact Info -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Contact Information</h4>
                                <div class="grid grid-cols-1 gap-2 text-sm">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone text-gray-400 w-4 mr-2"></i>
                                        <span x-text="patient.phone || 'Not provided'"></span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-birthday-cake text-gray-400 w-4 mr-2"></i>
                                        <span x-text="patient.date_of_birth || 'Not provided'"></span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400 w-4 mr-2"></i>
                                        <span x-text="patient.address || 'Not provided'"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Medical Info -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Medical Information</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <div class="text-gray-600">Blood Type</div>
                                        <div class="font-medium" x-text="patient.blood_type || 'Unknown'"></div>
                                    </div>
                                    <div>
                                        <div class="text-gray-600">Allergies</div>
                                        <div class="font-medium" x-text="patient.allergies || 'None listed'"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Activity -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Recent Activity</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <div class="text-gray-600">Last Appointment</div>
                                        <div class="font-medium" x-text="formatDate(patient.last_appointment)"></div>
                                    </div>
                                    <div>
                                        <div class="text-gray-600">Total Appointments</div>
                                        <div class="font-medium" x-text="patient.total_appointments"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2 pt-2">
                                <button @click="viewPatientProfile(patient)" 
                                        class="flex-1 bg-mobile-primary text-white py-2 px-4 rounded-lg font-medium touch-target">
                                    View Profile
                                </button>
                                <button @click="scheduleAppointment(patient)" 
                                        class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg font-medium touch-target">
                                    Schedule
                                </button>
                                <button @click="editPatient(patient)" 
                                        class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg font-medium touch-target">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Empty State -->
            <div x-show="filteredPatients.length === 0" class="text-center py-12">
                <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-gray-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No patients found</h3>
                <p class="text-gray-600">Try adjusting your search or check back later.</p>
            </div>
        </div>
    </div>

    <!-- Add Patient Button -->
    <div class="fixed bottom-6 right-6">
        <button @click="addNewPatient()" 
                class="h-14 w-14 bg-mobile-primary text-white rounded-full shadow-lg flex items-center justify-center touch-target">
            <i class="fas fa-plus text-xl"></i>
        </button>
    </div>

    <!-- Loading State -->
    <div x-show="isLoading" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 text-center">
            <div class="animate-spin h-8 w-8 border-4 border-mobile-primary border-t-transparent rounded-full mx-auto mb-4"></div>
            <p class="text-gray-600">Loading patients...</p>
        </div>
    </div>
</div>

<script>
function adminPatients() {
    return {
        isLoading: false,
        isRefreshing: false,
        showSearch: false,
        searchQuery: '',
        expandedPatient: null,
        patients: [],
        filteredPatients: [],
        stats: {
            total: 0,
            active: 0,
            newThisMonth: 0
        },

        init() {
            this.loadPatients();
        },

        async loadPatients() {
            this.isLoading = true;
            try {
                // Simulate API call - replace with actual endpoint
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                // Mock data - replace with actual API response
                this.patients = [
                    {
                        id: 1,
                        name: 'John Doe',
                        email: 'john.doe@email.com',
                        phone: '+353 87 123 4567',
                        date_of_birth: '1985-03-15',
                        address: 'Dublin, Ireland',
                        blood_type: 'O+',
                        allergies: 'Penicillin',
                        status: 'active',
                        last_appointment: '2024-01-10',
                        total_appointments: 5
                    },
                    {
                        id: 2,
                        name: 'Jane Smith',
                        email: 'jane.smith@email.com',
                        phone: '+353 87 987 6543',
                        date_of_birth: '1990-07-22',
                        address: 'Cork, Ireland',
                        blood_type: 'A-',
                        allergies: 'None',
                        status: 'active',
                        last_appointment: '2024-01-12',
                        total_appointments: 3
                    },
                    {
                        id: 3,
                        name: 'Michael Johnson',
                        email: 'michael.j@email.com',
                        phone: '+353 87 555 1234',
                        date_of_birth: '1978-11-08',
                        address: 'Galway, Ireland',
                        blood_type: 'B+',
                        allergies: 'Shellfish',
                        status: 'inactive',
                        last_appointment: '2023-12-15',
                        total_appointments: 8
                    }
                ];

                this.updateStats();
                this.filteredPatients = [...this.patients];
            } catch (error) {
                console.error('Error loading patients:', error);
                this.showToast('Error loading patients', 'error');
            } finally {
                this.isLoading = false;
            }
        },

        async refreshData() {
            this.isRefreshing = true;
            await this.loadPatients();
            this.isRefreshing = false;
            this.showToast('Patients refreshed', 'success');
        },

        searchPatients() {
            if (!this.searchQuery.trim()) {
                this.filteredPatients = [...this.patients];
                return;
            }

            const query = this.searchQuery.toLowerCase();
            this.filteredPatients = this.patients.filter(patient => 
                patient.name.toLowerCase().includes(query) ||
                patient.email.toLowerCase().includes(query) ||
                (patient.phone && patient.phone.includes(query))
            );
        },

        updateStats() {
            this.stats.total = this.patients.length;
            this.stats.active = this.patients.filter(p => p.status === 'active').length;
            
            // Calculate new patients this month
            const thisMonth = new Date().getMonth();
            const thisYear = new Date().getFullYear();
            this.stats.newThisMonth = this.patients.filter(p => {
                const createdDate = new Date(p.created_at || '2024-01-01');
                return createdDate.getMonth() === thisMonth && createdDate.getFullYear() === thisYear;
            }).length;
        },

        togglePatientDetails(patientId) {
            this.expandedPatient = this.expandedPatient === patientId ? null : patientId;
        },

        getInitials(name) {
            return name.split(' ').map(n => n[0]).join('').toUpperCase();
        },

        formatDate(dateString) {
            if (!dateString) return 'Never';
            return new Date(dateString).toLocaleDateString();
        },

        viewPatientProfile(patient) {
            // Navigate to patient profile
            window.location.href = `/admin/patients/${patient.id}`;
        },

        scheduleAppointment(patient) {
            // Navigate to appointment scheduling with patient pre-selected
            window.location.href = `/admin/appointments/create?patient_id=${patient.id}`;
        },

        editPatient(patient) {
            // Navigate to edit patient
            window.location.href = `/admin/patients/${patient.id}/edit`;
        },

        addNewPatient() {
            // Navigate to add new patient
            window.location.href = '/admin/patients/create';
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
