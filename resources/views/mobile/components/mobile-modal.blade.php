@props([
    'id' => 'mobile-modal',
    'title' => '',
    'size' => 'full', // full, large, medium, small
    'showClose' => true,
    'backdrop' => true
])

@php
    $sizeClasses = [
        'full' => 'h-full w-full rounded-none',
        'large' => 'h-5/6 w-full mx-4 rounded-t-3xl',
        'medium' => 'h-3/4 w-full mx-4 rounded-t-3xl',
        'small' => 'h-1/2 w-full mx-4 rounded-t-3xl'
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['full'];
@endphp

<div x-data="{ open: false }" 
     @open-modal.window="if ($event.detail.id === '{{ $id }}') open = true"
     @close-modal.window="if ($event.detail.id === '{{ $id }}') open = false"
     @keydown.escape.window="open = false"
     x-show="open"
     x-cloak
     class="fixed inset-0 z-50 overflow-hidden">
    
    <!-- Backdrop -->
    @if($backdrop)
    <div x-show="open" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false"
         class="absolute inset-0 bg-gray-600 bg-opacity-75"></div>
    @endif
    
    <!-- Modal Panel -->
    <div class="flex items-end justify-center min-h-screen">
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="relative bg-white shadow-xl {{ $sizeClass }} flex flex-col">
            
            <!-- Header -->
            @if($title || $showClose)
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                @if($title)
                    <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
                @else
                    <div></div>
                @endif
                
                @if($showClose)
                    <button @click="open = false" 
                            class="touch-target p-2 -mr-2 text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                @endif
            </div>
            @endif
            
            <!-- Content -->
            <div class="flex-1 overflow-y-auto">
                {{ $slot }}
            </div>
            
            <!-- Footer -->
            @isset($footer)
            <div class="border-t border-gray-200 p-4">
                {{ $footer }}
            </div>
            @endisset
        </div>
    </div>
</div>

<!-- Helper JavaScript -->
<script>
    function openMobileModal(id) {
        window.dispatchEvent(new CustomEvent('open-modal', { detail: { id: id } }));
    }
    
    function closeMobileModal(id) {
        window.dispatchEvent(new CustomEvent('close-modal', { detail: { id: id } }));
    }
</script>
