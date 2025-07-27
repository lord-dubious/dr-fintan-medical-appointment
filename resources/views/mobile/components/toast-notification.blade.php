{{-- Mobile Toast Notification Component --}}
<div x-data="toastNotification()" 
     x-show="isVisible" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-full"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-full"
     class="fixed bottom-4 left-4 right-4 z-50"
     @show-toast.window="showToast($event.detail)"
     @hide-toast.window="hideToast()">
    
    <div class="bg-white rounded-xl shadow-lg border-l-4 p-4 max-w-sm mx-auto"
         :class="getBorderColor()"
         @click="hideToast()">
        
        <div class="flex items-start">
            <!-- Icon -->
            <div class="flex-shrink-0 mr-3">
                <div class="h-8 w-8 rounded-full flex items-center justify-center"
                     :class="getIconBgColor()">
                    <i :class="getIcon() + ' ' + getIconColor()" class="text-sm"></i>
                </div>
            </div>
            
            <!-- Content -->
            <div class="flex-1 min-w-0">
                <div class="font-medium text-gray-900" x-text="title" x-show="title"></div>
                <div class="text-sm" :class="title ? 'text-gray-600' : 'text-gray-900'" x-text="message"></div>
                
                <!-- Action Button -->
                <div x-show="action" class="mt-2">
                    <button @click.stop="handleAction()" 
                            class="text-sm font-medium"
                            :class="getActionColor()">
                        <span x-text="action.label"></span>
                    </button>
                </div>
            </div>
            
            <!-- Close Button -->
            <div class="flex-shrink-0 ml-2">
                <button @click.stop="hideToast()" 
                        class="p-1 text-gray-400 hover:text-gray-600 touch-target">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div x-show="showProgress && duration > 0" class="mt-3">
            <div class="w-full bg-gray-200 rounded-full h-1">
                <div class="h-1 rounded-full transition-all ease-linear"
                     :class="getProgressColor()"
                     :style="`width: ${progress}%; transition-duration: ${duration}ms`"></div>
            </div>
        </div>
    </div>
</div>

<script>
function toastNotification() {
    return {
        isVisible: false,
        type: 'info', // success, error, warning, info
        title: '',
        message: '',
        action: null,
        duration: 4000,
        showProgress: true,
        progress: 100,
        timeoutId: null,
        progressIntervalId: null,

        showToast(config) {
            // Clear any existing timeout
            if (this.timeoutId) {
                clearTimeout(this.timeoutId);
            }
            if (this.progressIntervalId) {
                clearInterval(this.progressIntervalId);
            }

            // Set toast properties
            this.type = config.type || 'info';
            this.title = config.title || '';
            this.message = config.message || '';
            this.action = config.action || null;
            this.duration = config.duration !== undefined ? config.duration : 4000;
            this.showProgress = config.showProgress !== undefined ? config.showProgress : true;
            
            // Show the toast
            this.isVisible = true;
            this.progress = 100;

            // Auto-hide if duration is set
            if (this.duration > 0) {
                this.startProgressAnimation();
                this.timeoutId = setTimeout(() => {
                    this.hideToast();
                }, this.duration);
            }

            // Add haptic feedback for mobile
            if (navigator.vibrate) {
                const vibrationPattern = {
                    'success': [100],
                    'error': [100, 50, 100],
                    'warning': [150],
                    'info': [50]
                };
                navigator.vibrate(vibrationPattern[this.type] || [50]);
            }
        },

        hideToast() {
            this.isVisible = false;
            
            // Clear timeouts
            if (this.timeoutId) {
                clearTimeout(this.timeoutId);
                this.timeoutId = null;
            }
            if (this.progressIntervalId) {
                clearInterval(this.progressIntervalId);
                this.progressIntervalId = null;
            }
        },

        startProgressAnimation() {
            if (!this.showProgress || this.duration <= 0) return;

            const startTime = Date.now();
            const updateInterval = 50; // Update every 50ms

            this.progressIntervalId = setInterval(() => {
                const elapsed = Date.now() - startTime;
                const remaining = Math.max(0, this.duration - elapsed);
                this.progress = (remaining / this.duration) * 100;

                if (remaining <= 0) {
                    clearInterval(this.progressIntervalId);
                    this.progressIntervalId = null;
                }
            }, updateInterval);
        },

        handleAction() {
            if (this.action && this.action.callback) {
                this.action.callback();
            }
            this.hideToast();
        },

        getBorderColor() {
            const colors = {
                'success': 'border-green-500',
                'error': 'border-red-500',
                'warning': 'border-yellow-500',
                'info': 'border-blue-500'
            };
            return colors[this.type] || colors.info;
        },

        getIcon() {
            const icons = {
                'success': 'fas fa-check-circle',
                'error': 'fas fa-exclamation-circle',
                'warning': 'fas fa-exclamation-triangle',
                'info': 'fas fa-info-circle'
            };
            return icons[this.type] || icons.info;
        },

        getIconBgColor() {
            const colors = {
                'success': 'bg-green-100',
                'error': 'bg-red-100',
                'warning': 'bg-yellow-100',
                'info': 'bg-blue-100'
            };
            return colors[this.type] || colors.info;
        },

        getIconColor() {
            const colors = {
                'success': 'text-green-600',
                'error': 'text-red-600',
                'warning': 'text-yellow-600',
                'info': 'text-blue-600'
            };
            return colors[this.type] || colors.info;
        },

        getActionColor() {
            const colors = {
                'success': 'text-green-600 hover:text-green-800',
                'error': 'text-red-600 hover:text-red-800',
                'warning': 'text-yellow-600 hover:text-yellow-800',
                'info': 'text-blue-600 hover:text-blue-800'
            };
            return colors[this.type] || colors.info;
        },

        getProgressColor() {
            const colors = {
                'success': 'bg-green-500',
                'error': 'bg-red-500',
                'warning': 'bg-yellow-500',
                'info': 'bg-blue-500'
            };
            return colors[this.type] || colors.info;
        }
    }
}

// Global toast helper functions
window.showToast = function(message, type = 'info', options = {}) {
    window.dispatchEvent(new CustomEvent('show-toast', {
        detail: {
            message: message,
            type: type,
            ...options
        }
    }));
};

window.showSuccessToast = function(message, options = {}) {
    window.showToast(message, 'success', options);
};

window.showErrorToast = function(message, options = {}) {
    window.showToast(message, 'error', options);
};

window.showWarningToast = function(message, options = {}) {
    window.showToast(message, 'warning', options);
};

window.showInfoToast = function(message, options = {}) {
    window.showToast(message, 'info', options);
};

// Predefined toast configurations
window.ToastPresets = {
    appointmentBooked: {
        type: 'success',
        title: 'Appointment Booked',
        message: 'Your appointment has been successfully scheduled',
        action: {
            label: 'View Details',
            callback: () => window.location.href = '/patient/appointments'
        }
    },

    appointmentCancelled: {
        type: 'warning',
        title: 'Appointment Cancelled',
        message: 'Your appointment has been cancelled',
        duration: 3000
    },

    paymentSuccess: {
        type: 'success',
        title: 'Payment Successful',
        message: 'Your payment has been processed successfully',
        duration: 3000
    },

    paymentFailed: {
        type: 'error',
        title: 'Payment Failed',
        message: 'There was an issue processing your payment',
        action: {
            label: 'Retry',
            callback: () => console.log('Retry payment')
        }
    },

    networkError: {
        type: 'error',
        title: 'Connection Error',
        message: 'Please check your internet connection and try again',
        duration: 5000,
        action: {
            label: 'Retry',
            callback: () => window.location.reload()
        }
    },

    dataUpdated: {
        type: 'info',
        message: 'Data has been updated successfully',
        duration: 2000,
        showProgress: false
    },

    maintenanceMode: {
        type: 'warning',
        title: 'Maintenance Notice',
        message: 'System maintenance scheduled for tonight at 2:00 AM',
        duration: 0, // Persistent until manually closed
        showProgress: false
    }
};
</script>