@extends('layouts.app')

@section('title', 'Video Consultation')

@section('content')
<div class="min-h-screen bg-gray-900">
    <!-- Header -->
    <div class="bg-gray-800 border-b border-gray-700 px-4 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <h1 class="text-white text-lg font-semibold">
                    {{ $appointment->consultation_type === 'video' ? 'Video' : 'Audio' }} Consultation
                </h1>
                <span class="text-gray-300 text-sm">
                    with {{ Auth::user()->role === 'doctor' ? $appointment->patient->name : $appointment->doctor->name }}
                </span>
            </div>
            <div class="flex items-center space-x-3">
                <span id="call-timer" class="text-green-400 text-sm font-mono">00:00</span>
                <button id="end-call-btn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    End Call
                </button>
            </div>
        </div>
    </div>

    <!-- Video Call Container -->
    <div class="relative h-screen">
        <!-- Main video area -->
        <div id="call-container" class="w-full h-full bg-gray-900">
            <!-- Daily.co iframe will be inserted here -->
        </div>

        <!-- Loading state -->
        <div id="loading-state" class="absolute inset-0 bg-gray-900 flex items-center justify-center">
            <div class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto mb-4"></div>
                <p class="text-white text-lg">Connecting to consultation...</p>
                <p class="text-gray-400 text-sm mt-2">Please wait while we set up your {{ $appointment->consultation_type }} call</p>
            </div>
        </div>

        <!-- Error state -->
        <div id="error-state" class="absolute inset-0 bg-gray-900 flex items-center justify-center hidden">
            <div class="text-center max-w-md">
                <div class="text-red-500 text-6xl mb-4">⚠️</div>
                <h2 class="text-white text-xl font-semibold mb-2">Connection Failed</h2>
                <p id="error-message" class="text-gray-400 mb-6">Unable to connect to the consultation room.</p>
                <button id="retry-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    Try Again
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Daily.co SDK -->
<script src="https://unpkg.com/@daily-co/daily-js"></script>

<script>
class ConsultationCall {
    constructor() {
        this.callFrame = null;
        this.appointmentId = {{ $appointment->id }};
        this.consultationType = '{{ $appointment->consultation_type }}';
        this.userRole = '{{ Auth::user()->role === "doctor" ? "doctor" : "patient" }}';
        this.callStartTime = null;
        this.timerInterval = null;
        
        this.init();
    }

    async init() {
        try {
            // Start the consultation
            const response = await fetch(`/consultation/${this.appointmentId}/start`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.error || 'Failed to start consultation');
            }

            await this.setupDailyCall(data);
            
        } catch (error) {
            console.error('Consultation setup failed:', error);
            this.showError(error.message);
        }
    }

    async setupDailyCall(callData) {
        try {
            // Create Daily call frame
            this.callFrame = window.DailyIframe.createFrame({
                iframeStyle: {
                    position: 'fixed',
                    top: 0,
                    left: 0,
                    width: '100%',
                    height: '100%',
                    border: 'none',
                    zIndex: 1000
                },
                showLeaveButton: false,
                showFullscreenButton: true,
                showLocalVideo: this.consultationType === 'video',
                showParticipantsBar: false
            });

            // Set up event listeners
            this.setupEventListeners();

            // Join the call
            await this.callFrame.join({
                url: callData.room_url,
                token: callData.token,
                userName: this.userRole === 'doctor' ? 'Dr. {{ Auth::user()->name ?? "Doctor" }}' : '{{ Auth::user()->name ?? "Patient" }}',
                startVideoOff: this.consultationType !== 'video',
                startAudioOff: false
            });

            // Hide loading state
            document.getElementById('loading-state').classList.add('hidden');
            
        } catch (error) {
            console.error('Daily call setup failed:', error);
            this.showError('Failed to connect to video call');
        }
    }

    setupEventListeners() {
        // Call frame events
        this.callFrame
            .on('joined-meeting', () => {
                console.log('Joined consultation');
                this.startTimer();
            })
            .on('left-meeting', () => {
                console.log('Left consultation');
                this.endCall();
            })
            .on('error', (error) => {
                console.error('Daily call error:', error);
                this.showError('Call connection error');
            });

        // End call button
        document.getElementById('end-call-btn').addEventListener('click', () => {
            this.endCall();
        });

        // Retry button
        document.getElementById('retry-btn').addEventListener('click', () => {
            location.reload();
        });
    }

    startTimer() {
        this.callStartTime = Date.now();
        this.timerInterval = setInterval(() => {
            const elapsed = Math.floor((Date.now() - this.callStartTime) / 1000);
            const minutes = Math.floor(elapsed / 60).toString().padStart(2, '0');
            const seconds = (elapsed % 60).toString().padStart(2, '0');
            document.getElementById('call-timer').textContent = `${minutes}:${seconds}`;
        }, 1000);
    }

    async endCall() {
        try {
            // Stop timer
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
            }

            // Leave Daily call
            if (this.callFrame) {
                await this.callFrame.leave();
                this.callFrame.destroy();
            }

            // End consultation on server
            await fetch(`/consultation/${this.appointmentId}/end`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            // Redirect based on user role
            if (this.userRole === 'doctor') {
                window.location.href = '/doctor/dashboard';
            } else {
                window.location.href = '/patient/dashboard';
            }

        } catch (error) {
            console.error('End call failed:', error);
            // Force redirect anyway
            window.location.href = '/';
        }
    }

    showError(message) {
        document.getElementById('loading-state').classList.add('hidden');
        document.getElementById('error-message').textContent = message;
        document.getElementById('error-state').classList.remove('hidden');
    }
}

// Initialize consultation when page loads
document.addEventListener('DOMContentLoaded', () => {
    new ConsultationCall();
});
</script>
@endsection
