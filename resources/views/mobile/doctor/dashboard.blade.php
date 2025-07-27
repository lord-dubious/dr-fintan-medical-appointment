@extends('mobile.layouts.app')

@section('title', 'Doctor Dashboard - Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">Good {{ date('H') < 12 ? 'Morning' : (date('H') < 18 ? 'Afternoon' : 'Evening') }}!</h1>
                <p class="opacity-90">Dr. {{ Auth::user()->name }}</p>
            </div>
            <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fas fa-user-md text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Today's Overview -->
    <section class="px-4 py-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Today's Overview</h2>
        
        <div class="grid grid-cols-2 gap-4">
            <!-- Today's Appointments -->
            <div class="bg-white rounded-xl p-4 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-blue-600">{{ $todayAppointments ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Today's Appointments</p>
                    </div>
                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-day text-blue-600"></i>
                    </div>
                </div>
            </div>
            
            <!-- Pending Reviews -->
            <div class="bg-white rounded-xl p-4 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-orange-600">{{ $pendingReviews ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Pending Reviews</p>
                    </div>
                    <div class="h-10 w-10 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-orange-600"></i>
                    </div>
                </div>
            </div>
            
            <!-- Total Patients -->
            <div class="bg-white rounded-xl p-4 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ $totalPatients ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Total Patients</p>
                    </div>
                    <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-green-600"></i>
                    </div>
                </div>
            </div>
            
            <!-- This Month -->
            <div class="bg-white rounded-xl p-4 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-purple-600">{{ $monthlyAppointments ?? 0 }}</p>
                        <p class="text-sm text-gray-600">This Month</p>
                    </div>
                    <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-line text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="px-4 py-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
        
        <div class="grid grid-cols-2 gap-4">
            <!-- View Schedule -->
            <a href="{{ route('doctor.appointment') }}" 
               class="bg-blue-600 text-white rounded-xl p-6 text-center active:scale-95 transition-transform">
                <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <p class="font-semibold">View Schedule</p>
            </a>
            
            <!-- Patient Records -->
            <a href="#" 
               class="bg-green-600 text-white rounded-xl p-6 text-center active:scale-95 transition-transform">
                <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-file-medical text-xl"></i>
                </div>
                <p class="font-semibold">Patient Records</p>
            </a>
            
            <!-- Video Consultations -->
            <a href="#" 
               class="bg-purple-600 text-white rounded-xl p-6 text-center active:scale-95 transition-transform">
                <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-video text-xl"></i>
                </div>
                <p class="font-semibold">Video Calls</p>
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

    <!-- Today's Schedule -->
    <section class="px-4 py-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Today's Schedule</h2>
            <span class="text-sm text-gray-600">{{ now()->format('M j, Y') }}</span>
        </div>
        
        @if(isset($todaySchedule) && $todaySchedule->count() > 0)
            <div class="space-y-3">
                @foreach($todaySchedule->take(4) as $appointment)
                    <div class="bg-white rounded-xl p-4 shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">
                                        {{ strtoupper(substr($appointment->patient->name ?? 'P', 0, 2)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $appointment->patient->name ?? $appointment->patient_name }}</p>
                                    <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('g:i A') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($appointment->status === 'confirmed' && \Carbon\Carbon::parse($appointment->appointment_date)->isToday())
                                    <a href="{{ route('consultation.call', $appointment->id) }}" 
                                       class="bg-green-600 text-white py-2 px-3 rounded-lg text-sm font-medium active:scale-95 transition-transform">
                                        <i class="fas fa-video mr-1"></i>Join
                                    </a>
                                @endif
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $appointment->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($todaySchedule->count() > 4)
                <div class="text-center mt-4">
                    <a href="{{ route('doctor.appointment') }}" 
                       class="text-mobile-primary font-medium">
                        View All ({{ $todaySchedule->count() }} total)
                    </a>
                </div>
            @endif
        @else
            <div class="bg-white rounded-xl p-8 text-center shadow-md">
                <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-check text-gray-400 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">No Appointments Today</h3>
                <p class="text-gray-600">Enjoy your free day!</p>
            </div>
        @endif
    </section>

    <!-- Recent Activity -->
    <section class="px-4 py-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Recent Activity</h2>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">New patient registration</p>
                        <p class="text-xs text-gray-500">2 hours ago</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="h-8 w-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-video text-green-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Video consultation completed</p>
                        <p class="text-xs text-gray-500">4 hours ago</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-prescription text-purple-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">Prescription issued</p>
                        <p class="text-xs text-gray-500">Yesterday</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
