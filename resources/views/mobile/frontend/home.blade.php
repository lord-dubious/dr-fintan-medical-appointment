@extends('mobile.layouts.app')

@section('title', 'Dr. Fintan - Home')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Hero Section -->
    <section class="relative px-4 pt-8 pb-12">
        <div class="text-center">
            <!-- Logo -->
            <div class="mx-auto mb-6 h-20 w-20 rounded-full bg-gradient-to-br from-mobile-primary to-mobile-primary-dark flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-2xl">F</span>
            </div>
            
            <!-- Welcome Text -->
            <h1 class="text-3xl font-bold text-gray-900 mb-3">
                Welcome to Dr. Fintan
            </h1>
            <p class="text-lg text-gray-600 mb-8 max-w-sm mx-auto">
                Your trusted healthcare partner for quality medical consultations
            </p>
            
            <!-- CTA Buttons -->
            <div class="space-y-3">
                @guest
                    <a href="{{ route('appointment') }}" 
                       class="block w-full bg-mobile-primary text-white py-4 px-6 rounded-xl font-semibold text-lg shadow-lg active:scale-95 transition-transform">
                        Book Appointment
                    </a>
                    <a href="{{ route('login') }}" 
                       class="block w-full bg-white text-mobile-primary py-4 px-6 rounded-xl font-semibold text-lg border-2 border-mobile-primary shadow-md active:scale-95 transition-transform">
                        Sign In
                    </a>
                @else
                    @if(Auth::user()->role === 'patient')
                        <a href="{{ route('patient.book_appointment') }}" 
                           class="block w-full bg-mobile-primary text-white py-4 px-6 rounded-xl font-semibold text-lg shadow-lg active:scale-95 transition-transform">
                            Book New Appointment
                        </a>
                        <a href="{{ route('patient.dashboard') }}" 
                           class="block w-full bg-white text-mobile-primary py-4 px-6 rounded-xl font-semibold text-lg border-2 border-mobile-primary shadow-md active:scale-95 transition-transform">
                            My Dashboard
                        </a>
                    @elseif(Auth::user()->role === 'doctor')
                        <a href="{{ route('doctor.dashboard') }}" 
                           class="block w-full bg-mobile-primary text-white py-4 px-6 rounded-xl font-semibold text-lg shadow-lg active:scale-95 transition-transform">
                            Doctor Dashboard
                        </a>
                    @elseif(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                           class="block w-full bg-mobile-primary text-white py-4 px-6 rounded-xl font-semibold text-lg shadow-lg active:scale-95 transition-transform">
                            Admin Dashboard
                        </a>
                    @endif
                @endguest
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="px-4 py-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Our Services</h2>
        
        <div class="grid grid-cols-2 gap-4">
            <!-- Video Consultation -->
            <div class="bg-white rounded-xl p-6 shadow-md text-center">
                <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-video text-blue-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Video Consultation</h3>
                <p class="text-sm text-gray-600">Secure online consultations from anywhere</p>
            </div>
            
            <!-- Emergency Care -->
            <div class="bg-white rounded-xl p-6 shadow-md text-center">
                <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-ambulance text-red-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Emergency Care</h3>
                <p class="text-sm text-gray-600">24/7 emergency medical support</p>
            </div>
            
            <!-- Health Records -->
            <div class="bg-white rounded-xl p-6 shadow-md text-center">
                <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-file-medical text-green-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Health Records</h3>
                <p class="text-sm text-gray-600">Secure digital health records</p>
            </div>
            
            <!-- Prescription -->
            <div class="bg-white rounded-xl p-6 shadow-md text-center">
                <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-prescription text-purple-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Prescription</h3>
                <p class="text-sm text-gray-600">Digital prescription management</p>
            </div>
        </div>
    </section>

    <!-- Quick Stats -->
    @auth
    @if(Auth::user()->role === 'patient')
    <section class="px-4 py-8">
        <div class="bg-white rounded-xl p-6 shadow-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Overview</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-mobile-primary">{{ $appointmentCount ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Total Appointments</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $upcomingCount ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Upcoming</div>
                </div>
            </div>
        </div>
    </section>
    @endif
    @endauth

    <!-- Contact Section -->
    <section class="px-4 py-8">
        <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark rounded-xl p-6 text-white text-center">
            <h3 class="text-xl font-bold mb-2">Need Help?</h3>
            <p class="mb-4 opacity-90">Our support team is here to assist you</p>
            <a href="{{ route('contact') }}" 
               class="inline-block bg-white text-mobile-primary py-3 px-6 rounded-lg font-semibold active:scale-95 transition-transform">
                Contact Us
            </a>
        </div>
    </section>
</div>
@endsection
