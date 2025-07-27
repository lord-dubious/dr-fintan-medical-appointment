{{-- Push Notification Component --}}
<div x-data="pushNotifications()" x-init="init()">
    <!-- Notification Permission Banner -->
    <div x-show="showPermissionBanner" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="fixed top-4 left-4 right-4 z-50 bg-mobile-primary text-white rounded-lg shadow-lg p-4">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <i class="fas fa-bell text-white text-lg"></i>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-sm">Stay Updated</h4>
                <p class="text-xs text-blue-100 mt-1">Get notified about appointment confirmations and reminders</p>
                <div class="flex space-x-2 mt-3">
                    <button @click="requestPermission()" 
                            class="bg-white text-mobile-primary px-3 py-1 rounded text-xs font-medium">
                        Enable
                    </button>
                    <button @click="dismissBanner()" 
                            class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                        Later
                    </button>
                </div>
            </div>
            <button @click="dismissBanner()" class="flex-shrink-0 text-blue-200 hover:text-white">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>

    <!-- Notification Toast -->
    <div x-show="showNotification" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-full"
         class="fixed top-20 right-4 z-50 bg-white rounded-lg shadow-lg border border-gray-200 p-4 max-w-sm">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600 text-sm"></i>
                </div>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-sm text-gray-900" x-text="notificationTitle"></h4>
                <p class="text-xs text-gray-600 mt-1" x-text="notificationMessage"></p>
            </div>
            <button @click="hideNotification()" class="flex-shrink-0 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>
</div>

<script>
function pushNotifications() {
    return {
        showPermissionBanner: false,
        showNotification: false,
        notificationTitle: '',
        notificationMessage: '',
        
        init() {
            this.checkNotificationSupport();
            this.checkPermissionStatus();
            this.registerServiceWorker();
        },
        
        checkNotificationSupport() {
            if (!('Notification' in window)) {
                console.log('This browser does not support notifications');
                return false;
            }
            return true;
        },
        
        checkPermissionStatus() {
            if (!this.checkNotificationSupport()) return;
            
            const permission = Notification.permission;
            
            if (permission === 'default') {
                // Show banner after a delay
                setTimeout(() => {
                    this.showPermissionBanner = true;
                }, 3000);
            } else if (permission === 'granted') {
                this.subscribeToNotifications();
            }
        },
        
        async requestPermission() {
            if (!this.checkNotificationSupport()) return;
            
            try {
                const permission = await Notification.requestPermission();
                
                if (permission === 'granted') {
                    this.showPermissionBanner = false;
                    this.showNotificationToast('Notifications Enabled', 'You will receive appointment updates');
                    this.subscribeToNotifications();
                } else {
                    this.showNotificationToast('Notifications Disabled', 'You can enable them later in settings');
                }
            } catch (error) {
                console.error('Error requesting notification permission:', error);
            }
        },
        
        dismissBanner() {
            this.showPermissionBanner = false;
            // Remember user dismissed banner
            localStorage.setItem('notificationBannerDismissed', 'true');
        },
        
        async registerServiceWorker() {
            if ('serviceWorker' in navigator) {
                try {
                    const registration = await navigator.serviceWorker.register('/sw.js');
                    console.log('Service Worker registered:', registration);
                } catch (error) {
                    console.error('Service Worker registration failed:', error);
                }
            }
        },
        
        async subscribeToNotifications() {
            if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
                console.log('Push messaging is not supported');
                return;
            }
            
            try {
                const registration = await navigator.serviceWorker.ready;
                const subscription = await registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: this.urlBase64ToUint8Array('{{ config("app.vapid_public_key", "") }}')
                });
                
                // Send subscription to server
                await this.sendSubscriptionToServer(subscription);
            } catch (error) {
                console.error('Failed to subscribe to push notifications:', error);
            }
        },
        
        async sendSubscriptionToServer(subscription) {
            try {
                const response = await fetch('/mobile-api/notifications/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        subscription: subscription
                    })
                });
                
                if (response.ok) {
                    console.log('Subscription sent to server successfully');
                }
            } catch (error) {
                console.error('Failed to send subscription to server:', error);
            }
        },
        
        urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');
            
            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);
            
            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        },
        
        showNotificationToast(title, message) {
            this.notificationTitle = title;
            this.notificationMessage = message;
            this.showNotification = true;
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                this.hideNotification();
            }, 5000);
        },
        
        hideNotification() {
            this.showNotification = false;
        }
    }
}
</script>
