<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="theme-color" content="#3b82f6">
    
    <title>@yield('title', 'Dr. Fintan - Mobile')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicone.png') }}">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'mobile-primary': '#3b82f6',
                        'mobile-primary-dark': '#1d4ed8',
                        'mobile-primary-light': '#60a5fa',
                    },
                    spacing: {
                        'safe-top': 'env(safe-area-inset-top)',
                        'safe-bottom': 'env(safe-area-inset-bottom)',
                        'safe-left': 'env(safe-area-inset-left)',
                        'safe-right': 'env(safe-area-inset-right)',
                    }
                }
            }
        }
    </script>
    
    <!-- Mobile-specific CSS -->
    <style>
        /* Mobile-first CSS utilities */
        .touch-target {
            min-height: 48px;
            min-width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .mobile-safe-area {
            padding-left: env(safe-area-inset-left);
            padding-right: env(safe-area-inset-right);
            padding-bottom: env(safe-area-inset-bottom);
        }
        
        .mobile-scroll {
            -webkit-overflow-scrolling: touch;
            overflow-y: auto;
        }
        
        .mobile-tap-highlight {
            -webkit-tap-highlight-color: rgba(59, 130, 246, 0.1);
        }
        
        .mobile-no-select {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        /* Hide scrollbars on mobile */
        .mobile-hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        
        .mobile-hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Mobile animations */
        .mobile-slide-up {
            animation: mobileSlideUp 0.3s ease-out;
        }
        
        @keyframes mobileSlideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        /* Bottom navigation safe area */
        .bottom-nav-safe {
            padding-bottom: calc(env(safe-area-inset-bottom) + 16px);
        }
        
        /* Mobile header safe area */
        .header-safe {
            padding-top: env(safe-area-inset-top);
        }
    </style>
    
    @stack('styles')
</head>

<body class="bg-gray-50 font-inter antialiased mobile-tap-highlight">
    <!-- Mobile Header -->
    @include('mobile.layouts.header')
    
    <!-- Main Content -->
    <main class="pb-20 mobile-safe-area">
        @yield('content')
    </main>
    
    <!-- Push Notifications Component -->
    @include('mobile.components.push-notification')
    
    <!-- Offline Indicator -->
    @include('mobile.components.offline-indicator')
    
    <!-- Bottom Navigation -->
    @include('mobile.layouts.bottom-nav')
    
    <!-- Mobile Sidebar/Drawer -->
    @include('mobile.layouts.sidebar')
    
    <!-- Loading Spinner -->
    <div id="mobile-loading" class="fixed inset-0 bg-white/90 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="flex flex-col items-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-mobile-primary"></div>
            <p class="mt-4 text-gray-600 text-sm">Loading...</p>
        </div>
    </div>
    
    <!-- Toast Notifications -->
    <div id="mobile-toast-container" class="fixed top-4 left-4 right-4 z-50 space-y-2"></div>
    
    <!-- Global Mobile Utilities -->
    @include('mobile.components.utils.global-functions')
    
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
    
    <!-- Alpine.js for mobile interactions -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Mobile utilities -->
    <script>
        // Mobile utility functions
        const MobileUtils = {
            // Show loading spinner
            showLoading() {
                document.getElementById('mobile-loading').classList.remove('hidden');
            },
            
            // Hide loading spinner
            hideLoading() {
                document.getElementById('mobile-loading').classList.add('hidden');
            },
            
            // Show toast notification
            showToast(message, type = 'info') {
                const container = document.getElementById('mobile-toast-container');
                const toast = document.createElement('div');
                
                const bgColor = {
                    'success': 'bg-green-500',
                    'error': 'bg-red-500',
                    'warning': 'bg-yellow-500',
                    'info': 'bg-blue-500'
                }[type] || 'bg-blue-500';
                
                toast.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg mobile-slide-up`;
                toast.innerHTML = `
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium">${message}</span>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white/80 hover:text-white">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                `;
                
                container.appendChild(toast);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 5000);
            },
            
            // Haptic feedback (if supported)
            hapticFeedback(type = 'light') {
                if (navigator.vibrate) {
                    const patterns = {
                        'light': [10],
                        'medium': [20],
                        'heavy': [30],
                        'success': [10, 50, 10],
                        'error': [50, 50, 50]
                    };
                    navigator.vibrate(patterns[type] || patterns.light);
                }
            },
            
            // Check if device is in standalone mode (PWA)
            isStandalone() {
                return window.matchMedia('(display-mode: standalone)').matches ||
                       window.navigator.standalone === true;
            }
        };
        
        // Global mobile event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loading on page load
            MobileUtils.hideLoading();
            
            // Add touch feedback to buttons
            document.querySelectorAll('button, .touch-target').forEach(element => {
                element.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.95)';
                    MobileUtils.hapticFeedback('light');
                });
                
                element.addEventListener('touchend', function() {
                    this.style.transform = 'scale(1)';
                });
            });
            
            // Prevent zoom on input focus (iOS)
            document.querySelectorAll('input, textarea, select').forEach(element => {
                element.addEventListener('focus', function() {
                    if (window.innerWidth < 768) {
                        document.querySelector('meta[name="viewport"]').setAttribute(
                            'content', 
                            'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'
                        );
                    }
                });
                
                element.addEventListener('blur', function() {
                    document.querySelector('meta[name="viewport"]').setAttribute(
                        'content', 
                        'width=device-width, initial-scale=1.0, user-scalable=no, viewport-fit=cover'
                    );
                });
            });
        });
        
        // Service Worker registration
        if ('serviceWorker' in navigator && '{{ app()->environment('production') }}') {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('SW registered: ', registration);
                    })
                    .catch(function(registrationError) {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>
