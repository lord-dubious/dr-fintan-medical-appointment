{{-- Offline Indicator Component --}}
<div x-data="offlineIndicator()" x-init="init()">
    <!-- Offline Banner -->
    <div x-show="isOffline" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-full"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-full"
         class="fixed top-0 left-0 right-0 z-50 bg-red-500 text-white px-4 py-2">
        <div class="flex items-center justify-center space-x-2">
            <i class="fas fa-wifi-slash text-sm"></i>
            <span class="text-sm font-medium">You're offline</span>
            <span class="text-xs opacity-75">- Some features may be limited</span>
        </div>
    </div>

    <!-- Back Online Banner -->
    <div x-show="showBackOnline" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-full"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-full"
         class="fixed top-0 left-0 right-0 z-50 bg-green-500 text-white px-4 py-2">
        <div class="flex items-center justify-center space-x-2">
            <i class="fas fa-wifi text-sm"></i>
            <span class="text-sm font-medium">Back online</span>
        </div>
    </div>
</div>

<script>
function offlineIndicator() {
    return {
        isOffline: false,
        showBackOnline: false,
        
        init() {
            this.checkOnlineStatus();
            this.setupEventListeners();
        },
        
        checkOnlineStatus() {
            this.isOffline = !navigator.onLine;
        },
        
        setupEventListeners() {
            window.addEventListener('online', () => {
                this.isOffline = false;
                this.showBackOnlineBanner();
            });
            
            window.addEventListener('offline', () => {
                this.isOffline = true;
                this.showBackOnline = false;
            });
        },
        
        showBackOnlineBanner() {
            this.showBackOnline = true;
            setTimeout(() => {
                this.showBackOnline = false;
            }, 3000);
        }
    }
}
</script>
