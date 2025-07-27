@extends('mobile.layouts.app')

@section('title', 'My Appointments - Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="userAppointments()">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">My Appointments</h1>
                <p class="text-blue-100 text-sm">View and manage your appointments</p>
            </div>
            <a href="{{ route('mobile.user.book_appointment') }}" class="p-2 bg-white/20 rounded-lg touch-target">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white px-4 py-3 border-b">
        <div class="flex space-x-1">
            <button @click="activeTab = 'upcoming'" 
                    :class="activeTab === 'upcoming' ? 'bg-mobile-primary text-white' : 'bg-gray-100 text-gray-600'"
                    class="flex-1 py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                Upcoming
            </button>
            <button @click="activeTab = 'past'" 
                    :class="activeTab === 'past' ? 'bg-mobile-primary text-white' : 'bg-gray-100 text-gray-600'"
                    class="flex-1 py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                Past
            </button>
            <button @click="activeTab = 'cancelled'" 
                    :class="activeTab === 'cancelled' ? 'bg-mobile-primary text-white' : 'bg-gray-100 text-gray-600'"
                    class="flex-1 py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                Cancelled
            </button>
        </div>
    </div>

    <!-- Appointments List -->
    <div class="px-4 py-6">
        <div class="space-y-4">
            <!-- Sample Appointment Card -->
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-green-500">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center">
                        <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-md text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Dr. Fintan Ekochin</h3>
                            <p class="text-sm text-gray-600">General Consultation</p>
                        </div>
                    </div>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                        Confirmed
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-calendar mr-2 text-gray-400"></i>
                        Dec 25, 2024
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                        10:30 AM
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-video mr-2 text-gray-400"></i>
                        Video Call
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-euro-sign mr-2 text-gray-400"></i>
                        €50
                    </div>
                </div>

                <div class="flex space-x-2">
                    <button class="flex-1 bg-mobile-primary text-white py-2 px-4 rounded-lg text-sm font-medium">
                        Join Call
                    </button>
                    <button class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium">
                        Reschedule
                    </button>
                </div>
            </div>

            <!-- Another Appointment Card -->
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-blue-500">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center">
                        <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-md text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Dr. Fintan Ekochin</h3>
                            <p class="text-sm text-gray-600">Follow-up Consultation</p>
                        </div>
                    </div>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                        Pending
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-calendar mr-2 text-gray-400"></i>
                        Dec 28, 2024
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-clock mr-2 text-gray-400"></i>
                        2:00 PM
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-hospital mr-2 text-gray-400"></i>
                        In-Person
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-euro-sign mr-2 text-gray-400"></i>
                        €35
                    </div>
                </div>

                <div class="flex space-x-2">
                    <button class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium">
                        Cancel
                    </button>
                    <button class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium">
                        Reschedule
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function userAppointments() {
    return {
        activeTab: 'upcoming',
        appointments: [],
        
        init() {
            this.loadAppointments();
        },

        loadAppointments() {
            // Load appointments based on active tab
            // This would typically fetch from an API
        }
    }
}
</script>
@endsection