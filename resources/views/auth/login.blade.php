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

    <!-- Login Page -->
    <div class="flex items-center justify-center min-h-screen py-12 px-4 pt-24">
        <div class="w-full max-w-md">
            <!-- Login Card -->
            <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-2xl border-0">
                <!-- Header -->
                <div class="p-8 pb-6">
                    <div class="text-center mb-2">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Login</h1>
                        <p class="text-gray-600 dark:text-gray-300 mt-2">
                            Enter your email and password to access your account
                        </p>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="px-8 pb-6">
                    <form id="loginForm" class="space-y-6">
                        @csrf
                        
                        <!-- Alert Container -->
                        <div id="alertContainer"></div>

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
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                                <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                    Forgot password?
                                </a>
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200"
                                required
                            >
                        </div>

                        <!-- Login Button -->
                        <button 
                            type="submit" 
                            class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                        >
                            <span id="spinner" class="hidden">
                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                Logging in...
                            </span>
                            <span id="buttonText">Login</span>
                        </button>
                    </form>
                </div>

                <!-- Footer -->
                <div class="px-8 pb-8">
                    <div class="text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                Register
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const form = this;
        const email = form.querySelector('input[name="email"]').value.trim();
        const password = form.querySelector('input[name="password"]').value.trim();
        const alertContainer = document.getElementById('alertContainer');

        // Clear previous alerts
        alertContainer.innerHTML = '';

        // Validation
        if (!email || !password) {
            alertContainer.innerHTML = `
                <div class="bg-red-50 border border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-700 dark:text-red-300 rounded-xl p-4 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <div>
                            <h4 class="font-semibold">Error</h4>
                            <p class="text-sm mt-1">Please fill in all fields.</p>
                        </div>
                    </div>
                </div>
            `;
            return;
        }

        const formData = new FormData(form);
        const spinner = document.getElementById('spinner');
        const buttonText = document.getElementById('buttonText');

        // Show loading state
        spinner.classList.remove('hidden');
        buttonText.classList.add('hidden');

        // Submit form
        fetch("{{ route('login.auth') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            spinner.classList.add('hidden');
            buttonText.classList.remove('hidden');

            if (data.success) {
                alertContainer.innerHTML = `
                    <div class="bg-green-50 border border-green-200 text-green-800 dark:bg-green-900/20 dark:border-green-700 dark:text-green-300 rounded-xl p-4 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <div>
                                <h4 class="font-semibold">Success</h4>
                                <p class="text-sm mt-1">${data.message}</p>
                            </div>
                        </div>
                    </div>
                `;
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            } else {
                alertContainer.innerHTML = `
                    <div class="bg-red-50 border border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-700 dark:text-red-300 rounded-xl p-4 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                            <div>
                                <h4 class="font-semibold">Error</h4>
                                <p class="text-sm mt-1">${data.message}</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            spinner.classList.add('hidden');
            buttonText.classList.remove('hidden');
            alertContainer.innerHTML = `
                <div class="bg-red-50 border border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-700 dark:text-red-300 rounded-xl p-4 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <div>
                            <h4 class="font-semibold">Error</h4>
                            <p class="text-sm mt-1">An error occurred. Please try again later.</p>
                        </div>
                    </div>
                </div>
            `;
        });
    });
    </script>
</body>
</html>
