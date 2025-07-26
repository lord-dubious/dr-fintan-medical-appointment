@extends('mobile.layouts.app')

@section('title', 'My Appointments - Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="doctorAppointments()">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">My Appointments</h1>
                <p class="text-blue-100 text-sm">Manage your patient appointments</p>
            </div>
            <button @click="showCalendarView = !showCalendarView" class="p-2 bg-white/20 rounded-lg touch-target">
                <i :class="showCalendarView ? 'fas fa-list' : 'fas fa-calendar'" class="text-white"></i>
            </button>
        </div>
    </div>

    <!-- Date Filter -->
    <div class="bg-white px-4 py-3 border-b">
        <div class="flex items-center justify-between">
            <button @click="previousDay()" class="p-2 touch-target">
                <i class="fas fa-chevron-left text-gray-600"></i>
            </button>
            <div class="text-center">
                <h3 class="font-semibold text-gray-900" x-text="selectedDate"></h3>
                <p class="text-sm text-gray-600" x-text="selectedDateFormatted"></p>
            </div>
            <button @click="nextDay()" class="p-2 touch-target">
                <i class="fas fa-chevron-right text-gray-600"></i>
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="px-4 py-4 bg-gray-50">
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-lg p-3 text-center">
                <div class="text-lg font-bold text-mobile-primary">8</div>
                <div class="text-xs text-gray-600">Today</div>
            </div>
            <div class="bg-white rounded-lg p-3 text-center">
                <div class="text-lg font-bold text-green-600">6</div>
                <div class="text-xs text-gray-600">Completed</div>
            </div>
            <div class="bg-white rounded-lg p-3 text-center">
                <div class="text-lg font-bold text-orange-600">2</div>
                <div class="text-xs text-gray-600">Pending</div>
            </div>
        </div>
    </div>

    <!-- Appointments Timeline -->
    <div class="px-4 py-6">
        <div class="space-y-4">
            <!-- Morning Section -->
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Morning</h3>
                
                <!-- Appointment Card -->
                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-green-500 mb-3">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center">
                            <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-green-600 font-semibold text-sm">JD</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">John Doe</h3>
                                <p class="text-sm text-gray-600">General Consultation</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-900">9:00 AM</div>
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                                Completed
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-video mr-2 text-gray-400"></i>
                            Video Call
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-clock mr-2 text-gray-400"></i>
                            30 minutes
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <button class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium">
                            View Notes
                        </button>
                        <button class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium">
                            Prescription
                        </button>
                    </div>
                </div>

                <!-- Another Appointment -->
                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-blue-500">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center">
                            <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-blue-600 font-semibold text-sm">SM</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Sarah Miller</h3>
                                <p class="text-sm text-gray-600">Follow-up Consultation</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-900">10:30 AM</div>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                In Progress
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-hospital mr-2 text-gray-400"></i>
                            In-Person
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-clock mr-2 text-gray-400"></i>
                            45 minutes
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <button class="flex-1 bg-mobile-primary text-white py-2 px-4 rounded-lg text-sm font-medium">
                            Start Call
                        </button>
                        <button class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium">
                            Reschedule
                        </button>
                    </div>
                </div>
            </div>

            <!-- Afternoon Section -->
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Afternoon</h3>
                
                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-orange-500">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center">
                            <div class="h-12 w-12 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-orange-600 font-semibold text-sm">RJ</span>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Robert Johnson</h3>
                                <p class="text-sm text-gray-600">Health Checkup</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-900">2:00 PM</div>
                            <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2 py-1 rounded-full">
                                Upcoming
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-video mr-2 text-gray-400"></i>
                            Video Call
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-clock mr-2 text-gray-400"></i>
                            60 minutes
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <button class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium">
                            View Details
                        </button>
                        <button class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium">
                            Reschedule
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function doctorAppointments() {
    return {
        showCalendarView: false,
        selectedDate: 'Today',
        selectedDateFormatted: new Date().toLocaleDateString('en-US', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        }),
        
        init() {
            this.loadAppointments();
        },

        loadAppointments() {
            // Load appointments for selected date
        },

        previousDay() {
            // Navigate to previous day
        },

        nextDay() {
            // Navigate to next day
        }
    }
}
</script>
@endsection