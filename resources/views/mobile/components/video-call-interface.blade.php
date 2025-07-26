{{-- Mobile Video Call Interface Component with Daily.co Integration --}}
<div x-data="videoCallInterface()" class="fixed inset-0 bg-black z-50" x-show="isVisible" x-transition>
    <!-- Video Call Container -->
    <div class="relative h-full w-full">
        <!-- Daily.co Video Frame -->
        <div id="daily-video-container" class="h-full w-full bg-black">
            <!-- Video streams will be injected here by Daily.co -->
        </div>

        <!-- Mobile Call Controls Overlay -->
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
            <!-- Call Info -->
            <div class="text-center mb-6" x-show="callInfo.patientName">
                <h3 class="text-white text-lg font-semibold" x-text="callInfo.patientName"></h3>
                <p class="text-white/80 text-sm" x-text="callInfo.appointmentType"></p>
                <div class="text-white/60 text-sm mt-1">
                    <span x-text="formatCallDuration(callDuration)"></span>
                </div>
            </div>

            <!-- Control Buttons -->
            <div class="flex justify-center space-x-6">
                <!-- Mute Audio -->
                <button @click="toggleAudio()" 
                        class="h-14 w-14 rounded-full flex items-center justify-center touch-target transition-colors"
                        :class="isAudioMuted ? 'bg-red-600' : 'bg-white/20 backdrop-blur'">
                    <i :class="isAudioMuted ? 'fas fa-microphone-slash' : 'fas fa-microphone'" 
                       class="text-white text-xl"></i>
                </button>

                <!-- Toggle Video -->
                <button @click="toggleVideo()" 
                        class="h-14 w-14 rounded-full flex items-center justify-center touch-target transition-colors"
                        :class="isVideoMuted ? 'bg-red-600' : 'bg-white/20 backdrop-blur'">
                    <i :class="isVideoMuted ? 'fas fa-video-slash' : 'fas fa-video'" 
                       class="text-white text-xl"></i>
                </button>

                <!-- End Call -->
                <button @click="endCall()" 
                        class="h-14 w-14 bg-red-600 rounded-full flex items-center justify-center touch-target">
                    <i class="fas fa-phone text-white text-xl transform rotate-135"></i>
                </button>

                <!-- Switch Camera -->
                <button @click="switchCamera()" 
                        class="h-14 w-14 rounded-full bg-white/20 backdrop-blur flex items-center justify-center touch-target"
                        x-show="isMobile">
                    <i class="fas fa-sync-alt text-white text-xl"></i>
                </button>

                <!-- More Options -->
                <button @click="showMoreOptions = !showMoreOptions" 
                        class="h-14 w-14 rounded-full bg-white/20 backdrop-blur flex items-center justify-center touch-target">
                    <i class="fas fa-ellipsis-v text-white text-xl"></i>
                </button>
            </div>

            <!-- Additional Options (Expandable) -->
            <div x-show="showMoreOptions" x-transition class="mt-4 flex justify-center space-x-4">
                <!-- Speaker Toggle -->
                <button @click="toggleSpeaker()" 
                        class="h-12 w-12 rounded-full bg-white/20 backdrop-blur flex items-center justify-center touch-target">
                    <i :class="isSpeakerOn ? 'fas fa-volume-up' : 'fas fa-volume-down'" 
                       class="text-white"></i>
                </button>

                <!-- Screen Share (if supported) -->
                <button @click="toggleScreenShare()" 
                        class="h-12 w-12 rounded-full bg-white/20 backdrop-blur flex items-center justify-center touch-target"
                        x-show="canScreenShare">
                    <i :class="isScreenSharing ? 'fas fa-stop' : 'fas fa-desktop'" 
                       class="text-white"></i>
                </button>

                <!-- Chat Toggle -->
                <button @click="toggleChat()" 
                        class="h-12 w-12 rounded-full bg-white/20 backdrop-blur flex items-center justify-center touch-target relative">
                    <i class="fas fa-comment text-white"></i>
                    <span x-show="unreadMessages > 0" 
                          class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                          x-text="unreadMessages"></span>
                </button>
            </div>
        </div>

        <!-- Connection Status -->
        <div class="absolute top-4 left-4 right-4">
            <div x-show="connectionStatus !== 'connected'" 
                 class="bg-black/60 backdrop-blur rounded-lg p-3 text-center">
                <div class="flex items-center justify-center space-x-2">
                    <div class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full" 
                         x-show="connectionStatus === 'connecting'"></div>
                    <span class="text-white text-sm" x-text="getConnectionStatusText()"></span>
                </div>
            </div>
        </div>

        <!-- Network Quality Indicator -->
        <div class="absolute top-4 right-4">
            <div class="bg-black/60 backdrop-blur rounded-lg p-2">
                <div class="flex items-center space-x-1">
                    <template x-for="i in 4" :key="i">
                        <div class="w-1 h-3 rounded-full"
                             :class="i <= networkQuality ? 'bg-green-400' : 'bg-gray-600'"></div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Chat Panel (Slide-in) -->
        <div x-show="showChat" x-transition:enter="transform transition ease-in-out duration-300"
             x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-300"
             x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
             class="absolute top-0 right-0 w-80 h-full bg-white shadow-xl">
            
            <!-- Chat Header -->
            <div class="bg-mobile-primary text-white p-4 flex items-center justify-between">
                <h3 class="font-semibold">Chat</h3>
                <button @click="toggleChat()" class="p-1 touch-target">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Chat Messages -->
            <div class="flex-1 overflow-y-auto p-4 space-y-3" style="height: calc(100% - 120px);">
                <template x-for="message in chatMessages" :key="message.id">
                    <div class="flex" :class="message.sender === 'me' ? 'justify-end' : 'justify-start'">
                        <div class="max-w-xs rounded-lg p-3"
                             :class="message.sender === 'me' ? 'bg-mobile-primary text-white' : 'bg-gray-100'">
                            <p class="text-sm" x-text="message.text"></p>
                            <p class="text-xs opacity-70 mt-1" x-text="formatTime(message.timestamp)"></p>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Chat Input -->
            <div class="p-4 border-t">
                <div class="flex space-x-2">
                    <input type="text" x-model="newMessage" @keyup.enter="sendMessage()"
                           placeholder="Type a message..."
                           class="flex-1 p-2 border rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-transparent">
                    <button @click="sendMessage()" 
                            class="bg-mobile-primary text-white p-2 rounded-lg touch-target">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Call End Confirmation Modal -->
    <div x-show="showEndCallModal" class="absolute inset-0 bg-black/80 flex items-center justify-center p-4" x-transition>
        <div class="bg-white rounded-xl p-6 max-w-sm w-full text-center">
            <div class="h-16 w-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-phone text-red-600 text-xl transform rotate-135"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">End Call?</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to end this consultation?</p>
            <div class="flex space-x-3">
                <button @click="showEndCallModal = false" 
                        class="flex-1 bg-gray-100 text-gray-700 py-3 rounded-lg font-medium">
                    Cancel
                </button>
                <button @click="confirmEndCall()" 
                        class="flex-1 bg-red-600 text-white py-3 rounded-lg font-medium">
                    End Call
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function videoCallInterface() {
    return {
        isVisible: false,
        dailyCall: null,
        isAudioMuted: false,
        isVideoMuted: false,
        isSpeakerOn: true,
        isScreenSharing: false,
        canScreenShare: false,
        showMoreOptions: false,
        showChat: false,
        showEndCallModal: false,
        connectionStatus: 'disconnected', // disconnected, connecting, connected, failed
        networkQuality: 4,
        callDuration: 0,
        callStartTime: null,
        isMobile: false,
        
        // Call info
        callInfo: {
            patientName: '',
            appointmentType: '',
            roomUrl: ''
        },
        
        // Chat
        chatMessages: [],
        newMessage: '',
        unreadMessages: 0,

        init() {
            this.isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            this.canScreenShare = navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia;
            
            // Listen for call events
            window.addEventListener('start-video-call', (event) => {
                this.startCall(event.detail);
            });
        },

        async startCall(callData) {
            try {
                this.callInfo = callData;
                this.isVisible = true;
                this.connectionStatus = 'connecting';
                
                // Initialize Daily.co
                if (!window.DailyIframe) {
                    throw new Error('Daily.co SDK not loaded');
                }

                // Create Daily call instance
                this.dailyCall = window.DailyIframe.createFrame({
                    iframeStyle: {
                        position: 'absolute',
                        top: 0,
                        left: 0,
                        width: '100%',
                        height: '100%',
                        border: 'none'
                    },
                    showLeaveButton: false,
                    showFullscreenButton: false,
                    showLocalVideo: true,
                    showParticipantsBar: false
                });

                // Mount to container
                this.dailyCall.iframe().style.borderRadius = '0';
                document.getElementById('daily-video-container').appendChild(this.dailyCall.iframe());

                // Set up event listeners
                this.setupDailyEventListeners();

                // Join the call
                await this.dailyCall.join({ 
                    url: callData.roomUrl,
                    userName: callData.doctorName || 'Dr. Fintan'
                });

                this.connectionStatus = 'connected';
                this.callStartTime = Date.now();
                this.startCallTimer();

            } catch (error) {
                console.error('Error starting video call:', error);
                this.connectionStatus = 'failed';
                this.showToast('Failed to start video call', 'error');
            }
        },

        setupDailyEventListeners() {
            this.dailyCall
                .on('joined-meeting', () => {
                    this.connectionStatus = 'connected';
                    this.showToast('Connected to call', 'success');
                })
                .on('left-meeting', () => {
                    this.handleCallEnd();
                })
                .on('participant-joined', (event) => {
                    this.showToast(`${event.participant.user_name} joined`, 'info');
                })
                .on('participant-left', (event) => {
                    this.showToast(`${event.participant.user_name} left`, 'info');
                })
                .on('error', (error) => {
                    console.error('Daily call error:', error);
                    this.connectionStatus = 'failed';
                })
                .on('network-quality-change', (event) => {
                    this.networkQuality = Math.ceil(event.quality * 4);
                })
                .on('app-message', (event) => {
                    this.handleChatMessage(event.data);
                });
        },

        startCallTimer() {
            setInterval(() => {
                if (this.callStartTime) {
                    this.callDuration = Math.floor((Date.now() - this.callStartTime) / 1000);
                }
            }, 1000);
        },

        async toggleAudio() {
            try {
                this.isAudioMuted = !this.isAudioMuted;
                await this.dailyCall.setLocalAudio(!this.isAudioMuted);
                
                // Haptic feedback
                if (navigator.vibrate) {
                    navigator.vibrate(50);
                }
            } catch (error) {
                console.error('Error toggling audio:', error);
            }
        },

        async toggleVideo() {
            try {
                this.isVideoMuted = !this.isVideoMuted;
                await this.dailyCall.setLocalVideo(!this.isVideoMuted);
                
                // Haptic feedback
                if (navigator.vibrate) {
                    navigator.vibrate(50);
                }
            } catch (error) {
                console.error('Error toggling video:', error);
            }
        },

        async switchCamera() {
            try {
                const devices = await this.dailyCall.enumerateDevices();
                const videoDevices = devices.filter(d => d.kind === 'videoinput');
                
                if (videoDevices.length > 1) {
                    await this.dailyCall.cycleCamera();
                    this.showToast('Camera switched', 'success');
                }
            } catch (error) {
                console.error('Error switching camera:', error);
            }
        },

        toggleSpeaker() {
            this.isSpeakerOn = !this.isSpeakerOn;
            // Note: Speaker control is limited in web browsers
            this.showToast(this.isSpeakerOn ? 'Speaker on' : 'Speaker off', 'info');
        },

        async toggleScreenShare() {
            try {
                if (this.isScreenSharing) {
                    await this.dailyCall.stopScreenShare();
                    this.isScreenSharing = false;
                } else {
                    await this.dailyCall.startScreenShare();
                    this.isScreenSharing = true;
                }
            } catch (error) {
                console.error('Error toggling screen share:', error);
                this.showToast('Screen sharing not available', 'error');
            }
        },

        endCall() {
            this.showEndCallModal = true;
        },

        async confirmEndCall() {
            try {
                if (this.dailyCall) {
                    await this.dailyCall.leave();
                }
                this.handleCallEnd();
            } catch (error) {
                console.error('Error ending call:', error);
                this.handleCallEnd();
            }
        },

        handleCallEnd() {
            this.isVisible = false;
            this.showEndCallModal = false;
            this.connectionStatus = 'disconnected';
            this.callStartTime = null;
            this.callDuration = 0;
            
            if (this.dailyCall) {
                this.dailyCall.destroy();
                this.dailyCall = null;
            }
            
            // Clear the container
            const container = document.getElementById('daily-video-container');
            if (container) {
                container.innerHTML = '';
            }
            
            this.showToast('Call ended', 'info');
            
            // Redirect or show post-call actions
            setTimeout(() => {
                window.location.href = '/dashboard';
            }, 2000);
        },

        toggleChat() {
            this.showChat = !this.showChat;
            if (this.showChat) {
                this.unreadMessages = 0;
            }
        },

        sendMessage() {
            if (!this.newMessage.trim()) return;
            
            const message = {
                id: Date.now(),
                text: this.newMessage,
                sender: 'me',
                timestamp: Date.now()
            };
            
            this.chatMessages.push(message);
            
            // Send via Daily.co
            if (this.dailyCall) {
                this.dailyCall.sendAppMessage(message, '*');
            }
            
            this.newMessage = '';
        },

        handleChatMessage(messageData) {
            if (messageData.sender !== 'me') {
                this.chatMessages.push(messageData);
                if (!this.showChat) {
                    this.unreadMessages++;
                }
            }
        },

        formatCallDuration(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        },

        formatTime(timestamp) {
            return new Date(timestamp).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        },

        getConnectionStatusText() {
            const statusTexts = {
                'connecting': 'Connecting...',
                'connected': 'Connected',
                'failed': 'Connection failed',
                'disconnected': 'Disconnected'
            };
            return statusTexts[this.connectionStatus] || 'Unknown';
        },

        showToast(message, type = 'info') {
            window.dispatchEvent(new CustomEvent('show-toast', {
                detail: { message, type }
            }));
        }
    }
}

// Global function to start video calls
window.startVideoCall = function(callData) {
    window.dispatchEvent(new CustomEvent('start-video-call', {
        detail: callData
    }));
};
</script>

{{-- Daily.co SDK --}}
<script src="https://unpkg.com/@daily-co/daily-js"></script>