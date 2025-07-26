{{-- Dark Mode Toggle Component --}}
@props([
    'size' => 'md',
    'position' => 'relative'
])

@php
$sizes = [
    'sm' => 'w-8 h-8',
    'md' => 'w-10 h-10', 
    'lg' => 'w-12 h-12'
];

$positions = [
    'fixed-top-right' => 'fixed top-4 right-4 z-50',
    'fixed-bottom-right' => 'fixed bottom-20 right-4 z-50',
    'relative' => 'relative'
];

$classes = collect([
    'flex items-center justify-center rounded-full transition-all duration-300',
    'bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700',
    'text-gray-600 dark:text-gray-300',
    'border border-gray-200 dark:border-gray-600',
    'shadow-sm hover:shadow-md',
    $sizes[$size] ?? $sizes['md'],
    $positions[$position] ?? $positions['relative']
])->implode(' ');
@endphp

<button type="button" 
        class="{{ $classes }}"
        onclick="window.MobileUtils.toggleDarkMode()"
        aria-label="Toggle dark mode"
        x-data="{ isDark: false }"
        x-init="isDark = document.documentElement.classList.contains('dark')"
        @dark-mode-toggled.window="isDark = $event.detail.isDark"
        {{ $attributes }}>
    
    <!-- Light mode icon -->
    <i class="fas fa-sun transition-all duration-300" 
       x-show="!isDark"
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0 rotate-90 scale-75"
       x-transition:enter-end="opacity-100 rotate-0 scale-100"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100 rotate-0 scale-100"
       x-transition:leave-end="opacity-0 rotate-90 scale-75"></i>
    
    <!-- Dark mode icon -->
    <i class="fas fa-moon transition-all duration-300" 
       x-show="isDark"
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0 rotate-90 scale-75"
       x-transition:enter-end="opacity-100 rotate-0 scale-100"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100 rotate-0 scale-100"
       x-transition:leave-end="opacity-0 rotate-90 scale-75"></i>
</button>