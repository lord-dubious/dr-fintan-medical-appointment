<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Consultation - Dr. Fintan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <div class="bg-blue-600 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="{{ Auth::user()->role === 'doctor' ? route('doctor.dashboard') : route('patient.dashboard') }}"
               class="bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded transition-colors">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <h1 class="text-xl font-bold">Dr. Fintan - Consultation #{{ $appointmentId }}</h1>
            <span class="text-blue-200">{{ Auth::user()->role === 'doctor' ? 'Doctor' : 'Patient' }}: {{ Auth::user()->name ?? Auth::user()->email }}</span>
        </div>
        <div class="flex items-center space-x-2">
            <span id="participant-count" class="text-blue-200">Participants: 0</span>
            <button onclick="endConsultationAndReturn()" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded transition-colors">
                <i class="fas fa-times"></i> End & Return
            </button>
        </div>
    </div>

    <!-- Status Information -->
    <div class="max-w-3xl mx-auto my-4 px-4">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-blue-800">
            <i class="fas fa-info-circle mr-2"></i>
            <span>Video consultation system ready. Click "Join Consultation" to begin.</span>
        </div>
    </div>

    <!-- Controls -->
    <div class="max-w-6xl mx-auto px-4">
        <div class="controls flex gap-4 my-4 justify-center">
            <button id="join-btn"
                class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                <i class="fas fa-video"></i> Join Consultation
            </button>

            <button id="leave-btn"
                class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition"
                disabled>
                <i class="fas fa-phone-slash"></i> Leave
            </button>

            <button id="record-btn"
                class="px-6 py-3 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition"
                disabled>
                <i class="fas fa-record-vinyl"></i> Record
            </button>
        </div>

        <div class="controls flex gap-4 my-4 justify-center">
            <button id="toggle-camera"
                class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
                disabled>
                <i class="fas fa-video"></i> Toggle Camera
            </button>

            <button id="toggle-mic"
                class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition"
                disabled>
                <i class="fas fa-microphone"></i> Toggle Microphone
            </button>

            <button id="screen-share-btn"
                class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition"
                disabled>
                <i class="fas fa-desktop"></i> Start Screen Share
            </button>

            <button id="blur-btn"
                class="px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg shadow-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition">
                <i class="fas fa-eye-slash"></i> Blur Background
            </button>
        </div>

        <!-- Device Selectors -->
        <div class="controls flex gap-4 my-4 justify-center">
            <select id="camera-selector" class="border rounded px-3 py-2 bg-white">
                <option value="" disabled selected>Select a camera</option>
            </select>
            <select id="mic-selector" class="border rounded px-3 py-2 bg-white">
                <option value="" disabled selected>Select a microphone</option>
            </select>
        </div>

        <!-- Status Display -->
        <div id="status" class="text-center my-4 space-y-2">
            <div id="camera-state" class="text-gray-600">Camera: Off</div>
            <div id="mic-state" class="text-gray-600">Mic: Off</div>
            <div id="active-speaker" class="text-gray-600">Active Speaker: None</div>
        </div>
    </div>

    <!-- Chat Section -->
    <div class="max-w-md mx-auto my-6 px-4">
        <h2 class="text-lg font-bold mb-2">Chat</h2>
        <div id="chat-box" class="h-64 overflow-y-auto border rounded p-2 bg-gray-50 mb-2"></div>
        <div class="flex gap-2">
            <input id="chat-input" type="text" placeholder="Type your message..."
                class="flex-grow border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button id="send-chat-btn"
                class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                <i class="fas fa-paper-plane"></i> Send
            </button>
        </div>
    </div>

    <!-- Video Container -->
    <div id="videos" class="max-w-6xl mx-auto px-4"></div>

    <!-- Screen Share Area -->
    <div id="shared-screen-area" class="p-4 border-2 border-red-500 rounded-lg w-full max-w-3xl mx-auto my-4 hidden">
        <h3 class="text-red-600 font-bold mb-2"><i class="fas fa-desktop"></i> Screen Share</h3>
        <div id="shared-screen-container" class="aspect-video bg-black rounded overflow-hidden"></div>
    </div>

    <!-- Today's Recordings -->
    <div class="max-w-3xl mx-auto my-6 px-4">
        <h2 class="text-xl font-bold mb-4">Today's Recordings</h2>
        <button type="button" id="load-recordings-btn"
            class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            <i class="fas fa-list"></i> Load Recordings
        </button>
        <div id="recordings-list" class="space-y-4 max-h-96 overflow-y-auto border rounded-lg p-4 bg-white shadow mt-4">
            <p class="text-gray-500">Click "Load Recordings" to see today's recordings...</p>
        </div>
    </div>

    <script src="https://unpkg.com/@daily-co/daily-js"></script>
    <script>
        // Global variables
        let appointmentId = @json($appointmentId);
        let userRole = @json(Auth::user()->role);
        let userName = @json(Auth::user()->name ?? Auth::user()->email);

        // HTTPS Detection and Media Permissions
        const isHTTPS = location.protocol === 'https:';
        const isLocalhost = location.hostname === 'localhost' || location.hostname === '127.0.0.1';

        // Check if media access is available
        function checkMediaSupport() {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                if (!isHTTPS && !isLocalhost) {
                    alert('Video calls require HTTPS. Please access this page via HTTPS for full functionality.');
                    return false;
                }
                alert('Your browser does not support media devices. Please use a modern browser.');
                return false;
            }
            return true;
        }

        // Initialize media support check
        document.addEventListener('DOMContentLoaded', function() {
            if (!checkMediaSupport()) {
                document.getElementById('join-btn').disabled = true;
                document.getElementById('join-btn').innerHTML = '<i class="fas fa-exclamation-triangle"></i> HTTPS Required';
                document.getElementById('join-btn').className = document.getElementById('join-btn').className.replace('bg-green-600', 'bg-red-600');
            }
        });

        // Load recordings function
        async function loadTodayRecordings() {
            const recordingsList = document.getElementById('recordings-list');
            recordingsList.innerHTML = '<p class="text-gray-500">Loading recordings...</p>';

            try {
                const response = await fetch('/api/recording/');
                const data = await response.json();

                const today = new Date();
                const todayDateStr = today.toISOString().split('T')[0];

                const todayRecordings = data.data.filter(recording => {
                    const recordingDate = new Date(recording.start_ts * 1000).toISOString().split('T')[0];
                    return recordingDate === todayDateStr;
                });

                if (todayRecordings.length === 0) {
                    recordingsList.innerHTML = '<p class="text-gray-500">No recordings found for today.</p>';
                    return;
                }

                recordingsList.innerHTML = '';

                for (const recording of todayRecordings) {
                    const item = document.createElement('div');
                    item.className = 'p-4 border rounded-lg shadow-md bg-white';
                    const recordingDate = new Date(recording.start_ts * 1000);

                    item.innerHTML = `
                        <p class="font-semibold">Room: ${recording.room_name}</p>
                        <p>Duration: ${(recording.duration / 60).toFixed(1)} min</p>
                        <p>Date: ${recordingDate.toLocaleString()}</p>
                    `;

                    const downloadButton = document.createElement('button');
                    downloadButton.className = 'mt-2 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition';
                    downloadButton.innerHTML = '<i class="fas fa-download"></i> Download';

                    downloadButton.addEventListener('click', async () => {
                        try {
                            const res = await fetch(`/api/recording/${recording.id}`);
                            const recordingData = await res.json();

                            if (recordingData.download_link) {
                                window.open(recordingData.download_link, '_blank');
                            } else {
                                alert('Recording not yet available for download.');
                            }
                        } catch (error) {
                            console.error('Error fetching recording:', error);
                            alert('Error trying to download recording.');
                        }
                    });

                    item.appendChild(downloadButton);
                    recordingsList.appendChild(item);
                }
            } catch (error) {
                console.error('Error loading recordings:', error);
                recordingsList.innerHTML = '<p class="text-red-500">Error loading recordings.</p>';
            }
        }

        document.getElementById('load-recordings-btn').addEventListener('click', () => loadTodayRecordings());

        /**
         * Daily Call Manager - Based on working Daily Laravel example
         */
        class DailyCallManager {
            constructor() {
                this.call = Daily.createCallObject();
                this.currentRoomUrl = null;
                this.isRecording = false;
                this.isScreenSharing = false;
                this.peerIdToName = {}; // Mapping from peerId to display name
                this.initialize();
            }

            async initialize() {
                this.setupEventListeners();
                document.getElementById('toggle-camera').addEventListener('click', () => this.toggleCamera());
                document.getElementById('toggle-mic').addEventListener('click', () => this.toggleMicrophone());
                document.getElementById('screen-share-btn').addEventListener('click', () => this.toggleScreenShare());
                document.getElementById('blur-btn').addEventListener('click', () => this.enableBackgroundBlur());
                this.setupChat();
            }

            setupEventListeners() {
                const events = {
                    'active-speaker-change': this.handleActiveSpeakerChange.bind(this),
                    'error': this.handleError.bind(this),
                    'joined-meeting': this.handleJoin.bind(this),
                    'left-meeting': this.handleLeave.bind(this),
                    'participant-joined': this.handleParticipantJoinedOrUpdated.bind(this),
                    'participant-left': this.handleParticipantLeft.bind(this),
                    'participant-updated': this.handleParticipantJoinedOrUpdated.bind(this),
                    'screen-share-started': this.handleScreenShareStarted.bind(this),
                    'screen-share-stopped': this.handleScreenShareStopped.bind(this),
                };

                Object.entries(events).forEach(([event, handler]) => {
                    this.call.on(event, handler);
                });
            }

            setupChat() {
                const chatInput = document.getElementById('chat-input');
                const sendChatBtn = document.getElementById('send-chat-btn');

                sendChatBtn.addEventListener('click', () => {
                    const message = chatInput.value.trim();
                    if (message) {
                        this.call.sendAppMessage({ text: message }, '*');
                        this.appendChatMessage('You', message);
                        chatInput.value = '';
                    }
                });

                this.call.on('app-message', (event) => {
                    const sender = event.from?.user_name || 'Participant';
                    const message = event.data.text;
                    this.appendChatMessage(sender, message);
                });
            }

            appendChatMessage(sender, message) {
                const chatBox = document.getElementById('chat-box');
                const messageEl = document.createElement('div');
                messageEl.className = 'mb-1';
                messageEl.innerHTML = `<span class="font-semibold">${sender}:</span> ${message}`;
                chatBox.appendChild(messageEl);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            async joinRoom(roomData, userRole = 'patient') {
                if (!roomData || (!roomData.url && !roomData.custom_url)) {
                    console.error('Room URL is required to join a room.');
                    this.showError('Room URL is required to join a room. Please contact support or try again.');
                    return;
                }

                // Use custom domain URL if available, otherwise use default
                const roomUrl = roomData.custom_url || roomData.url;
                this.currentRoomUrl = roomUrl;

                const joinOptions = {
                    url: roomUrl,
                    userName: userName
                };

                // Use token-based authentication if available
                if (roomData.tokens) {
                    const token = userRole === 'doctor' ? roomData.tokens.doctor_token : roomData.tokens.patient_token;
                    if (token) {
                        joinOptions.token = token;
                        console.log('Using token-based authentication');
                    }
                }

                try {
                    await this.call.join(joinOptions);
                    console.log('Joined room:', roomUrl);
                } catch (error) {
                    console.error('Failed to join room:', error);
                    throw error;
                }
            }

            async leave() {
                try {
                    await this.call.leave();
                    document.querySelectorAll('#videos video, audio').forEach((el) => {
                        el.srcObject = null;
                        el.remove();
                    });
                } catch (e) {
                    console.error('Leaving failed', e);
                }
            }

            async toggleCamera() {
                const currentState = this.call.localVideo();
                await this.call.setLocalVideo(!currentState);
            }

            async toggleMicrophone() {
                const currentState = this.call.localAudio();
                await this.call.setLocalAudio(!currentState);
            }

            toggleScreenShare() {
                if (this.isScreenSharing) {
                    this.call.stopScreenShare();
                } else {
                    this.call.startScreenShare();
                }
            }

            async enableBackgroundBlur() {
                const videoTrack = this.call.participants().local.tracks.video?.persistentTrack;
                if (!videoTrack) {
                    console.error('Local video track not found.');
                    return;
                }

                this.call.updateInputSettings({
                    video: {
                        processor: {
                            type: 'background-blur',
                            config: { strength: 0.9 },
                        },
                    },
                });
                console.log('Background blur activated!');
            }

            handleJoin(event) {
                console.log('Joined meeting:', event);
                document.getElementById('join-btn').disabled = true;
                document.getElementById('leave-btn').disabled = false;
                document.getElementById('record-btn').disabled = false;
                document.getElementById('toggle-camera').disabled = false;
                document.getElementById('toggle-mic').disabled = false;
                document.getElementById('screen-share-btn').disabled = false;
                this.updateAndDisplayParticipantCount();
            }

            async handleLeave(event) {
                console.log('Left meeting:', event);
                document.getElementById('join-btn').disabled = false;
                document.getElementById('leave-btn').disabled = true;
                document.getElementById('record-btn').disabled = true;
                document.getElementById('toggle-camera').disabled = true;
                document.getElementById('toggle-mic').disabled = true;
                document.getElementById('screen-share-btn').disabled = true;

                // Update appointment status
                try {
                    await fetch('/api/end-call', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ appointment_id: appointmentId }),
                    });
                } catch (error) {
                    console.error('Failed to update appointment status:', error);
                }
            }

            handleParticipantJoinedOrUpdated(event) {
                this.updateAndDisplayParticipantCount();
                // Update the mapping when a participant joins or updates
                if (event && event.participant) {
                    this.peerIdToName[event.participant.peerId] = event.participant.userName || event.participant.name || event.participant.peerId;
                }
                // Handle video/audio tracks here if needed
            }

            handleParticipantLeft(event) {
                this.updateAndDisplayParticipantCount();
                // Remove the mapping when a participant leaves
                if (event && event.participant) {
                    delete this.peerIdToName[event.participant.peerId];
                }
            }

            handleActiveSpeakerChange(event) {
                const peerId = event.activeSpeaker.peerId;
                const displayName = this.peerIdToName && this.peerIdToName[peerId] ? this.peerIdToName[peerId] : peerId;
                document.getElementById('active-speaker').textContent = `Active Speaker: ${displayName}`;
            }

            handleScreenShareStarted() {
                this.isScreenSharing = true;
                document.getElementById('screen-share-btn').innerHTML = '<i class="fas fa-desktop"></i> Stop Screen Share';
            }

            handleScreenShareStopped() {
                this.isScreenSharing = false;
                document.getElementById('screen-share-btn').innerHTML = '<i class="fas fa-desktop"></i> Start Screen Share';
            }

            handleError(e) {
                console.error('DAILY ERROR:', e.error ? e.error : e.errorMsg);
            }

            updateAndDisplayParticipantCount() {
                const participantCount = this.call.participantCounts().present + this.call.participantCounts().hidden;
                document.getElementById('participant-count').textContent = `Participants: ${participantCount}`;
            }

            showError(message) {
                let errorEl = document.getElementById('room-error-message');
                if (!errorEl) {
                    errorEl = document.createElement('div');
                    errorEl.id = 'room-error-message';
                    errorEl.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4';
                    const container = document.querySelector('.max-w-6xl') || document.body;
                    container.insertBefore(errorEl, container.firstChild);
                }
                errorEl.textContent = message;

                // Auto-remove after 10 seconds
                setTimeout(() => {
                    if (errorEl.parentNode) {
                        errorEl.parentNode.removeChild(errorEl);
                    }
                }, 10000);
            }
        }

        // Global dailyCallManager instance
        let dailyCallManager;

        /**
         * Initialize Daily Call Manager
         */
        document.addEventListener('DOMContentLoaded', async () => {
            dailyCallManager = new DailyCallManager();

            // Join button event
            document.getElementById('join-btn').addEventListener('click', async function() {
                try {
                    const res = await fetch('/api/create-room', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            appointment_id: appointmentId
                        }),
                    });

                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }

                    const roomData = await res.json();
                    console.log('Room data received:', roomData);

                    // Show custom domain info if available
                    if (roomData.custom_url) {
                        console.log('Using custom Daily domain:', roomData.custom_url);
                    }

                    await dailyCallManager.joinRoom(roomData, userRole);
                } catch (error) {
                    console.error('Failed to join room:', error);
                    alert('Failed to join consultation: ' + error.message);
                }
            });

            // Leave button event
            document.getElementById('leave-btn').addEventListener('click', function() {
                dailyCallManager.leave();
            });

            // Record button event
            document.getElementById('record-btn').addEventListener('click', async function() {
                if (!dailyCallManager.isRecording) {
                    const res = await fetch('/api/recording/start', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            appointment_id: appointmentId
                        }),
                    });
                    if (res.ok) {
                        dailyCallManager.isRecording = true;
                        this.innerHTML = '<i class="fas fa-stop"></i> Stop Recording';
                        this.className = this.className.replace('bg-yellow-500', 'bg-red-600').replace('hover:bg-yellow-600', 'hover:bg-red-700');
                    }
                } else {
                    const res = await fetch('/api/recording/stop', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            appointment_id: appointmentId
                        }),
                    });
                    if (res.ok) {
                        dailyCallManager.isRecording = false;
                        this.innerHTML = '<i class="fas fa-record-vinyl"></i> Record';
                        this.className = this.className.replace('bg-red-600', 'bg-yellow-500').replace('hover:bg-red-700', 'hover:bg-yellow-600');
                    }
                }
            });
        });

        // Function to end consultation and return to dashboard
        function endConsultationAndReturn() {
            if (dailyCallManager && dailyCallManager.call) {
                dailyCallManager.leave();
            }

            // Navigate back to appropriate dashboard
            const dashboardUrl = userRole === 'doctor' ? '{{ route("doctor.dashboard") }}' : '{{ route("patient.dashboard") }}';
            window.location.href = dashboardUrl;
        }

        // Handle browser back button
        window.addEventListener('beforeunload', function(e) {
            if (dailyCallManager && dailyCallManager.call && typeof dailyCallManager.call.meetingState === 'function' && dailyCallManager.call.meetingState() === 'joined') {
                dailyCallManager.leave();
            }
        });
    </script>
</body>
</html>
