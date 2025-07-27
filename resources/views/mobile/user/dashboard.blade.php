@extends('mobile.layouts.app')

@section('title', 'Dashboard - Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">Welcome back!</h1>
                <p class="opacity-90">{{ Auth::user()->name }}</p>
            </div>
            <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <section class="px-4 py-6">
        <div class="grid grid-cols-2 gap-4">
            <!-- Total Appointments -->
            <div class="bg-white rounded-xl p-4 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalAppointments ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Total Appointments</p>
                    </div>
                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-check text-blue-600"></i>
                    </div>
                </div>
            </div>
            
            <!-- Upcoming -->
            <div class="bg-white rounded-xl p-4 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ $upcomingAppointments ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Upcoming</p>
                    </div>
                    <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-green-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="px-4 py-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
        
        <div class="grid grid-cols-2 gap-4">
            <!-- Book Appointment -->
            <a href="{{ route('patient.book_appointment') }}" 
               class="bg-mobile-primary text-white rounded-xl p-6 text-center active:scale-95 transition-transform">
                <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-plus text-xl"></i>
                </div>
                <p class="font-semibold">Book Appointment</p>
            </a>
            
            <!-- Video Call -->
            <a href="#" 
               class="bg-green-600 text-white rounded-xl p-6 text-center active:scale-95 transition-transform">
                <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-video text-xl"></i>
                </div>
                <p class="font-semibold">Video Call</p>
            </a>
            
            <!-- Health Records -->
            <a href="#" 
               class="bg-purple-600 text-white rounded-xl p-6 text-center active:scale-95 transition-transform">
                <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-file-medical text-xl"></i>
                </div>
                <p class="font-semibold">Health Records</p>
            </a>
            
            <!-- Prescriptions -->
            <a href="#" 
               class="bg-orange-600 text-white rounded-xl p-6 text-center active:scale-95 transition-transform">
                <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-prescription text-xl"></i>
                </div>
                <p class="font-semibold">Prescriptions</p>
            </a>
        </div>
    </section>

    <!-- Recent Appointments -->
    <section class="px-4 py-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Recent Appointments</h2>
            <a href="{{ route('patient.appointment') }}" class="text-mobile-primary font-medium text-sm">
                View All
            </a>
        </div>
        
        @if(isset($recentAppointments) && $recentAppointments->count() > 0)
            <div class="space-y-4">
                @foreach($recentAppointments->take(3) as $appointment)
                    <x-mobile.appointment-card :appointment="$appointment" :compact="true" />
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl p-8 text-center shadow-md">
                <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-plus text-gray-400 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">No Appointments Yet</h3>
                <p class="text-gray-600 mb-4">Book your first appointment with Dr. Fintan</p>
                <a href="{{ route('patient.book_appointment') }}" 
                   class="inline-block bg-mobile-primary text-white py-3 px-6 rounded-lg font-medium active:scale-95 transition-transform">
                    Book Now
                </a>
            </div>
        @endif
    </section>

    <!-- Health Tips -->
    <section class="px-4 py-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Health Tips</h2>
        
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <div class="flex items-start">
                <div class="h-10 w-10 bg-white/20 rounded-full flex items-center justify-center mr-4 mt-1">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Stay Hydrated</h3>
                    <p class="text-sm opacity-90">Drink at least 8 glasses of water daily to maintain optimal health and energy levels.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Emergency Contact -->
    <section class="px-4 py-6">
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <div class="flex items-center">
                <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-phone text-red-600 text-lg"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-red-900 mb-1">Emergency Contact</h3>
                    <p class="text-sm text-red-700">For medical emergencies, call 999</p>
                </div>
                <a href="tel:999" 
                   class="bg-red-600 text-white py-2 px-4 rounded-lg font-medium active:scale-95 transition-transform">
                    Call
                </a>
            </div>
        </div>
    </section>
</div>
@endsection