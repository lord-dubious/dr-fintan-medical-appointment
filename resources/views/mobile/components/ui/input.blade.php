{{-- Professional Mobile Input Component using Flowbite --}}
@props([
    'type' => 'text',
    'label' => null,
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'helper' => null,
    'icon' => null,
    'iconPosition' => 'left',
    'size' => 'md',
    'variant' => 'default'
])

@php
$inputId = $attributes->get('id', 'input_' . uniqid());

$baseClasses = 'block w-full border rounded-lg transition-colors duration-200 focus:ring-4 focus:outline-none';

$variants = [
    'default' => 'bg-gray-50 border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
    'success' => 'bg-green-50 border-green-500 text-green-900 placeholder-green-700 focus:ring-green-500 focus:border-green-500 dark:text-green-400 dark:placeholder-green-500 dark:border-green-500',
    'error' => 'bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500'
];

$sizes = [
    'sm' => 'p-2 text-sm',
    'md' => 'p-2.5 text-sm',
    'lg' => 'p-4 text-base'
];

$inputClasses = collect([
    $baseClasses,
    $variants[$error ? 'error' : 'default'],
    $sizes[$size] ?? $sizes['md'],
    $icon ? ($iconPosition === 'left' ? 'pl-10' : 'pr-10') : '',
    $disabled ? 'opacity-50 cursor-not-allowed' : '',
])->filter()->implode(' ');
@endphp

<div class="space-y-2">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-900 dark:text-white">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 {{ $iconPosition === 'left' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                <i class="{{ $icon }} text-gray-500 dark:text-gray-400"></i>
            </div>
        @endif
        
        <input type="{{ $type }}"
               id="{{ $inputId }}"
               class="{{ $inputClasses }}"
               placeholder="{{ $placeholder }}"
               @if($required) required @endif
               @if($disabled) disabled @endif
               {{ $attributes->except(['id', 'class']) }}>
    </div>
    
    @if($error)
        <p class="text-sm text-red-600 dark:text-red-500">
            <i class="fas fa-exclamation-circle mr-1"></i>
            {{ $error }}
        </p>
    @endif
    
    @if($helper && !$error)
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ $helper }}
        </p>
    @endif
</div>