@extends('mobile.layouts.app')

@section('title', 'Doctor Profile')

@section('content')
<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="px-4 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-900">My Profile</h1>
                <button onclick="toggleEditMode()" class="text-mobile-primary hover:text-mobile-primary-dark">
                    <i class="fas fa-edit text-lg"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="px-4 py-6 space-y-6">
        <!-- Profile Image Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex flex-col items-center">
                <div class="relative">
                    <img src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('assets/images/user_img.png') }}" 
                         alt="Profile" 
                         class="w-24 h-24 rounded-full object-cover border-4 border-mobile-primary">
                    <button class="absolute bottom-0 right-0 bg-mobile-primary text-white rounded-full p-2 shadow-lg">
                        <i class="fas fa-camera text-sm"></i>
                    </button>
                </div>
                <h2 class="mt-4 text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                <p class="text-gray-600">{{ $doctor->specializations[0] ?? 'General Practitioner' }}</p>
                <div class="flex items-center mt-2">
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-sm"></i>
                        @endfor
                    </div>
                    <span class="ml-2 text-sm text-gray-600">4.8 (124 reviews)</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-mobile-primary">{{ $stats['total_appointments'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Appointments</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-green-600">{{ $stats['completed_appointments'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Completed</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $doctor->experience_years ?? 0 }}</div>
                <div class="text-sm text-gray-600">Years Exp.</div>
            </div>
        </div>

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
            </div>
            <div class="p-4 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Email</span>
                    <span class="text-gray-900">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Phone</span>
                    <span class="text-gray-900">{{ $user->phone ?? 'Not provided' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">License Number</span>
                    <span class="text-gray-900">{{ $doctor->license_number ?? 'Not provided' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Consultation Fee</span>
                    <span class="text-gray-900">₦{{ number_format($doctor->consultation_fee ?? 0) }}</span>
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Professional Information</h3>
            </div>
            <div class="p-4 space-y-4">
                <div>
                    <span class="text-gray-600 block mb-2">Specializations</span>
                    <div class="flex flex-wrap gap-2">
                        @if($doctor->specializations)
                            @foreach($doctor->specializations as $specialization)
                                <span class="bg-mobile-primary/10 text-mobile-primary px-3 py-1 rounded-full text-sm">
                                    {{ $specialization }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-gray-500">No specializations added</span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <span class="text-gray-600 block mb-2">Qualifications</span>
                    <div class="space-y-1">
                        @if($doctor->qualifications)
                            @foreach($doctor->qualifications as $qualification)
                                <div class="text-gray-900">• {{ $qualification }}</div>
                            @endforeach
                        @else
                            <span class="text-gray-500">No qualifications added</span>
                        @endif
                    </div>
                </div>

                <div>
                    <span class="text-gray-600 block mb-2">Languages</span>
                    <div class="flex flex-wrap gap-2">
                        @if($doctor->languages)
                            @foreach($doctor->languages as $language)
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                    {{ $language }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-gray-500">No languages specified</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Working Hours -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Working Hours</h3>
            </div>
            <div class="p-4">
                @if($doctor->working_hours)
                    <div class="space-y-2">
                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 capitalize">{{ $day }}</span>
                                <span class="text-gray-900">
                                    @if(isset($doctor->working_hours[$day]) && $doctor->working_hours[$day]['enabled'])
                                        {{ $doctor->working_hours[$day]['start'] }} - {{ $doctor->working_hours[$day]['end'] }}
                                    @else
                                        <span class="text-gray-500">Closed</span>
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Working hours not configured</p>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <button class="w-full bg-mobile-primary text-white py-3 rounded-lg font-medium hover:bg-mobile-primary-dark transition-colors">
                <i class="fas fa-edit mr-2"></i>
                Edit Profile
            </button>
            
            <button class="w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                <i class="fas fa-calendar-alt mr-2"></i>
                Manage Schedule
            </button>
            
            <button class="w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                <i class="fas fa-cog mr-2"></i>
                Settings
            </button>
        </div>
    </div>
</div>

<script>
function toggleEditMode() {
    // Toggle edit mode functionality
    console.log('Edit mode toggled');
}
</script>
@endsection
