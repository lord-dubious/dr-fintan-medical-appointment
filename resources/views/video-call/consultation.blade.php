<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Video Consultation - Appointment {{ $appointment->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/@daily-co/daily-js"></script>
</head>
<body class="bg-gray-900 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-white mb-2">Video Consultation</h1>
            <p class="text-gray-300">Appointment #{{ $appointment->id }} - {{ ucfirst($userRole) }}</p>
        </div>

        <!-- Video Container -->
        <div class="max-w-6xl mx-auto mb-6">
            <div id="daily-container" class="w-full bg-black rounded-lg overflow-hidden shadow-2xl" style="height: 600px;">
                <!-- Daily.co will be embedded here -->
                <div id="join-placeholder" class="w-full h-full flex items-center justify-center text-white">
                    <div class="text-center">
                        <div class="mb-6">
                            <i class="fas fa-video text-6xl text-blue-400 mb-4"></i>
                            <h3 class="text-2xl font-semibold mb-2">Ready to Start Consultation</h3>
                            <p class="text-gray-300">Click the button below to join your video consultation</p>
                        </div>
                        <button id="join-call-btn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                            <i class="fas fa-video mr-2"></i>
                            Join Video Call
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls (hidden until call starts) -->
        <div id="call-controls" class="text-center hidden">
            <button id="leave-call-btn" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-phone-slash mr-2"></i>
                Leave Call
            </button>
        </div>

        <!-- Status Messages -->
        <div id="status-messages" class="max-w-2xl mx-auto mt-6">
            <!-- Status messages will appear here -->
        </div>
    </div>

    <script>
        const appointmentId = {{ $appointment->id }};
        const userName = '{{ Auth::user()->name }}';
        const userRole = '{{ $userRole }}';
        
        let callFrame = null;
        let roomData = null;

        // Show notification
        function showNotification(message, type = 'info') {
            const statusDiv = document.getElementById('status-messages');
            const notification = document.createElement('div');
            
            const bgColor = type === 'error' ? 'bg-red-500' : 
                           type === 'success' ? 'bg-green-500' : 
                           type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';
            
            notification.className = `${bgColor} text-white p-4 rounded-lg mb-4 shadow-lg`;
            notification.innerHTML = `
                <div class="flex items-start">
                    <i class="fas ${type === 'error' ? 'fa-exclamation-triangle' : 
                                   type === 'success' ? 'fa-check-circle' : 
                                   'fa-info-circle'} mr-2 mt-1"></i>
                    <div class="flex-1">
                        <span>${message}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            statusDiv.appendChild(notification);
            
            // Auto remove after 5 seconds for success messages
            if (type === 'success') {
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 5000);
            }
        }

        // Join video call
        async function joinVideoCall() {
            const joinBtn = document.getElementById('join-call-btn');
            const placeholder = document.getElementById('join-placeholder');
            const container = document.getElementById('daily-container');
            const controls = document.getElementById('call-controls');

            try {
                // Disable button and show loading
                joinBtn.disabled = true;
                joinBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Joining...';

                showNotification('Creating video room...', 'info');

                // Create or get room
                const response = await fetch(`/video-call/room/${appointmentId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error || 'Failed to create room');
                }

                roomData = await response.json();
                console.log('Room created:', roomData);

                showNotification('Room created successfully! Joining call...', 'success');

                // Hide placeholder immediately
                placeholder.style.display = 'none';

                // Create Daily call frame with minimal, working configuration
                callFrame = Daily.createFrame(container, {
                    iframeStyle: {
                        width: '100%',
                        height: '100%',
                        border: 'none'
                    }
                });

                // Set up essential event listeners
                callFrame.on('joined-meeting', (event) => {
                    console.log('Successfully joined meeting', event);
                    showNotification('Successfully joined the consultation!', 'success');
                    controls.classList.remove('hidden');
                });

                callFrame.on('left-meeting', (event) => {
                    console.log('Left meeting', event);
                    showNotification('You have left the consultation', 'info');
                    resetUI();
                });

                callFrame.on('error', (event) => {
                    console.error('Daily call error:', event);
                    showNotification('Call error: ' + (event.errorMsg || event.message || 'Unknown error'), 'error');
                });

                // Join the room
                const token = userRole === 'doctor' ? roomData.tokens?.doctor : roomData.tokens?.patient;

                console.log('Joining with:', {
                    url: roomData.room_url,
                    token: token ? 'token_present' : 'no_token',
                    userName: userName,
                    userRole: userRole
                });

                await callFrame.join({
                    url: roomData.room_url,
                    token: token,
                    userName: userName
                });

                console.log('Join call initiated successfully');

            } catch (error) {
                console.error('Join call error:', error);
                showNotification('Failed to join consultation: ' + error.message, 'error');

                // Show placeholder again on error
                placeholder.style.display = 'flex';

                // Reset button
                joinBtn.disabled = false;
                joinBtn.innerHTML = '<i class="fas fa-video mr-2"></i>Join Video Call';
            }
        }

        // Leave video call
        function leaveVideoCall() {
            if (callFrame) {
                callFrame.leave();
            }
        }

        // Reset UI to initial state
        function resetUI() {
            const joinBtn = document.getElementById('join-call-btn');
            const placeholder = document.getElementById('join-placeholder');
            const controls = document.getElementById('call-controls');

            if (callFrame) {
                try {
                    callFrame.destroy();
                } catch (e) {
                    console.log('Error destroying call frame:', e);
                }
                callFrame = null;
            }

            if (placeholder) {
                placeholder.style.display = 'flex';
            }
            if (controls) {
                controls.classList.add('hidden');
            }
            if (joinBtn) {
                joinBtn.disabled = false;
                joinBtn.innerHTML = '<i class="fas fa-video mr-2"></i>Join Video Call';
            }
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('join-call-btn').addEventListener('click', joinVideoCall);
            document.getElementById('leave-call-btn').addEventListener('click', leaveVideoCall);
            
            // Show initial message
            showNotification('Welcome to your video consultation. Click "Join Video Call" when ready.', 'info');
        });

        // Handle page unload
        window.addEventListener('beforeunload', () => {
            if (callFrame) {
                callFrame.destroy();
            }
        });
    </script>
</body>
</html>
