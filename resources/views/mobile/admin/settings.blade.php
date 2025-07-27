@extends('mobile.layouts.app')

@section('title', 'Settings - Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="settingsManagement()">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">Settings</h1>
                <p class="text-blue-100 text-sm">System configuration</p>
            </div>
        </div>
    </div>

    <!-- Settings Sections -->
    <div class="px-4 py-6">
        <div class="space-y-4">
            <!-- Site Settings -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-cog text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Site Settings</h3>
                            <p class="text-sm text-gray-600">General site configuration</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </div>
            </div>

            <!-- Payment Settings -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-credit-card text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Payment Settings</h3>
                            <p class="text-sm text-gray-600">Configure payment methods</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </div>
            </div>

            <!-- Email Settings -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Email Settings</h3>
                            <p class="text-sm text-gray-600">Email configuration</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-shield-alt text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Security Settings</h3>
                            <p class="text-sm text-gray-600">Security configuration</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function settingsManagement() {
    return {
        init() {
            // Initialize settings management
        }
    }
}
</script>
@endsection