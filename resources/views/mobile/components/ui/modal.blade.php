{{-- Professional Mobile Modal Component using Flowbite --}}
@props([
    'id' => 'modal',
    'size' => 'md',
    'position' => 'center',
    'backdrop' => true,
    'keyboard' => true,
    'static' => false,
    'title' => null,
    'footer' => true
])

@php
$sizes = [
    'xs' => 'max-w-xs',
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
    '2xl' => 'max-w-2xl',
    'full' => 'max-w-full'
];

$positions = [
    'center' => 'items-center justify-center',
    'top' => 'items-start justify-center pt-16',
    'bottom' => 'items-end justify-center pb-16'
];

$modalClasses = collect([
    'fixed inset-0 z-50 overflow-y-auto',
    'flex',
    $positions[$position] ?? $positions['center']
])->implode(' ');

$contentClasses = collect([
    'relative w-full',
    $sizes[$size] ?? $sizes['md'],
    'mx-4 my-6 bg-white rounded-lg shadow-xl dark:bg-gray-800'
])->implode(' ');
@endphp

<!-- Modal -->
<div id="{{ $id }}" 
     tabindex="-1" 
     aria-hidden="true" 
     class="{{ $modalClasses }} hidden"
     x-data="{ open: false }"
     x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @keydown.escape.window="if (!{{ $static ? 'true' : 'false' }}) open = false">
    
    <!-- Backdrop -->
    @if($backdrop)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 dark:bg-opacity-80"
             @click="if (!{{ $static ? 'true' : 'false' }}) open = false"></div>
    @endif
    
    <!-- Modal content -->
    <div class="{{ $contentClasses }}"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95">
        
        <!-- Modal header -->
        @if($title)
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>
                <button type="button" 
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white touch-target"
                        @click="open = false">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
        @endif
        
        <!-- Modal body -->
        <div class="p-4 md:p-5 space-y-4">
            {{ $slot }}
        </div>
        
        <!-- Modal footer -->
        @if($footer)
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 space-x-3">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>

<script>
// Modal control functions
window.openModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        modal.__x.$data.open = true;
        document.body.style.overflow = 'hidden';
    }
}

window.closeModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.__x.$data.open = false;
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 200);
    }
}
</script>