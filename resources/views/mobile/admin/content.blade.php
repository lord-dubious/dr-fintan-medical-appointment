@extends('mobile.layouts.app')

@section('title', 'Content Management - Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="contentManagement()">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">Content Management</h1>
                <p class="text-blue-100 text-sm">Manage website content</p>
            </div>
            <button @click="showAddModal = true" class="p-2 bg-white/20 rounded-lg touch-target">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="px-4 py-6">
        <div class="space-y-4">
            <!-- Home Page Content -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-900">Home Page</h3>
                    <button class="text-mobile-primary text-sm font-medium">Edit</button>
                </div>
                <p class="text-sm text-gray-600">Manage homepage content and sections</p>
            </div>

            <!-- About Page Content -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-900">About Page</h3>
                    <button class="text-mobile-primary text-sm font-medium">Edit</button>
                </div>
                <p class="text-sm text-gray-600">Manage about page content</p>
            </div>

            <!-- Contact Page Content -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold text-gray-900">Contact Page</h3>
                    <button class="text-mobile-primary text-sm font-medium">Edit</button>
                </div>
                <p class="text-sm text-gray-600">Manage contact information</p>
            </div>
        </div>
    </div>
</div>

<script>
function contentManagement() {
    return {
        showAddModal: false,
        
        init() {
            // Initialize content management
        }
    }
}
</script>
@endsection