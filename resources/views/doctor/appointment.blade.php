@include('layouts.header')

<style>
    /* Improved message modal styling */
    .message-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.8);
        overflow: auto;
    }

    

    .message-modal-content {
        background: white;
        margin: 5% auto;
        padding: 25px;
        border-radius: 10px;
        width: 60%;
        max-width: 700px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    .close-message {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.3s;
    }
    
    .close-message:hover {
        color: #333;
    }
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
                @include('layouts.doctor_navbar')
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
                            </thead>
                            <tbody class="tf_dashboard__listing_body">
                                @foreach($doctor->appointments as $index => $appointment)
                                <tr class="tabile_row">
                                    <td class="um_sn">{{ $index + 1 }}</td>
                                    <td class="um_name">
                                        {{ $appointment->patient->name }}
                                    </td>
                                    <td class="um_date">
                                        {{ $appointment->appointment_date->format('M d, Y') }}
                                    </td>
                                    <td class="um_duration">
                                        {{ $appointment->appointment_time }}
                                    </td>
                                    <td>
                                       @include('components.status-badge', ['status' => $appointment->status])
                                            </td>
                                            @if($appointment->status=='pending' || $appointment->status=='rejected' )
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-success btn-sm approve-btn" data-id="{{ $appointment->id }}">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                    <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $appointment->id }}">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </div>
                                            </td>
                                            @endif
                                    <td class="um_action">
                                        <!-- View Message Button -->
                                        <button class="action-btn view_message_btn" 
                                                onclick="showMessage('{{ addslashes($appointment->message) }}')">
                                            <i class="fas fa-envelope"></i> Message
                                        </button>
                                        
                                        @if($appointment->status === 'confirmed' && $appointment->appointment_date >= now()->toDateString())
                                            <!-- Action buttons for upcoming confirmed appointments -->
                                            <button class="action-btn voice_call_btn" 
                                                    onclick="initiateVoiceCall('{{ $appointment->patient->mobile }}')">
                                                <i class="fas fa-phone"></i> Call
                                            </button>
                                            <button class="action-btn video_call_btn"
                                                    onclick="startVideoConsultation('{{ $appointment->id }}')">
                                                <i class="fas fa-video"></i> Video
                                            </button>
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

<!-- Message Modal -->
<div id="messageModal" class="message-modal">
    <div class="message-modal-content">
        <span class="close-message" onclick="closeMessageModal()">&times;</span>
        <h4><i class="fas fa-envelope-open-text me-2"></i>Patient Message</h4>
        <div id="messageContent" class="mt-3 p-3 bg-light rounded">
            <!-- Message content will be inserted here -->
        </div>
        <div class="mt-3 text-end">
            <button class="btn btn-secondary" onclick="closeMessageModal()">Close</button>
        </div>
    </div>
</div>

<!-- Video Call Modal -->
<div id="videoCallModal">
    <div class="video-call-container">
        <span class="close-btn" onclick="endCall()">&times;</span>
        <div class="call-status" id="callStatus">Waiting for connection...</div>
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

<!-- Daily.co JavaScript SDK -->
<script src="https://unpkg.com/@daily-co/daily-js"></script>

<!-- In your doctor dashboard, update the JavaScript section: -->
<script>


document.querySelectorAll('.approve-btn, .reject-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const appointmentId = this.getAttribute('data-id');
            const action = this.classList.contains('approve-btn') ? 'confirmed' : 'cancelled';
            const button = this;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }
            // Disable button during processing
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing';

            fetch(`/doctor/appointments/${appointmentId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                   'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: action
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Find the row and update status
                    const row = button.closest('tr');
                    row.querySelector('.badge').outerHTML = data.status_badge;
                    
                    // Remove action buttons
                    row.querySelector('td:last-child').innerHTML = 
                        `<span class="text-muted">Processed</span>`;
                    
                    // Show success message
                    showToast('success', data.message);
                }
            })
            .catch(error => {
                button.disabled = false;
                button.innerHTML = action === 'confirmed' 
                    ? '<i class="fas fa-check"></i> Approve' 
                    : '<i class="fas fa-times"></i> Reject';
                
                const message = error.message || 'An error occurred';
                showToast('error', message);
            });
        });
    });

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
        initializeDailyConnection();
    });

    async function initializeDailyConnection() {
        try {
            console.log('Initializing Daily.co for doctor-{{ $doctor->id }}');

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

    // Simplified video consultation function
    function startVideoConsultation(appointmentId) {
        // Navigate to prejoin page first for device testing
        const consultationUrl = `/video-call/${appointmentId}`;
        window.location.href = consultationUrl;
    }

    // Legacy video call function for doctors (keeping for compatibility)
    async function initiateVideoCall(appointmentId, doctorId) {
        try {
            console.log(`Doctor initiating video call for appointment-${appointmentId}`);

            // Check media permissions first
            if (!hasMediaPermissions) {
                await requestMediaPermissions();
                if (!hasMediaPermissions) {
                    throw new Error('Camera and microphone permissions are required for video calls');
                }
            }

            const videoModal = document.getElementById('videoCallModal');
            const callStatus = document.getElementById('callStatus');

            videoModal.style.display = 'block';
            videoModal.setAttribute('data-appointment-id', appointmentId);
            callStatus.textContent = 'Creating consultation room...';

            // Create consultation room via API
            const response = await fetch('/api/consultation/create-room', {
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
                throw new Error(data.error || 'Failed to create consultation room');
            }

            callStatus.textContent = 'Joining consultation...';

            // Join the Daily.co room with proper configuration
            await dailyCall.join({
                url: data.room_url,
                token: data.tokens.doctor_token,
                userName: 'Dr. {{ $doctor->name }}',
                userData: {
                    role: 'doctor',
                    appointmentId: appointmentId
                }
            });

            currentRoom = data.room_name;
            console.log('Doctor successfully joined Daily.co room:', data.room_name);
            callStatus.textContent = 'Connected to consultation';

        } catch (err) {
            console.error('Video call failed:', err);
            const errorMessage = err.message || 'Failed to start video call';
            document.getElementById('callStatus').textContent = 'Video call failed: ' + errorMessage;
            showAlert('Video call failed: ' + errorMessage, 'error');
            setTimeout(endCall, 3000);
        }
    }

    // Daily.co event handlers
    function handleJoinedMeeting(event) {
        console.log('Doctor joined meeting:', event);
        document.getElementById('callStatus').textContent = 'Waiting for patient...';

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
        document.getElementById('callStatus').textContent = 'Patient connected';
        updateParticipantVideo(event.participant);
    }

    function handleParticipantLeft(event) {
        console.log('Participant left:', event.participant);
        if (event.participant.user_id && event.participant.user_id.startsWith('patient-')) {
            document.getElementById('remoteVideo').srcObject = null;
            document.getElementById('callStatus').textContent = 'Patient disconnected';
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
        let errorMessage = 'Connection error: ';

        if (event.errorMsg) {
            errorMessage += event.errorMsg;
        } else if (event.error) {
            errorMessage += event.error;
        } else {
            errorMessage += 'Unknown error occurred';
        }

        document.getElementById('callStatus').textContent = errorMessage;
        showAlert(errorMessage, 'error');
    }

    function handleCameraError(event) {
        console.error('Camera error:', event);
        let errorMessage = 'Camera error: ';

        if (event.errorMsg) {
            errorMessage += event.errorMsg;
        } else {
            errorMessage += 'Please check your camera permissions and try again.';
        }

        showAlert(errorMessage, 'error');
        document.getElementById('callStatus').textContent = errorMessage;
    }

    function updateParticipantVideo(participant) {
        // Update remote video for patient
        if (participant.user_id && participant.user_id.startsWith('patient-')) {
            const remoteVideo = document.getElementById('remoteVideo');
            if (participant.video && participant.video.track) {
                remoteVideo.srcObject = new MediaStream([participant.video.track]);
                remoteVideo.play();
            } else {
                remoteVideo.srcObject = null;
            }
        }
    }

    // Daily.co endCall function
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

    // Message modal functions
    function showMessage(message) {
        const messageContent = document.getElementById('messageContent');
        messageContent.innerHTML = message 
            ? `<p>${message.replace(/\n/g, '<br>')}</p>` 
            : '<p class="text-muted">No message provided</p>';
        document.getElementById('messageModal').style.display = 'block';
    }

    function closeMessageModal() {
        document.getElementById('messageModal').style.display = 'none';
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