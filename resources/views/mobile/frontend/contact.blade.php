@extends('mobile.layouts.app')

@section('title', 'Contact Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-8">
        <div class="text-center">
            <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-white/20 flex items-center justify-center">
                <i class="fas fa-envelope text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold mb-2">Contact Us</h1>
            <p class="opacity-90">We're here to help you</p>
        </div>
    </div>

    <!-- Quick Contact Options -->
    <section class="px-4 py-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Get in Touch</h2>
        
        <div class="grid grid-cols-1 gap-4">
            <!-- Phone -->
            <a href="tel:+35312345678" class="bg-white rounded-xl p-4 shadow-md active:scale-95 transition-transform">
                <div class="flex items-center">
                    <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-phone text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Call Us</h3>
                        <p class="text-gray-600">+353 1 234 5678</p>
                        <p class="text-sm text-blue-600">Tap to call</p>
                    </div>
                </div>
            </a>
            
            <!-- Email -->
            <a href="mailto:info@drfintan.ie" class="bg-white rounded-xl p-4 shadow-md active:scale-95 transition-transform">
                <div class="flex items-center">
                    <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-envelope text-green-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Email Us</h3>
                        <p class="text-gray-600">info@drfintan.ie</p>
                        <p class="text-sm text-green-600">Tap to email</p>
                    </div>
                </div>
            </a>
            
            <!-- Emergency -->
            <a href="tel:999" class="bg-red-50 border border-red-200 rounded-xl p-4 active:scale-95 transition-transform">
                <div class="flex items-center">
                    <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-ambulance text-red-600 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-red-900">Emergency</h3>
                        <p class="text-red-700">Call 999 for emergencies</p>
                        <p class="text-sm text-red-600">24/7 Emergency Services</p>
                    </div>
                </div>
            </a>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="px-4 py-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Send us a Message</h2>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="#" method="POST" class="space-y-4">
                @csrf
                
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary transition-colors">
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary transition-colors">
                </div>
                
                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" 
                           id="phone" 
                           name="phone"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary transition-colors">
                </div>
                
                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                    <select id="subject" 
                            name="subject" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary transition-colors">
                        <option value="">Select a subject</option>
                        <option value="appointment">Appointment Inquiry</option>
                        <option value="medical">Medical Question</option>
                        <option value="billing">Billing Question</option>
                        <option value="technical">Technical Support</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea id="message" 
                              name="message" 
                              rows="4" 
                              required
                              placeholder="Please describe how we can help you..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary transition-colors resize-none"></textarea>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-mobile-primary text-white py-4 px-6 rounded-lg font-semibold text-lg shadow-lg active:scale-95 transition-transform">
                    Send Message
                </button>
            </form>
        </div>
    </section>

    <!-- Office Hours -->
    <section class="px-4 py-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Office Hours</h2>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-900">Monday - Friday</span>
                    <span class="text-gray-600">9:00 AM - 6:00 PM</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-900">Saturday</span>
                    <span class="text-gray-600">9:00 AM - 2:00 PM</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="font-medium text-gray-900">Sunday</span>
                    <span class="text-red-600">Closed</span>
                </div>
            </div>
            
            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    Emergency consultations available 24/7 via video call
                </p>
            </div>
        </div>
    </section>

    <!-- Location -->
    <section class="px-4 py-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Location</h2>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-start">
                <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center mr-4 mt-1">
                    <i class="fas fa-map-marker-alt text-purple-600 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-1">Dr. Fintan Medical Practice</h3>
                    <p class="text-gray-600 mb-2">
                        123 Medical Centre<br>
                        Dublin 2, Ireland<br>
                        D02 XY34
                    </p>
                    <a href="https://maps.google.com/?q=Dublin+Medical+Centre" 
                       target="_blank"
                       class="inline-flex items-center text-mobile-primary font-medium">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        View on Maps
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Link -->
    <section class="px-4 py-8">
        <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark rounded-xl p-6 text-white text-center">
            <h3 class="text-xl font-bold mb-2">Have Questions?</h3>
            <p class="mb-4 opacity-90">Check our frequently asked questions</p>
            <a href="#" 
               class="inline-block bg-white text-mobile-primary py-3 px-6 rounded-lg font-semibold active:scale-95 transition-transform">
                View FAQ
            </a>
        </div>
    </section>
</div>
@endsection