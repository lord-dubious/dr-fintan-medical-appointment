{{-- Professional Mobile Card Component using Flowbite --}}
@props([
    'variant' => 'default',
    'padding' => 'md',
    'shadow' => 'sm',
    'rounded' => 'lg',
    'border' => true,
    'hover' => false,
    'clickable' => false,
    'href' => null
])

@php
$baseClasses = 'bg-white dark:bg-gray-800 transition-all duration-200';

$variants = [
    'default' => 'text-gray-900 dark:text-white',
    'primary' => 'bg-blue-50 border-blue-200 text-blue-900 dark:bg-blue-900 dark:border-blue-700 dark:text-blue-100',
    'success' => 'bg-green-50 border-green-200 text-green-900 dark:bg-green-900 dark:border-green-700 dark:text-green-100',
    'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-900 dark:bg-yellow-900 dark:border-yellow-700 dark:text-yellow-100',
    'danger' => 'bg-red-50 border-red-200 text-red-900 dark:bg-red-900 dark:border-red-700 dark:text-red-100',
    'info' => 'bg-blue-50 border-blue-200 text-blue-900 dark:bg-blue-900 dark:border-blue-700 dark:text-blue-100'
];

$paddings = [
    'none' => '',
    'sm' => 'p-3',
    'md' => 'p-4',
    'lg' => 'p-6',
    'xl' => 'p-8'
];

$shadows = [
    'none' => '',
    'sm' => 'shadow-sm',
    'md' => 'shadow-md',
    'lg' => 'shadow-lg',
    'xl' => 'shadow-xl'
];

$roundeds = [
    'none' => '',
    'sm' => 'rounded-sm',
    'md' => 'rounded-md',
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    '2xl' => 'rounded-2xl'
];

$classes = collect([
    $baseClasses,
    $variants[$variant] ?? $variants['default'],
    $paddings[$padding] ?? $paddings['md'],
    $shadows[$shadow] ?? $shadows['sm'],
    $roundeds[$rounded] ?? $roundeds['lg'],
    $border ? 'border border-gray-200 dark:border-gray-700' : '',
    $hover ? 'hover:shadow-md hover:scale-[1.02]' : '',
    $clickable ? 'cursor-pointer' : '',
])->filter()->implode(' ');
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $classes }}" {{ $attributes }}>
        {{ $slot }}
    </a>
@else
    <div class="{{ $classes }}" {{ $attributes }}>
        {{ $slot }}
    </div>
@endif