@props([
    'appointment',
    'showActions' => true,
    'compact' => false
])

@php
    $statusColors = [
        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
        'confirmed' => 'bg-green-100 text-green-800 border-green-200',
        'completed' => 'bg-blue-100 text-blue-800 border-blue-200',
        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
        'rescheduled' => 'bg-purple-100 text-purple-800 border-purple-200'
    ];
    
    $statusColor = $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
    
    $appointmentDate = \Carbon\Carbon::parse($appointment->appointment_date);
    $isToday = $appointmentDate->isToday();
    $isPast = $appointmentDate->isPast();
    $isUpcoming = $appointmentDate->isFuture();
@endphp

<div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden {{ $compact ? 'p-4' : 'p-6' }} active:scale-95 transition-transform">
    <!-- Header -->
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <!-- Date & Time -->
            <div class="flex items-center mb-2">
                <div class="h-10 w-10 bg-mobile-primary/10 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-calendar text-mobile-primary"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">
                        {{ $appointmentDate->format('M j, Y') }}
                        @if($isToday)
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full ml-2">Today</span>
                        @endif
                    </p>
                    <p class="text-sm text-gray-600">{{ $appointmentDate->format('g:i A') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Status Badge -->
        <span class="px-3 py-1 text-xs font-medium rounded-full border {{ $statusColor }}">
            {{ ucfirst($appointment->status) }}
        </span>
    </div>

    @if(!$compact)
    <!-- Doctor/Patient Info -->
    <div class="mb-4">
        @if(Auth::user()->role === 'patient')
            <!-- Show Doctor Info for Patients -->
            <div class="flex items-center">
                <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white font-bold">
                        {{ strtoupper(substr($appointment->doctor->name ?? 'Dr', 0, 2)) }}
                    </span>
                </div>
                <div>
                    <p class="font-medium text-gray-900">{{ $appointment->doctor->name ?? 'Dr. Fintan' }}</p>
                    <p class="text-sm text-gray-600">{{ $appointment->doctor->specialization ?? 'General Practitioner' }}</p>
                </div>
            </div>
        @else
            <!-- Show Patient Info for Doctors/Admin -->
            <div class="flex items-center">
                <div class="h-12 w-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white font-bold">
                        {{ strtoupper(substr($appointment->patient->name ?? $appointment->patient_name ?? 'P', 0, 2)) }}
                    </span>
                </div>
                <div>
                    <p class="font-medium text-gray-900">{{ $appointment->patient->name ?? $appointment->patient_name }}</p>
                    <p class="text-sm text-gray-600">Patient</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Appointment Details -->
    @if($appointment->symptoms || $appointment->notes)
    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
        @if($appointment->symptoms)
            <p class="text-sm text-gray-700 mb-1">
                <span class="font-medium">Symptoms:</span> {{ Str::limit($appointment->symptoms, 100) }}
            </p>
        @endif
        @if($appointment->notes)
            <p class="text-sm text-gray-700">
                <span class="font-medium">Notes:</span> {{ Str::limit($appointment->notes, 100) }}
            </p>
        @endif
    </div>
    @endif

    <!-- Payment Info -->
    @if($appointment->payment_status)
    <div class="mb-4 flex items-center justify-between p-3 bg-blue-50 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-credit-card text-blue-600 mr-2"></i>
            <span class="text-sm font-medium text-blue-900">Payment</span>
        </div>
        <span class="text-sm font-semibold {{ $appointment->payment_status === 'paid' ? 'text-green-600' : 'text-orange-600' }}">
            {{ ucfirst($appointment->payment_status) }}
        </span>
    </div>
    @endif
    @endif

    <!-- Actions -->
    @if($showActions)
    <div class="flex gap-2 pt-4 border-t border-gray-100">
        @if($appointment->status === 'confirmed' && $isToday)
            <!-- Join Call Button -->
            <a href="{{ route('consultation.call', $appointment->id) }}" 
               class="flex-1 bg-green-600 text-white py-3 px-4 rounded-lg font-medium text-center active:scale-95 transition-transform">
                <i class="fas fa-video mr-2"></i>Join Call
            </a>
        @elseif($appointment->status === 'pending')
            <!-- Pending Actions -->
            @if(Auth::user()->role === 'doctor' || Auth::user()->role === 'admin')
                <button class="flex-1 bg-green-600 text-white py-3 px-4 rounded-lg font-medium active:scale-95 transition-transform">
                    <i class="fas fa-check mr-2"></i>Confirm
                </button>
                <button class="flex-1 bg-red-600 text-white py-3 px-4 rounded-lg font-medium active:scale-95 transition-transform">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
            @else
                <button class="flex-1 bg-orange-600 text-white py-3 px-4 rounded-lg font-medium active:scale-95 transition-transform">
                    <i class="fas fa-edit mr-2"></i>Reschedule
                </button>
                <button class="flex-1 bg-red-600 text-white py-3 px-4 rounded-lg font-medium active:scale-95 transition-transform">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
            @endif
        @else
            <!-- View Details -->
            <button class="flex-1 bg-mobile-primary text-white py-3 px-4 rounded-lg font-medium active:scale-95 transition-transform">
                <i class="fas fa-eye mr-2"></i>View Details
            </button>
        @endif
    </div>
    @endif
</div>