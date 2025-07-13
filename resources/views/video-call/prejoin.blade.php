<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prepare for Consultation - Dr. Fintan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <div class="bg-blue-600 text-white p-4">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ Auth::user()->role === 'doctor' ? route('doctor.dashboard') : route('patient.dashboard') }}" 
                   class="bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded transition-colors">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                <h1 class="text-xl font-bold">Prepare for Consultation #{{ $appointmentId }}</h1>
            </div>
            <div class="text-blue-200">
                {{ Auth::user()->role === 'doctor' ? 'Doctor' : 'Patient' }}: {{ Auth::user()->name ?? Auth::user()->email }}
            </div>
        </div>
    </div>

    <!-- Prejoin Container -->
    <div class="max-w-4xl mx-auto p-6">
        <!-- Camera Preview -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                <i class="fas fa-video mr-2 text-blue-600"></i>
                Camera & Microphone Check
            </h2>
            
            <!-- Video Preview -->
            <div class="relative bg-gray-900 rounded-lg overflow-hidden mb-4" style="aspect-ratio: 16/9;">
                <video id="preview-video" autoplay muted class="w-full h-full object-cover"></video>
                <div id="video-placeholder" class="absolute inset-0 flex items-center justify-center text-white">
                    <div class="text-center">
                        <i class="fas fa-video-slash text-4xl mb-2"></i>
                        <p>Camera Preview</p>
                    </div>
                </div>
            </div>

            <!-- Device Controls -->
            <div class="flex flex-wrap gap-4 mb-4">
                <button id="toggle-camera" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-video mr-2"></i>
                    <span>Turn On Camera</span>
                </button>
                
                <button id="toggle-microphone" class="flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-microphone mr-2"></i>
                    <span>Turn On Microphone</span>
                </button>
                
                <button id="test-speakers" class="flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-volume-up mr-2"></i>
                    Test Speakers
                </button>
            </div>

            <!-- Device Selectors -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Camera</label>
                    <select id="camera-select" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Camera</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Microphone</label>
                    <select id="microphone-select" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2">
                        <option value="">Select Microphone</option>
                    </select>
                    <!-- Microphone Level Indicator -->
                    <div id="microphone-level-container" class="hidden">
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-600">Level:</span>
                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                <div id="microphone-level-bar" class="bg-green-500 h-2 rounded-full transition-all duration-100" style="width: 0%"></div>
                            </div>
                            <span id="microphone-level-text" class="text-xs text-gray-600">0%</span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Speakers</label>
                    <select id="speaker-select" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Speakers</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Connection Test -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                <i class="fas fa-wifi mr-2 text-green-600"></i>
                Connection Test
            </h2>
            
            <div id="connection-status" class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div id="connection-indicator" class="w-3 h-3 rounded-full bg-gray-400 mr-2"></div>
                    <span id="connection-text">Testing connection...</span>
                </div>
                <button id="test-connection" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Test Again
                </button>
            </div>
        </div>

        <!-- Ready to Join -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold mb-2">Ready to Join?</h2>
                    <p class="text-gray-600">Make sure your camera and microphone are working properly.</p>
                </div>
                
                <div class="flex space-x-4">
                    <button id="join-consultation" 
                            class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
                            disabled>
                        <i class="fas fa-video mr-2"></i>
                        Join Consultation
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/@daily-co/daily-js"></script>
    <script>
        // Global variables
        let appointmentId = @json($appointmentId);
        let userRole = @json(Auth::user()->role);
        let userName = @json(Auth::user()->name ?? Auth::user()->email);
        
        let currentStream = null;
        let microphoneStream = null;
        let cameraEnabled = false;
        let microphoneEnabled = false;
        let devices = { cameras: [], microphones: [], speakers: [] };

        // Initialize prejoin
        document.addEventListener('DOMContentLoaded', async () => {
            await initializeDevices();
            await testConnection();
            setupEventListeners();
        });

        // Ensure all media tracks are stopped before navigating away
        window.addEventListener('beforeunload', () => {
            stopAllMediaTracks();
        });

        function stopAllMediaTracks() {
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
                currentStream = null;
            }
            if (microphoneStream) {
                microphoneStream.getTracks().forEach(track => track.stop());
                microphoneStream = null;
            }
            // Clean up audio analysis resources
            removeAudioLevelDetection();
        }

        async function initializeDevices() {
            try {
                // Request permissions
                const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                stream.getTracks().forEach(track => track.stop());

                // Get available devices
                const deviceList = await navigator.mediaDevices.enumerateDevices();
                
                devices.cameras = deviceList.filter(device => device.kind === 'videoinput');
                devices.microphones = deviceList.filter(device => device.kind === 'audioinput');
                devices.speakers = deviceList.filter(device => device.kind === 'audiooutput');

                populateDeviceSelectors();
            } catch (error) {
                console.error('Failed to initialize devices:', error);
                showError('Failed to access camera and microphone. Please check permissions.');
            }
        }

        function populateDeviceSelectors() {
            const cameraSelect = document.getElementById('camera-select');
            const microphoneSelect = document.getElementById('microphone-select');
            const speakerSelect = document.getElementById('speaker-select');

            // Clear previous options
            if (cameraSelect) cameraSelect.innerHTML = '<option value="">Select Camera</option>';
            if (microphoneSelect) microphoneSelect.innerHTML = '<option value="">Select Microphone</option>';
            if (speakerSelect) speakerSelect.innerHTML = '<option value="">Select Speakers</option>';

            // Populate cameras
            devices.cameras.forEach(device => {
                const option = document.createElement('option');
                option.value = device.deviceId;
                option.textContent = device.label || `Camera ${devices.cameras.indexOf(device) + 1}`;
                cameraSelect.appendChild(option);
            });

            // Populate microphones
            devices.microphones.forEach(device => {
                const option = document.createElement('option');
                option.value = device.deviceId;
                option.textContent = device.label || `Microphone ${devices.microphones.indexOf(device) + 1}`;
                microphoneSelect.appendChild(option);
            });

            // Populate speakers
            devices.speakers.forEach(device => {
                const option = document.createElement('option');
                option.value = device.deviceId;
                option.textContent = device.label || `Speaker ${devices.speakers.indexOf(device) + 1}`;
                speakerSelect.appendChild(option);
            });

            // Select first available devices
            if (devices.cameras.length > 0) cameraSelect.value = devices.cameras[0].deviceId;
            if (devices.microphones.length > 0) microphoneSelect.value = devices.microphones[0].deviceId;
            if (devices.speakers.length > 0) speakerSelect.value = devices.speakers[0].deviceId;
        }

        async function testConnection() {
            const indicator = document.getElementById('connection-indicator');
            const text = document.getElementById('connection-text');

            indicator.className = 'w-3 h-3 rounded-full bg-yellow-400 mr-2';
            text.textContent = 'Testing connection...';

            try {
                // Try authenticated health check first
                let response = await fetch('/api/health-check', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                // If authenticated endpoint fails, try public fallback
                if (!response.ok) {
                    console.log('Authenticated health check failed, trying public endpoint...');
                    response = await fetch('/health-check', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                }

                if (response.ok) {
                    const data = await response.json();
                    if (data.status === 'ok') {
                        indicator.className = 'w-3 h-3 rounded-full bg-green-400 mr-2';
                        text.textContent = 'Connection good';
                        document.getElementById('join-consultation').disabled = false;
                    } else {
                        throw new Error(data.message || 'Health check failed');
                    }
                } else {
                    throw new Error(`Connection test failed: ${response.status} ${response.statusText}`);
                }
            } catch (error) {
                indicator.className = 'w-3 h-3 rounded-full bg-red-400 mr-2';
                text.textContent = 'Connection issues detected';
                console.error('Connection test failed:', error);
            }
        }

        function setupEventListeners() {
            // Camera toggle
            document.getElementById('toggle-camera').addEventListener('click', toggleCamera);
            
            // Microphone toggle
            document.getElementById('toggle-microphone').addEventListener('click', toggleMicrophone);
            
            // Test speakers
            document.getElementById('test-speakers').addEventListener('click', testSpeakers);
            
            // Test connection
            document.getElementById('test-connection').addEventListener('click', testConnection);
            
            // Join consultation
            document.getElementById('join-consultation').addEventListener('click', joinConsultation);
            
            // Device selectors
            document.getElementById('camera-select').addEventListener('change', updateCamera);
            document.getElementById('microphone-select').addEventListener('change', updateMicrophone);
        }

        async function toggleCamera() {
            const button = document.getElementById('toggle-camera');
            const icon = button.querySelector('i');
            const span = button.querySelector('span');

            if (!cameraEnabled) {
                try {
                    await startCamera();
                    cameraEnabled = true;
                    icon.className = 'fas fa-video mr-2';
                    span.textContent = 'Turn Off Camera';
                    button.className = button.className.replace('bg-blue-600 hover:bg-blue-700', 'bg-red-600 hover:bg-red-700');
                } catch (error) {
                    showError('Failed to start camera: ' + error.message);
                }
            } else {
                stopCamera();
                cameraEnabled = false;
                icon.className = 'fas fa-video-slash mr-2';
                span.textContent = 'Turn On Camera';
                button.className = button.className.replace('bg-red-600 hover:bg-red-700', 'bg-blue-600 hover:bg-blue-700');
            }
        }

        async function startCamera() {
            const cameraSelect = document.getElementById('camera-select');
            const constraints = {
                video: { deviceId: cameraSelect.value ? { exact: cameraSelect.value } : undefined },
                audio: false
            };

            currentStream = await navigator.mediaDevices.getUserMedia(constraints);
            const video = document.getElementById('preview-video');
            const placeholder = document.getElementById('video-placeholder');
            
            video.srcObject = currentStream;
            placeholder.style.display = 'none';
        }

        function stopCamera() {
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
                currentStream = null;
            }
            
            const video = document.getElementById('preview-video');
            const placeholder = document.getElementById('video-placeholder');
            
            video.srcObject = null;
            placeholder.style.display = 'flex';
        }

        async function toggleMicrophone() {
            const button = document.getElementById('toggle-microphone');
            const icon = button.querySelector('i');
            const span = button.querySelector('span');

            if (!microphoneEnabled) {
                try {
                    await startMicrophone();
                    microphoneEnabled = true;
                    icon.className = 'fas fa-microphone mr-2';
                    span.textContent = 'Turn Off Microphone';
                    button.className = button.className.replace('bg-green-600 hover:bg-green-700', 'bg-red-600 hover:bg-red-700');
                } catch (error) {
                    showError('Failed to start microphone: ' + error.message);
                }
            } else {
                stopMicrophone();
                microphoneEnabled = false;
                icon.className = 'fas fa-microphone-slash mr-2';
                span.textContent = 'Turn On Microphone';
                button.className = button.className.replace('bg-red-600 hover:bg-red-700', 'bg-green-600 hover:bg-green-700');
            }
        }

        async function startMicrophone() {
            const microphoneSelect = document.getElementById('microphone-select');
            const constraints = {
                audio: {
                    deviceId: microphoneSelect.value ? { exact: microphoneSelect.value } : undefined,
                    echoCancellation: true,
                    noiseSuppression: true,
                    autoGainControl: true
                },
                video: false
            };

            try {
                microphoneStream = await navigator.mediaDevices.getUserMedia(constraints);

                // Add visual feedback for microphone level
                addMicrophoneLevelIndicator();

                // Optional: Add actual audio level detection
                addAudioLevelDetection();
            } catch (error) {
                console.error('Failed to start microphone:', error);
                throw new Error('Could not access microphone. Please check permissions.');
            }
        }

        function stopMicrophone() {
            if (microphoneStream) {
                microphoneStream.getTracks().forEach(track => track.stop());
                microphoneStream = null;
            }
            removeMicrophoneLevelIndicator();
            removeAudioLevelDetection();
        }

        function addMicrophoneLevelIndicator() {
            // Simple visual feedback - could be enhanced with actual level detection
            const micButton = document.getElementById('toggle-microphone');
            micButton.style.boxShadow = '0 0 10px rgba(34, 197, 94, 0.5)';
        }

        function removeMicrophoneLevelIndicator() {
            const micButton = document.getElementById('toggle-microphone');
            micButton.style.boxShadow = '';
        }

        let audioContext = null;
        let analyser = null;
        let animationFrame = null;

        function addAudioLevelDetection() {
            if (!microphoneStream) return;

            try {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
                analyser = audioContext.createAnalyser();
                const source = audioContext.createMediaStreamSource(microphoneStream);

                analyser.fftSize = 256;
                source.connect(analyser);

                const dataArray = new Uint8Array(analyser.frequencyBinCount);

                function updateLevel() {
                    analyser.getByteFrequencyData(dataArray);
                    const average = dataArray.reduce((a, b) => a + b) / dataArray.length;

                    // Update visual feedback based on audio level
                    const micButton = document.getElementById('toggle-microphone');
                    const levelBar = document.getElementById('microphone-level-bar');
                    const levelText = document.getElementById('microphone-level-text');
                    const levelContainer = document.getElementById('microphone-level-container');

                    const intensity = Math.min(average / 50, 1); // Normalize to 0-1
                    const percentage = Math.round(intensity * 100);

                    // Update button glow
                    if (intensity > 0.1) {
                        micButton.style.boxShadow = `0 0 ${10 + intensity * 10}px rgba(34, 197, 94, ${0.3 + intensity * 0.4})`;
                    }

                    // Update level bar
                    if (levelBar && levelText && levelContainer) {
                        levelContainer.classList.remove('hidden');
                        levelBar.style.width = `${percentage}%`;
                        levelText.textContent = `${percentage}%`;

                        // Change color based on level
                        if (percentage > 70) {
                            levelBar.className = 'bg-red-500 h-2 rounded-full transition-all duration-100';
                        } else if (percentage > 30) {
                            levelBar.className = 'bg-green-500 h-2 rounded-full transition-all duration-100';
                        } else {
                            levelBar.className = 'bg-yellow-500 h-2 rounded-full transition-all duration-100';
                        }
                    }

                    animationFrame = requestAnimationFrame(updateLevel);
                }

                updateLevel();
            } catch (error) {
                console.warn('Audio level detection not supported:', error);
            }
        }

        function removeAudioLevelDetection() {
            if (animationFrame) {
                cancelAnimationFrame(animationFrame);
                animationFrame = null;
            }
            if (audioContext) {
                audioContext.close();
                audioContext = null;
            }
            analyser = null;

            // Hide level indicator
            const levelContainer = document.getElementById('microphone-level-container');
            if (levelContainer) {
                levelContainer.classList.add('hidden');
            }
        }

        async function testSpeakers() {
            // Play a test sound
            const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT');

            // Attempt to set the sinkId to the selected output device, if supported
            const speakerSelect = document.getElementById('speaker-select');
            if (speakerSelect && speakerSelect.value && typeof audio.setSinkId === 'function') {
                try {
                    await audio.setSinkId(speakerSelect.value);
                } catch (err) {
                    console.warn('Error setting sinkId for test audio:', err);
                }
            }

            audio.play().catch(e => console.log('Could not play test sound'));

            showSuccess('Test sound played. Did you hear it?');
        }

        async function updateCamera() {
            if (cameraEnabled) {
                stopCamera();
                await startCamera();
            }
        }

        async function updateMicrophone() {
            if (microphoneEnabled) {
                stopMicrophone();
                try {
                    await startMicrophone();
                    showSuccess('Microphone updated successfully. Speak to test audio levels.');
                } catch (error) {
                    showError('Failed to update microphone: ' + error.message);
                }
            } else {
                showSuccess('Microphone device updated. Click "Turn On Microphone" to test.');
            }
        }

        function joinConsultation() {
            // Navigate to the main consultation page
            window.location.href = `/video-call/consultation/${appointmentId}`;
        }

        function showError(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-3 rounded shadow-lg z-50';
            notification.textContent = 'Error: ' + message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 5000);
        }

        function showSuccess(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-3 rounded shadow-lg z-50';
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }
    </script>
</body>
</html>
