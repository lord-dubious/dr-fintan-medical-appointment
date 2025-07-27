@include('layouts.header')

<style>
    .voice_call_btn,
    .video_call_btn,
    .email_btn {
        background: #007bff;
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 5px;
        margin: 0 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .voice_call_btn:hover,
    .video_call_btn:hover,
    .email_btn:hover {
        background: #fff;
        color: #0056b3;
        border: 1px solid #0056b3;
    }

    .voice_call_btn i,
    .video_call_btn i,
    .email_btn i {
        font-size: 16px;
    }

    .text-danger {
        color: #dc3545;
        font-weight: bold;
    }

    /* Video Call Modal Styles */
    #videoCallModal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.8);
    }

    .video-call-container {
        background: white;
        margin: 5% auto;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 900px;
        position: relative;
    }

    .close-btn {
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 28px;
        cursor: pointer;
    }

    #localVideo {
        width: 200px;
        position: absolute;
        bottom: 20px;
        right: 20px;
        border: 2px solid white;
        border-radius: 5px;
        z-index: 100;
    }

    #remoteVideo {
        width: 100%;
        height: 500px;
        background: #333;
        border-radius: 5px;
    }

    .call-controls {
        margin-top: 15px;
        text-align: center;
    }

    .control-btn {
        background: #007bff;
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin: 0 10px;
        cursor: pointer;
        font-size: 18px;
    }

    .end-call-btn {
        background: #dc3545;
    }

    .call-status {
        text-align: center;
        margin: 10px 0;
        font-weight: bold;
    }
</style>

<body>
<!--============================
    APPOINTMENT START
==============================-->
<section class="dashboard mt_100 xs_mt_70 pb_100 xs_pb_70">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 wow fadeInLeft" data-wow-duration="1s">
                @include('layouts.usernavbar')
            </div>

            <div class="col-xl-9 col-lg-8 wow fadeInRight" data-wow-duration="1s">
                <div class="dashboard_content">
                    <h5>Appointment Details</h5>
                    <div class="appointment_history">
                        <div class="table-responsive">
                        <table class="table">
                            <tbody class="tf_dashboard__listing_body">
                                <tr>
                                    <th class="um_sn"><p>SL</p></th>
                                    <th class="um_name"><p>Doctor</p></th>
                                    <th class="um_name"><p>Department</p></th>
                                    <th class="um_date"><p>Date</p></th>
                                    <th class="um_duration"><p>Time</p></th>
                                    <th class="um_action"><p>Action</p></th>
                                </tr>
                                @foreach($patient->appointments as $index => $appointment)
                                <tr class="tabile_row">
                                    <td class="um_sn"><p>{{ $index + 1 }}</p></td>
                                    <td class="um_name">
                                        <p>{{ $appointment->doctor->name }}</p>
                                    </td>
                                    <td class="um_name">
                                        <p>{{ $appointment->doctor->department }}</p>
                                    </td>
                                    <td class="um_date">
                                        <p>{{ $appointment->appointment_date->format('M d, Y') }}</p>
                                        <span class="date_time">{{ $appointment->appointment_time }}</span>
                                    </td>
                                    <td class="um_duration">
                                        <p>{{ $appointment->appointment_time }}</p>
                                    </td>
                                    <td class="um_action">
                                        @if($appointment->status === 'pending')
                                            <span class="text-warning">Pending</span>
                                        @elseif($appointment->status === 'confirmed' && $appointment->appointment_date >= now()->toDateString())
                                            <!-- Action buttons for upcoming confirmed appointments -->
                                            <button class="voice_call_btn" title="Audio Call"
                                                onclick="initiateAudioCall('{{ $appointment->doctor->id }}', '{{ $appointment->id }}')">
                                                <i class="fas fa-phone"></i> Audio Call
                                            </button>
                                            <button class="video_call_btn" title="Video Call"
                                                onclick="startVideoConsultation('{{ $appointment->id }}')">
                                                <i class="fas fa-video"></i> Video Call
                                            </button>
                                            <button class="email_btn" title="Send Email" onclick="sendEmail()">
                                                <i class="fas fa-envelope"></i> Email
                                            </button>
                                        @else
                                            <span class="text-danger">
                                                {{ $appointment->status === 'cancelled' ? 'Cancelled' : 'Expired' }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
    APPOINTMENT END
==============================-->

<!-- Video Call Modal -->
<div id="videoCallModal" data-appointment-id="">
    <div class="video-call-container">
        <span class="close-btn" onclick="endCall()">&times;</span>
        <div class="call-status" id="callStatus">Connecting to doctor...</div>
        <video id="remoteVideo" autoplay playsinline></video>
        <video id="localVideo" autoplay playsinline muted></video>
        <div class="call-controls">
            <button class="control-btn" onclick="toggleMute()">
                <i class="fas fa-microphone"></i>
            </button>
            <button class="control-btn" onclick="toggleVideo()">
                <i class="fas fa-video"></i>
            </button>
            <button class="control-btn end-call-btn" onclick="endCall()">
                <i class="fas fa-phone-slash"></i>
            </button>
        </div>
    </div>
</div>

<!-- Include Daily.co JavaScript SDK -->
<script src="https://unpkg.com/@daily-co/daily-js"></script>
<script>
    // Daily.co variables
    let dailyCall;
    let currentRoom;
    let isMuted = false;
    let isVideoOff = false;
    let hasMediaPermissions = false;

    // Crypto polyfill for older browsers
    if (!crypto.randomUUID) {
        crypto.randomUUID = function() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        };
    }

    // Initialize Daily.co when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initializeDailyCall();
    });

    async function initializeDailyCall() {
        try {
            console.log('Initializing Daily.co for patient-{{ $patient->id }}');

            // Check if we're on HTTPS (required for camera/microphone)
            if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
                throw new Error('HTTPS is required for camera and microphone access. Please use https://ekochin.violetmethods.com');
            }

            // Check if we have the necessary APIs
            if (!navigator.mediaDevices) {
                throw new Error('Media devices not supported. Please use a modern browser with HTTPS.');
            }

            // Clean up existing call object if it exists
            if (dailyCall) {
                dailyCall.destroy();
            }

            // Create Daily call object with minimal configuration
            dailyCall = DailyIframe.createCallObject();

            // Set up event listeners
            dailyCall
                .on('joined-meeting', handleJoinedMeeting)
                .on('participant-joined', handleParticipantJoined)
                .on('participant-left', handleParticipantLeft)
                .on('participant-updated', handleParticipantUpdated)
                .on('left-meeting', handleLeftMeeting)
                .on('camera-error', handleCameraError)
                .on('error', handleError);

            console.log('Daily.co initialized successfully');

            // Request media permissions after initialization
            setTimeout(async () => {
                await requestMediaPermissions();
            }, 1000);

        } catch (err) {
            console.error('Daily.co initialization failed:', err);
            showAlert('Failed to initialize video call system: ' + err.message, 'error');
        }
    }

    // Request camera and microphone permissions
    async function requestMediaPermissions() {
        try {
            console.log('Requesting media permissions...');

            // Check if mediaDevices is available
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                throw new Error('Media devices not supported. Please use HTTPS or a modern browser.');
            }

            // Request both camera and microphone permissions
            const stream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            });

            // Stop the stream immediately - we just needed permissions
            stream.getTracks().forEach(track => track.stop());

            hasMediaPermissions = true;
            console.log('Media permissions granted');

        } catch (err) {
            console.error('Media permissions denied:', err);
            hasMediaPermissions = false;

            // Show user-friendly error message
            let errorMessage = 'Camera and microphone access is required for video calls. ';
            if (err.name === 'NotAllowedError') {
                errorMessage += 'Please allow camera and microphone access in your browser settings.';
            } else if (err.name === 'NotFoundError') {
                errorMessage += 'No camera or microphone found. Please connect a camera and microphone.';
            } else if (err.message.includes('not supported')) {
                errorMessage += 'Please use HTTPS or a modern browser that supports media devices.';
            } else {
                errorMessage += 'Please check your camera and microphone settings.';
            }

            showAlert(errorMessage, 'error');
        }
    }

    // Shared helper function for creating and joining consultation rooms
    async function createAndJoinConsultation(appointmentId, consultationType = 'video') {
        const endpoint = consultationType === 'audio' ? '/api/consultation/create-audio' : '/api/consultation/create-room';
        const statusText = consultationType === 'audio' ? 'Creating audio consultation...' : 'Creating consultation room...';

        document.getElementById('callStatus').textContent = statusText;

        // Check media permissions first
        if (!hasMediaPermissions) {
            await requestMediaPermissions();
            if (!hasMediaPermissions) {
                throw new Error('Camera and microphone permissions are required for video calls');
            }
        }

        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                appointment_id: appointmentId
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (!data.success) {
            throw new Error(data.error || `Failed to create ${consultationType} consultation`);
        }

        document.getElementById('callStatus').textContent = `Joining ${consultationType} consultation...`;

        // Join the Daily.co room with proper configuration
        await dailyCall.join({
            url: data.room_url,
            token: data.tokens.patient_token,
            userName: '{{ $patient->name }}',
            userData: {
                role: 'patient',
                appointmentId: appointmentId
            }
        });

        // Turn off video for audio-only calls
        if (consultationType === 'audio') {
            await dailyCall.setLocalVideo(false);
        }

        currentRoom = data.room_name;
        console.log(`Successfully joined Daily.co ${consultationType} consultation:`, data.room_name);

        return data;
    }

    // Simplified video consultation function
    function startVideoConsultation(appointmentId) {
        // Navigate to prejoin page first for device testing
        const consultationUrl = `/video-call/${appointmentId}`;
        window.location.href = consultationUrl;
    }

    // Legacy video call function - Daily.co implementation (keeping for compatibility)
    async function initiateVideoCall(doctorId, appointmentId) {
        try {
            console.log(`Attempting to call doctor-${doctorId} for appointment-${appointmentId}`);

            // Show call modal and set appointment ID
            const videoModal = document.getElementById('videoCallModal');
            const callStatus = document.getElementById('callStatus');

            videoModal.style.display = 'block';
            videoModal.setAttribute('data-appointment-id', appointmentId);
            callStatus.textContent = 'Creating consultation room...';

            await createAndJoinConsultation(appointmentId, 'video');
            console.log('Video call initiated successfully');
            
        } catch (err) {
            console.error('Call initiation failed:', err);
            document.getElementById('callStatus').textContent = 
                'Failed to start call: ' + (err.message || 'Unknown error');
            setTimeout(endCall, 3000);
        }
    }

    // Audio-only call function
    async function initiateAudioCall(doctorId, appointmentId) {
        try {
            console.log(`Attempting audio call with doctor-${doctorId} for appointment-${appointmentId}`);

            const videoModal = document.getElementById('videoCallModal');
            const callStatus = document.getElementById('callStatus');

            videoModal.style.display = 'block';
            videoModal.setAttribute('data-appointment-id', appointmentId);
            callStatus.textContent = 'Creating audio consultation...';

            await createAndJoinConsultation(appointmentId, 'audio');
            console.log('Audio call initiated successfully');

        } catch (err) {
            console.error('Audio call failed:', err);
            document.getElementById('callStatus').textContent = 'Audio call failed: ' + err.message;
            setTimeout(endCall, 3000);
        }
    }

    // Daily.co event handlers
    function handleJoinedMeeting(event) {
        console.log('Joined meeting:', event);
        document.getElementById('callStatus').textContent = 'Connected to consultation';

        // Set up local video
        const localVideo = document.getElementById('localVideo');
        const localParticipant = dailyCall.participants().local;

        if (localParticipant.video) {
            localVideo.srcObject = new MediaStream([localParticipant.video.track]);
            localVideo.play();
        }
    }

    function handleParticipantJoined(event) {
        console.log('Participant joined:', event.participant);
        updateParticipantVideo(event.participant);
    }

    function handleParticipantLeft(event) {
        console.log('Participant left:', event.participant);
        // Clear remote video if doctor left
        if (event.participant.user_id && event.participant.user_id.startsWith('doctor-')) {
            document.getElementById('remoteVideo').srcObject = null;
        }
    }

    function handleParticipantUpdated(event) {
        console.log('Participant updated:', event.participant);
        updateParticipantVideo(event.participant);
    }

    function handleLeftMeeting(event) {
        console.log('Left meeting:', event);
        endCall();
    }

    function handleError(event) {
        console.error('Daily.co error:', event);
        document.getElementById('callStatus').textContent = 'Connection error: ' + event.errorMsg;
    }

    function updateParticipantVideo(participant) {
        // Update remote video for doctor
        if (participant.user_id && participant.user_id.startsWith('doctor-')) {
            const remoteVideo = document.getElementById('remoteVideo');
            if (participant.video && participant.video.track) {
                remoteVideo.srcObject = new MediaStream([participant.video.track]);
                remoteVideo.play();
            } else {
                remoteVideo.srcObject = null;
            }
        }
    }

    // End call function - IMPROVED
    async function endCall() {
        try {
            console.log('Ending consultation call');

            if (dailyCall && dailyCall.meetingState() !== 'left-meeting') {
                // Leave the Daily.co meeting
                await dailyCall.leave();
            }

            // Clear video elements
            document.getElementById('localVideo').srcObject = null;
            document.getElementById('remoteVideo').srcObject = null;

            // Hide modal
            document.getElementById('videoCallModal').style.display = 'none';

            // Reset call status
            document.getElementById('callStatus').textContent = 'Call ended';

            // Clean up room if needed
            if (currentRoom) {
                try {
                    await fetch('/api/consultation/end', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Authorization': 'Bearer ' + (localStorage.getItem('auth_token') || '')
                        },
                        body: JSON.stringify({
                            room_name: currentRoom,
                            appointment_id: getCurrentAppointmentId()
                        })
                    });
                } catch (err) {
                    console.error('Error cleaning up room:', err);
                }
                currentRoom = null;
            }

            console.log('Call ended successfully');
        } catch (err) {
            console.error('Error ending call:', err);
        }
    }
    
    // Toggle mute function - Daily.co implementation
    async function toggleMute() {
        try {
            if (dailyCall) {
                const currentAudioState = dailyCall.localAudio();
                await dailyCall.setLocalAudio(!currentAudioState);
                isMuted = !currentAudioState;

                const muteBtn = document.querySelector('.control-btn:nth-child(1)');
                muteBtn.innerHTML = isMuted
                    ? '<i class="fas fa-microphone-slash"></i>'
                    : '<i class="fas fa-microphone"></i>';

                console.log('Audio toggled:', isMuted ? 'muted' : 'unmuted');
            }
        } catch (err) {
            console.error('Error toggling mute:', err);
        }
    }

    // Toggle video function - Daily.co implementation
    async function toggleVideo() {
        try {
            if (dailyCall) {
                const currentVideoState = dailyCall.localVideo();
                await dailyCall.setLocalVideo(!currentVideoState);
                isVideoOff = !currentVideoState;

                const videoBtn = document.querySelector('.control-btn:nth-child(2)');
                videoBtn.innerHTML = isVideoOff
                    ? '<i class="fas fa-video-slash"></i>'
                    : '<i class="fas fa-video"></i>';

                console.log('Video toggled:', isVideoOff ? 'off' : 'on');
            }
        } catch (err) {
            console.error('Error toggling video:', err);
        }
    }

    // Helper function to get current appointment ID
    function getCurrentAppointmentId() {
        const videoModal = document.getElementById('videoCallModal');
        if (!videoModal) {
            console.warn('Video call modal not found');
            return null;
        }
        return videoModal.getAttribute('data-appointment-id') || null;
    }

    // Simple alert function for user feedback
    function showAlert(message, type = 'info') {
        // Create a simple alert div
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} alert-dismissible fade show`;
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.style.maxWidth = '400px';

        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(alertDiv);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 5000);
    }
</script>
</body>
</html>
