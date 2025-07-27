{{-- Global Mobile Utility Functions --}}
<script>
// Global utility functions for mobile interface
window.MobileUtils = {
    // Toast notification system
    showToast: function(message, type = 'info', duration = 5000) {
        const toastContainer = document.getElementById('mobile-toast-container') || this.createToastContainer();
        
        const toast = document.createElement('div');
        toast.className = `flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 transform transition-all duration-300 translate-x-full`;
        
        const typeConfig = {
            success: { icon: 'fas fa-check-circle', color: 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200' },
            error: { icon: 'fas fa-times-circle', color: 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200' },
            warning: { icon: 'fas fa-exclamation-triangle', color: 'text-orange-500 bg-orange-100 dark:bg-orange-700 dark:text-orange-200' },
            info: { icon: 'fas fa-info-circle', color: 'text-blue-500 bg-blue-100 dark:bg-blue-800 dark:text-blue-200' }
        };
        
        const config = typeConfig[type] || typeConfig.info;
        
        toast.innerHTML = `
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 ${config.color} rounded-lg">
                <i class="${config.icon}"></i>
            </div>
            <div class="ml-3 text-sm font-normal">${message}</div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="this.parentElement.remove()">
                <i class="fas fa-times text-xs"></i>
            </button>
        `;
        
        toastContainer.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remove
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, duration);
    },
    
    createToastContainer: function() {
        const container = document.createElement('div');
        container.id = 'mobile-toast-container';
        container.className = 'fixed top-4 right-4 z-50 space-y-2';
        document.body.appendChild(container);
        return container;
    },
    
    // Modal system
    openModal: function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal && modal.__x) {
            modal.classList.remove('hidden');
            modal.__x.$data.open = true;
            document.body.style.overflow = 'hidden';
        }
    },
    
    closeModal: function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal && modal.__x) {
            modal.__x.$data.open = false;
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 200);
        }
    },
    
    // Dark mode toggle
    toggleDarkMode: function() {
        const html = document.documentElement;
        const isDark = html.classList.contains('dark');
        
        if (isDark) {
            html.classList.remove('dark');
            localStorage.setItem('darkMode', 'false');
        } else {
            html.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
        }
        
        // Dispatch event for components to react
        window.dispatchEvent(new CustomEvent('darkModeToggled', { 
            detail: { isDark: !isDark } 
        }));
    },
    
    // Initialize dark mode from localStorage
    initDarkMode: function() {
        const darkMode = localStorage.getItem('darkMode');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (darkMode === 'true' || (darkMode === null && prefersDark)) {
            document.documentElement.classList.add('dark');
        }
    },
    
    // Loading state management
    showLoading: function() {
        const loading = document.getElementById('mobile-loading');
        if (loading) {
            loading.classList.remove('hidden');
        }
    },
    
    hideLoading: function() {
        const loading = document.getElementById('mobile-loading');
        if (loading) {
            loading.classList.add('hidden');
        }
    },
    
    // API helper with error handling
    apiCall: async function(url, options = {}) {
        try {
            const defaultOptions = {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                }
            };
            
            const response = await fetch(url, { ...defaultOptions, ...options });
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Request failed');
            }
            
            return data;
        } catch (error) {
            this.showToast(error.message || 'An error occurred', 'error');
            throw error;
        }
    },
    
    // Fetch available slots with error handling
    fetchAvailableSlots: async function(doctorId, date) {
        try {
            const data = await this.apiCall(`/mobile-api/appointments/slots/${doctorId}/${date}`);
            return data.slots || [];
        } catch (error) {
            console.error('Error fetching slots:', error);
            return [];
        }
    },
    
    // Check doctor availability
    checkAvailability: async function(doctorId, date) {
        try {
            const data = await this.apiCall(`/mobile-api/appointments/availability?doctor=${doctorId}&date=${date}`);
            return data.available || false;
        } catch (error) {
            console.error('Error checking availability:', error);
            return false;
        }
    }
};

// Initialize dark mode on page load
document.addEventListener('DOMContentLoaded', function() {
    window.MobileUtils.initDarkMode();
});

// Global aliases for backward compatibility
window.showToast = window.MobileUtils.showToast.bind(window.MobileUtils);
window.openModal = window.MobileUtils.openModal.bind(window.MobileUtils);
window.closeModal = window.MobileUtils.closeModal.bind(window.MobileUtils);
window.fetchAvailableSlots = window.MobileUtils.fetchAvailableSlots.bind(window.MobileUtils);
window.checkAvailability = window.MobileUtils.checkAvailability.bind(window.MobileUtils);
</script>