{{-- Professional Mobile Dropdown Component using Flowbite --}}
@props([
    'trigger' => 'click',
    'placement' => 'bottom',
    'offset' => 10,
    'arrow' => false,
    'autoClose' => true
])

@php
$dropdownId = 'dropdown_' . uniqid();
$triggerId = 'trigger_' . uniqid();

$placements = [
    'top' => 'bottom-full mb-2',
    'bottom' => 'top-full mt-2',
    'left' => 'right-full mr-2',
    'right' => 'left-full ml-2'
];

$dropdownClasses = collect([
    'absolute z-50 bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600',
    'min-w-44 max-w-sm',
    $placements[$placement] ?? $placements['bottom'],
    'hidden'
])->implode(' ');
@endphp

<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <!-- Trigger -->
    <div id="{{ $triggerId }}" 
         @if($trigger === 'click') @click="open = !open" @endif
         @if($trigger === 'hover') @mouseenter="open = true" @mouseleave="open = false" @endif
         class="cursor-pointer">
        {{ $trigger }}
    </div>
    
    <!-- Dropdown menu -->
    <div id="{{ $dropdownId }}"
         class="{{ $dropdownClasses }}"
         x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95">
        
        @if($arrow)
            <div class="absolute -top-1 left-4 w-2 h-2 bg-white dark:bg-gray-700 rotate-45 border-l border-t border-gray-200 dark:border-gray-600"></div>
        @endif
        
        <div class="py-2 text-sm text-gray-700 dark:text-gray-200">
            {{ $slot }}
        </div>
    </div>
</div>