<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Appointment System - Professional Healthcare</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicone.png') }}">

    <!-- Inter Font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'medical': {
                            'primary': '#1A5F7A',
                            'secondary': '#159895',
                            'accent': '#57C5B6',
                            'bg-light': '#F8F9FA',
                            'border-light': '#E9ECEF',
                            'neutral-100': '#DEE2E6',
                            'neutral-200': '#CED4DA',
                            'neutral-300': '#ADB5BD',
                            'neutral-400': '#6C757D',
                            'neutral-500': '#495057',
                            'neutral-600': '#343A40',
                            'error': '#DC3545',
                            'success': '#28A745',
                            'warning': '#FFC107',
                            'info': '#0DCAF0'
                        }
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                        'sans': ['Inter', 'system-ui', 'sans-serif']
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(40px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous">
    <!-- Font Awesome Fallback -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">

    <!-- Custom Icon Styles -->
    <style>
        /* Ensure FontAwesome icons display properly */
        .fas, .far, .fab, .fal, .fad, .fat {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 5 Free", "Font Awesome 5 Pro" !important;
            font-weight: 900;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .far {
            font-weight: 400;
        }

        /* Icon loading fallback */
        .fas:before, .far:before, .fab:before {
            display: inline-block;
            text-decoration: inherit;
        }

        /* Specific icon fixes */
        .fa-calendar-check:before { content: "\f274"; }
        .fa-check-circle:before { content: "\f058"; }
        .fa-calendar-times:before { content: "\f273"; }
        .fa-user:before { content: "\f007"; }
        .fa-phone:before { content: "\f095"; }
        .fa-envelope:before { content: "\f0e0"; }
        .fa-user-md:before { content: "\f0f0"; }
        .fa-hospital:before { content: "\f0f8"; }
        .fa-clock:before { content: "\f017"; }
        .fa-calendar:before { content: "\f133"; }
        .fa-chevron-left:before { content: "\f053"; }
        .fa-chevron-right:before { content: "\f054"; }
        .fa-sun:before { content: "\f185"; }
        .fa-cloud-sun:before { content: "\f6c4"; }
        .fa-moon:before { content: "\f186"; }
    </style>

    <!-- Original CSS for compatibility -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <!-- Fintan Style System -->
    <style>
        /* Apply Inter font system-wide */
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }

        /* Fintan-style card system with consistent padding */
        .fintan-card {
            @apply bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8;
        }

        .fintan-card-sm {
            @apply bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200/50 dark:border-gray-700/50 p-6;
        }

        .fintan-card-xs {
            @apply bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200/50 dark:border-gray-700/50 p-4;
        }

        /* Consistent text colors for dark mode */
        .fintan-text-primary {
            @apply text-gray-900 dark:text-gray-100 !important;
        }

        .fintan-text-secondary {
            @apply text-gray-600 dark:text-gray-300 !important;
        }

        .fintan-text-muted {
            @apply text-gray-500 dark:text-gray-400 !important;
        }

        /* Button styles */
        .fintan-btn-primary {
            @apply px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105;
        }

        .fintan-btn-secondary {
            @apply px-6 py-3 border-2 border-blue-200 hover:border-blue-300 hover:bg-blue-50 dark:border-blue-700 dark:hover:border-blue-600 dark:hover:bg-blue-900/20 transition-all duration-300 rounded-xl font-semibold text-blue-600 dark:text-blue-400;
        }

        /* Fix navbar dark mode colors */
        .navbar-dark {
            background-color: rgb(31 41 55 / 0.95) !important;
            backdrop-filter: blur(10px);
        }

        .navbar-dark .nav-link {
            color: rgb(229 231 235) !important;
        }

        .navbar-dark .nav-link:hover {
            color: rgb(96 165 250) !important;
        }

        /* Ensure all cards have proper dark mode styling */
        .dark .bg-white {
            background-color: rgb(31 41 55) !important;
        }

        .dark .text-gray-900 {
            color: rgb(243 244 246) !important;
        }

        .dark .text-gray-600 {
            color: rgb(209 213 219) !important;
        }

        .dark .text-gray-500 {
            color: rgb(156 163 175) !important;
        }

        .dark .border-gray-200 {
            border-color: rgb(75 85 99 / 0.5) !important;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-blue-900 min-h-screen">
