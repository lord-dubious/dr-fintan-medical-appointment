@props([
    'size' => 'md',
    'color' => 'primary',
    'text' => null,
    'overlay' => false
])

@php
    $sizeClasses = [
        'sm' => 'h-4 w-4',
        'md' => 'h-8 w-8',
        'lg' => 'h-12 w-12',
        'xl' => 'h-16 w-16'
    ];
    
    $colorClasses = [
        'primary' => 'text-mobile-primary',
        'white' => 'text-white',
        'gray' => 'text-gray-600',
        'blue' => 'text-blue-600',
        'green' => 'text-green-600',
        'red' => 'text-red-600'
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $colorClass = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

@if($overlay)
<!-- Full Screen Overlay -->
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-8 shadow-xl text-center max-w-sm mx-4">
        <div class="flex justify-center mb-4">
            <div class="{{ $sizeClass }} {{ $colorClass }} animate-spin">
                <svg class="w-full h-full" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
        @if($text)
            <p class="text-gray-700 font-medium">{{ $text }}</p>
        @endif
    </div>
</div>
@else
<!-- Inline Spinner -->
<div class="flex items-center justify-center {{ $attributes->get('class', '') }}">
    <div class="{{ $sizeClass }} {{ $colorClass }} animate-spin">
        <svg class="w-full h-full" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
    @if($text)
        <span class="ml-3 text-gray-700 font-medium">{{ $text }}</span>
    @endif
</div>
@endif
