{{-- Professional Mobile Toast Component using Flowbite --}}
@props([
    'type' => 'info',
    'position' => 'top-right',
    'duration' => 5000,
    'dismissible' => true,
    'icon' => true
])

@php
$toastId = 'toast_' . uniqid();

$types = [
    'success' => [
        'bg' => 'bg-green-100 dark:bg-green-800',
        'text' => 'text-green-500 dark:text-green-200',
        'icon' => 'fas fa-check-circle'
    ],
    'error' => [
        'bg' => 'bg-red-100 dark:bg-red-800',
        'text' => 'text-red-500 dark:text-red-200',
        'icon' => 'fas fa-times-circle'
    ],
    'warning' => [
        'bg' => 'bg-orange-100 dark:bg-orange-700',
        'text' => 'text-orange-500 dark:text-orange-200',
        'icon' => 'fas fa-exclamation-triangle'
    ],
    'info' => [
        'bg' => 'bg-blue-100 dark:bg-blue-800',
        'text' => 'text-blue-500 dark:text-blue-200',
        'icon' => 'fas fa-info-circle'
    ]
];

$positions = [
    'top-left' => 'top-4 left-4',
    'top-right' => 'top-4 right-4',
    'top-center' => 'top-4 left-1/2 transform -translate-x-1/2',
    'bottom-left' => 'bottom-4 left-4',
    'bottom-right' => 'bottom-4 right-4',
    'bottom-center' => 'bottom-4 left-1/2 transform -translate-x-1/2'
];

$typeConfig = $types[$type] ?? $types['info'];
$positionClass = $positions[$position] ?? $positions['top-right'];
@endphp

<div id="{{ $toastId }}" 
     class="fixed {{ $positionClass }} z-50 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
     x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-2"
     x-init="setTimeout(() => show = false, {{ $duration }})"
     role="alert">
    
    @if($icon)
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 {{ $typeConfig['text'] }} {{ $typeConfig['bg'] }} rounded-lg">
            <i class="{{ $typeConfig['icon'] }}"></i>
        </div>
    @endif
    
    <div class="ml-3 text-sm font-normal">
        {{ $slot }}
    </div>
    
    @if($dismissible)
        <button type="button" 
                class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 touch-target"
                @click="show = false"
                aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    @endif
</div>

<script>
// Toast utility functions
window.showToast = function(message, type = 'info', duration = 5000) {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    
    const toast = document.createElement('div');
    toast.innerHTML = `
        <x-mobile.components.ui.toast type="${type}" :duration="${duration}">
            ${message}
        </x-mobile.components.ui.toast>
    `;
    
    toastContainer.appendChild(toast.firstElementChild);
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'fixed top-4 right-4 z-50 space-y-2';
    document.body.appendChild(container);
    return container;
}
</script>
