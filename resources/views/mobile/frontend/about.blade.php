@extends('mobile.layouts.app')

@section('title', 'About Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-8">
        <div class="text-center">
            <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-white/20 flex items-center justify-center">
                <i class="fas fa-user-md text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold mb-2">About Dr. Fintan</h1>
            <p class="opacity-90">Your trusted healthcare professional</p>
        </div>
    </div>

    <!-- Doctor Profile -->
    <section class="px-4 py-6">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="h-16 w-16 bg-gradient-to-br from-mobile-primary to-mobile-primary-dark rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">
                        DF
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Dr. Fintan</h2>
                        <p class="text-gray-600">General Practitioner</p>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                                <i class="fas fa-star text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-600 ml-2">5.0 (150+ reviews)</span>
                        </div>
                    </div>
                </div>
                
                <p class="text-gray-700 leading-relaxed">
                    Dr. Fintan is a dedicated healthcare professional with over 15 years of experience in general medicine. 
                    Committed to providing compassionate, comprehensive care to patients of all ages.
                </p>
            </div>
        </div>
    </section>

    <!-- Qualifications -->
    <section class="px-4 py-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Qualifications & Experience</h2>
        
        <div class="space-y-4">
            <div class="bg-white rounded-xl p-4 shadow-md">
                <div class="flex items-start">
                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center mr-3 mt-1">
                        <i class="fas fa-graduation-cap text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Medical Degree</h3>
                        <p class="text-gray-600 text-sm">University College Dublin - 2008</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-4 shadow-md">
                <div class="flex items-start">
                    <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center mr-3 mt-1">
                        <i class="fas fa-certificate text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Board Certification</h3>
                        <p class="text-gray-600 text-sm">Irish Medical Council - 2010</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-4 shadow-md">
                <div class="flex items-start">
                    <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center mr-3 mt-1">
                        <i class="fas fa-award text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Specialization</h3>
                        <p class="text-gray-600 text-sm">Family Medicine & Preventive Care</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section class="px-4 py-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Services Offered</h2>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="grid grid-cols-1 gap-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span class="text-gray-700">General Health Consultations</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span class="text-gray-700">Preventive Care & Screenings</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span class="text-gray-700">Chronic Disease Management</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span class="text-gray-700">Video Consultations</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span class="text-gray-700">Health Education & Counseling</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span class="text-gray-700">Prescription Management</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Info -->
    <section class="px-4 py-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Contact Information</h2>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-phone text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Phone</p>
                        <p class="text-gray-600">+353 1 234 5678</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-envelope text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Email</p>
                        <p class="text-gray-600">info@drfintan.ie</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-purple-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Location</p>
                        <p class="text-gray-600">Dublin, Ireland</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="px-4 py-8">
        <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark rounded-xl p-6 text-white text-center">
            <h3 class="text-xl font-bold mb-2">Ready to Get Started?</h3>
            <p class="mb-4 opacity-90">Book your consultation today</p>
            <a href="{{ route('appointment') }}" 
               class="inline-block bg-white text-mobile-primary py-3 px-6 rounded-lg font-semibold active:scale-95 transition-transform">
                Book Appointment
            </a>
        </div>
    </section>
</div>
@endsection