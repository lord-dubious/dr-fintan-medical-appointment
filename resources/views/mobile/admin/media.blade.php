@extends('mobile.layouts.app')

@section('title', 'Media Library - Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="mediaLibrary()">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">Media Library</h1>
                <p class="text-blue-100 text-sm">Manage images and files</p>
            </div>
            <button @click="showUploadModal = true" class="p-2 bg-white/20 rounded-lg touch-target">
                <i class="fas fa-upload"></i>
            </button>
        </div>
    </div>

    <!-- Media Grid -->
    <div class="px-4 py-6">
        <div class="grid grid-cols-2 gap-4">
            <!-- Sample Media Items -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                <div class="aspect-square bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-image text-gray-400 text-2xl"></i>
                </div>
                <div class="p-3">
                    <p class="text-sm font-medium text-gray-900 truncate">sample-image.jpg</p>
                    <p class="text-xs text-gray-500">2.3 MB</p>
                </div>
            </div>

            <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                <div class="aspect-square bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-file-pdf text-gray-400 text-2xl"></i>
                </div>
                <div class="p-3">
                    <p class="text-sm font-medium text-gray-900 truncate">document.pdf</p>
                    <p class="text-xs text-gray-500">1.8 MB</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function mediaLibrary() {
    return {
        showUploadModal: false,
        
        init() {
            // Initialize media library
        }
    }
}
</script>
@endsection
