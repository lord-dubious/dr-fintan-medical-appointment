@extends('user.layout')

@section('title', 'My Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">My Profile</h1>
        <p class="text-gray-600">Manage your personal information and medical details</p>
    </div>

    <!-- Profile Tabs -->
    <div class="bg-white rounded-lg shadow-lg">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button class="tab-button active py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600" data-tab="basic">
                    <i class="fas fa-user mr-2"></i>Basic Information
                </button>
                <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="medical">
                    <i class="fas fa-heartbeat mr-2"></i>Medical Information
                </button>
                <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="emergency">
                    <i class="fas fa-phone mr-2"></i>Emergency Contact
                </button>
                <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="security">
                    <i class="fas fa-lock mr-2"></i>Security
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Basic Information Tab -->
            <div id="basic-tab" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Profile Image -->
                    <div class="lg:col-span-1">
                        <div class="text-center">
                            <div class="relative inline-block">
                                <img id="profile-image" 
                                     src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-avatar.png') }}" 
                                     alt="Profile Image" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                                <button id="change-image-btn" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 hover:bg-blue-700">
                                    <i class="fas fa-camera text-sm"></i>
                                </button>
                            </div>
                            <input type="file" id="profile-image-input" accept="image/*" class="hidden">
                            <p class="mt-2 text-sm text-gray-600">Click the camera icon to change your photo</p>
                        </div>
                    </div>

                    <!-- Basic Info Form -->
                    <div class="lg:col-span-2">
                        <form id="basic-info-form">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" id="name" name="name" value="{{ $user->name }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" id="email" name="email" value="{{ $user->email }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" value="{{ $user->phone }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '' }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                    <textarea id="address" name="address" rows="3" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $user->address }}</textarea>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                    <textarea id="bio" name="bio" rows="4" placeholder="Tell us a bit about yourself..." 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $user->bio }}</textarea>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <i class="fas fa-save mr-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Medical Information Tab -->
            <div id="medical-tab" class="tab-content hidden">
                <form id="medical-info-form">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="blood_type" class="block text-sm font-medium text-gray-700 mb-2">Blood Type</label>
                            <select id="blood_type" name="blood_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Blood Type</option>
                                <option value="A+" {{ $patient && $patient->blood_type == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ $patient && $patient->blood_type == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ $patient && $patient->blood_type == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ $patient && $patient->blood_type == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ $patient && $patient->blood_type == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ $patient && $patient->blood_type == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ $patient && $patient->blood_type == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ $patient && $patient->blood_type == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="allergies" class="block text-sm font-medium text-gray-700 mb-2">Allergies</label>
                            <textarea id="allergies" name="allergies" rows="3" placeholder="List any allergies you have..." 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $patient->allergies ?? '' }}</textarea>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="current_medications" class="block text-sm font-medium text-gray-700 mb-2">Current Medications</label>
                            <textarea id="current_medications" name="current_medications" rows="3" placeholder="List your current medications..." 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $patient->current_medications ?? '' }}</textarea>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>Save Medical Information
                        </button>
                    </div>
                </form>
            </div>

            <!-- Emergency Contact Tab -->
            <div id="emergency-tab" class="tab-content hidden">
                <form id="emergency-contact-form">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="emergency_name" class="block text-sm font-medium text-gray-700 mb-2">Contact Name</label>
                            <input type="text" id="emergency_name" name="emergency_contact[name]" 
                                   value="{{ $patient && $patient->emergency_contact ? $patient->emergency_contact['name'] ?? '' : '' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="emergency_phone" class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
                            <input type="tel" id="emergency_phone" name="emergency_contact[phone]" 
                                   value="{{ $patient && $patient->emergency_contact ? $patient->emergency_contact['phone'] ?? '' : '' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="emergency_relationship" class="block text-sm font-medium text-gray-700 mb-2">Relationship</label>
                            <input type="text" id="emergency_relationship" name="emergency_contact[relationship]" 
                                   value="{{ $patient && $patient->emergency_contact ? $patient->emergency_contact['relationship'] ?? '' : '' }}" 
                                   placeholder="e.g., Spouse, Parent, Sibling" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-save mr-2"></i>Save Emergency Contact
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Tab -->
            <div id="security-tab" class="tab-content hidden">
                <form id="password-form">
                    @csrf
                    <div class="max-w-md">
                        <div class="mb-6">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                            <input type="password" id="current_password" name="current_password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div class="mb-6">
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                            <input type="password" id="new_password" name="new_password" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div class="mb-6">
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <i class="fas fa-key mr-2"></i>Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
<div id="message-container" class="fixed top-4 right-4 z-50"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabName = button.getAttribute('data-tab');
            
            // Update button states
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
                btn.classList.add('border-transparent', 'text-gray-500');
            });
            button.classList.add('active', 'border-blue-500', 'text-blue-600');
            button.classList.remove('border-transparent', 'text-gray-500');
            
            // Update content visibility
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(tabName + '-tab').classList.remove('hidden');
        });
    });

    // Profile image upload
    document.getElementById('change-image-btn').addEventListener('click', () => {
        document.getElementById('profile-image-input').click();
    });

    document.getElementById('profile-image-input').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const formData = new FormData();
            formData.append('profile_image', e.target.files[0]);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('/profile/profile-image', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('profile-image').src = data.image_url;
                    showMessage(data.message, 'success');
                } else {
                    showMessage(data.message || 'Failed to upload image', 'error');
                }
            })
            .catch(error => {
                showMessage('Failed to upload image', 'error');
            });
        }
    });

    // Form submissions
    document.getElementById('basic-info-form').addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm('/profile/basic-info', new FormData(this), 'Basic information updated successfully!');
    });

    document.getElementById('medical-info-form').addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm('/profile/patient-info', new FormData(this), 'Medical information updated successfully!');
    });

    document.getElementById('emergency-contact-form').addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm('/profile/patient-info', new FormData(this), 'Emergency contact updated successfully!');
    });

    document.getElementById('password-form').addEventListener('submit', function(e) {
        e.preventDefault();
        submitForm('/profile/password', new FormData(this), 'Password updated successfully!');
    });

    function submitForm(url, formData, successMessage) {
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(successMessage, 'success');
            } else {
                showMessage(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => {
            showMessage('An error occurred', 'error');
        });
    }

    function showMessage(message, type) {
        const container = document.getElementById('message-container');
        const messageDiv = document.createElement('div');
        messageDiv.className = `p-4 rounded-lg shadow-lg mb-4 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
        messageDiv.innerHTML = `
            <div class="flex items-center justify-between">
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        container.appendChild(messageDiv);

        setTimeout(() => {
            if (messageDiv.parentElement) {
                messageDiv.remove();
            }
        }, 5000);
    }
});
</script>
@endsection
