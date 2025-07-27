@extends('mobile.layouts.app')

@section('title', 'My Profile - Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="userProfile()">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">My Profile</h1>
                <p class="text-blue-100 text-sm">Manage your personal information</p>
            </div>
            <button @click="editMode = !editMode" class="p-2 bg-white/20 rounded-lg touch-target">
                <i class="fas fa-edit"></i>
            </button>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="px-4 py-6">
        <!-- Profile Picture Section -->
        <div class="bg-white rounded-xl p-6 shadow-sm mb-6">
            <div class="text-center">
                <div class="relative inline-block">
                    <div class="h-24 w-24 bg-gray-300 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user text-gray-600 text-2xl"></i>
                    </div>
                    <button class="absolute bottom-0 right-0 h-8 w-8 bg-mobile-primary text-white rounded-full flex items-center justify-center">
                        <i class="fas fa-camera text-xs"></i>
                    </button>
                </div>
                <h2 class="text-xl font-bold text-gray-900">{{ Auth::user()->name ?? 'Patient Name' }}</h2>
                <p class="text-gray-600">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="bg-white rounded-xl p-4 shadow-sm mb-6">
            <h3 class="font-semibold text-gray-900 mb-4">Personal Information</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" 
                           :disabled="!editMode"
                           :class="editMode ? 'border-mobile-primary' : 'border-gray-200 bg-gray-50'"
                           class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                           value="{{ Auth::user()->name ?? '' }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" 
                           :disabled="!editMode"
                           :class="editMode ? 'border-mobile-primary' : 'border-gray-200 bg-gray-50'"
                           class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                           value="{{ Auth::user()->email }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" 
                           :disabled="!editMode"
                           :class="editMode ? 'border-mobile-primary' : 'border-gray-200 bg-gray-50'"
                           class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                           value="{{ Auth::user()->patient->mobile ?? '' }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                    <input type="date" 
                           :disabled="!editMode"
                           :class="editMode ? 'border-mobile-primary' : 'border-gray-200 bg-gray-50'"
                           class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                           value="{{ Auth::user()->patient->date_of_birth ?? '' }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                    <select :disabled="!editMode"
                            :class="editMode ? 'border-mobile-primary' : 'border-gray-200 bg-gray-50'"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div x-show="editMode" class="mt-6 flex space-x-3">
                <button @click="saveProfile()" 
                        class="flex-1 bg-mobile-primary text-white py-3 px-6 rounded-xl font-semibold">
                    Save Changes
                </button>
                <button @click="editMode = false" 
                        class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-semibold">
                    Cancel
                </button>
            </div>
        </div>

        <!-- Medical Information -->
        <div class="bg-white rounded-xl p-4 shadow-sm mb-6">
            <h3 class="font-semibold text-gray-900 mb-4">Medical Information</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Blood Type</label>
                    <select :disabled="!editMode"
                            :class="editMode ? 'border-mobile-primary' : 'border-gray-200 bg-gray-50'"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary">
                        <option value="">Select Blood Type</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Allergies</label>
                    <textarea :disabled="!editMode"
                              :class="editMode ? 'border-mobile-primary' : 'border-gray-200 bg-gray-50'"
                              class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                              rows="3"
                              placeholder="List any known allergies..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Medications</label>
                    <textarea :disabled="!editMode"
                              :class="editMode ? 'border-mobile-primary' : 'border-gray-200 bg-gray-50'"
                              class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                              rows="3"
                              placeholder="List current medications..."></textarea>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <h3 class="font-semibold text-gray-900 mb-4">Emergency Contact</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Name</label>
                    <input type="text" 
                           :disabled="!editMode"
                           :class="editMode ? 'border-mobile-primary' : 'border-gray-200 bg-gray-50'"
                           class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                           placeholder="Emergency contact name">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
                    <input type="tel" 
                           :disabled="!editMode"
                           :class="editMode ? 'border-mobile-primary' : 'border-gray-200 bg-gray-50'"
                           class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                           placeholder="Emergency contact phone">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Relationship</label>
                    <input type="text" 
                           :disabled="!editMode"
                           :class="editMode ? 'border-mobile-primary' : 'border-gray-200 bg-gray-50'"
                           class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"
                           placeholder="Relationship to patient">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function userProfile() {
    return {
        editMode: false,
        
        init() {
            // Initialize profile data
        },

        saveProfile() {
            // Save profile changes
            this.editMode = false;
            // Show success message
        }
    }
}
</script>
@endsection
