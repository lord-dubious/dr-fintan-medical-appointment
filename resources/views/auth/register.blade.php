@include('layouts.header')

<body class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 min-h-screen font-inter">
    <!-- Navigation Header -->
    <div class="absolute top-0 left-0 right-0 z-10">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <!-- Logo/Home Link -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-lg">
                        F
                    </div>
                    <span class="font-semibold text-xl">Dr. Fintan</span>
                </a>

                <!-- Back to Home -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span class="font-medium">Back to Home</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Register Page -->
    <div class="flex items-center justify-center min-h-screen py-12 px-4 pt-24">
        <div class="w-full max-w-md">
            <!-- Register Card -->
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-2xl border-0">
                <!-- Header -->
                <div class="p-8 pb-6">
                    <div class="text-center mb-2">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Create Account</h1>
                        <p class="text-gray-600 dark:text-gray-300 mt-2">
                            Enter your information to create your account
                        </p>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="px-8 pb-6">
                    <form id="registerForm" class="space-y-6">
                        @csrf
                        
                        <!-- Alert Container -->
                        <div id="alertContainer"></div>

                        <!-- Name Field -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="Enter your full name"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200"
                                required
                            >
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="name@example.com"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200"
                                required
                            >
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200"
                                required
                            >
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200"
                                required
                            >
                        </div>

                        <!-- Account Type Selection -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Type</label>
                            <div class="space-y-3">
                                <!-- Patient (Default) -->
                                <div class="flex items-center">
                                    <input
                                        type="radio"
                                        id="patient"
                                        name="role"
                                        value="patient"
                                        checked
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600"
                                    >
                                    <label for="patient" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                        Patient Account
                                        <span class="block text-xs text-gray-500 dark:text-gray-400">Book appointments and manage your health</span>
                                    </label>
                                </div>

                                <!-- Doctor -->
                                <div class="flex items-center">
                                    <input
                                        type="radio"
                                        id="doctor"
                                        name="role"
                                        value="doctor"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600"
                                    >
                                    <label for="doctor" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                        Doctor Account
                                        <span class="block text-xs text-gray-500 dark:text-gray-400">Manage appointments and provide patient care</span>
                                    </label>
                                </div>

                                <!-- Admin -->
                                <div class="flex items-center">
                                    <input
                                        type="radio"
                                        id="admin"
                                        name="role"
                                        value="admin"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600"
                                    >
                                    <label for="admin" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                        Admin Account
                                        <span class="block text-xs text-gray-500 dark:text-gray-400">System administration and management</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="terms" 
                                name="terms" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded"
                                required
                            >
                            <label for="terms" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                I agree to the 
                                <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Terms of Service</a> 
                                and 
                                <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Privacy Policy</a>
                            </label>
                        </div>

                        <!-- Register Button -->
                        <button 
                            type="submit" 
                            class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                        >
                            <span id="spinner" class="hidden">
                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                Creating account...
                            </span>
                            <span id="buttonText">Create Account</span>
                        </button>
                    </form>
                </div>

                <!-- Footer -->
                <div class="px-8 pb-8">
                    <div class="text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                Login
                            </a>
                        </p>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('registerForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const form = this;
        const formData = new FormData(form);
        const alertContainer = document.getElementById('alertContainer');
        const spinner = document.getElementById('spinner');
        const buttonText = document.getElementById('buttonText');

        // Clear previous alerts
        alertContainer.innerHTML = '';

        // Basic validation
        const password = form.querySelector('input[name="password"]').value;
        const confirmPassword = form.querySelector('input[name="password_confirmation"]').value;

        if (password !== confirmPassword) {
            alertContainer.innerHTML = `
                <div class="bg-red-50 border border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-700 dark:text-red-300 rounded-xl p-4 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <div>
                            <h4 class="font-semibold">Error</h4>
                            <p class="text-sm mt-1">Passwords do not match.</p>
                        </div>
                    </div>
                </div>
            `;
            return;
        }

        // Show loading state
        spinner.classList.remove('hidden');
        buttonText.classList.add('hidden');

        // Simulate form submission (replace with actual endpoint)
        setTimeout(() => {
            spinner.classList.add('hidden');
            buttonText.classList.remove('hidden');

            alertContainer.innerHTML = `
                <div class="bg-green-50 border border-green-200 text-green-800 dark:bg-green-900/20 dark:border-green-700 dark:text-green-300 rounded-xl p-4 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                        <div>
                            <h4 class="font-semibold">Success</h4>
                            <p class="text-sm mt-1">Account created successfully! Redirecting to login...</p>
                        </div>
                    </div>
                </div>
            `;

            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 2000);
        }, 2000);
    });
    </script>
</body>
</html>
