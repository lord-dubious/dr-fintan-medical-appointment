{{-- Enhanced Mobile Login Form using Professional UI Components --}}
<x-mobile.components.ui.card class="w-full max-w-md mx-auto" padding="lg">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome Back</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Sign in to your account</p>
    </div>

    <form method="POST" action="{{ route('login.auth') }}" x-data="loginForm()" @submit.prevent="submitForm">
        @csrf
        
        <div class="space-y-4">
            <!-- Email Input -->
            <x-mobile.components.ui.input
                type="email"
                name="email"
                label="Email Address"
                placeholder="Enter your email"
                icon="fas fa-envelope"
                required
                x-model="form.email"
                :error="$errors->first('email')" />
            
            <!-- Password Input -->
            <x-mobile.components.ui.input
                type="password"
                name="password"
                label="Password"
                placeholder="Enter your password"
                icon="fas fa-lock"
                required
                x-model="form.password"
                :error="$errors->first('password')" />
            
            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="remember" 
                           x-model="form.remember"
                           class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <span class="ml-2 text-sm text-gray-900 dark:text-gray-300">Remember me</span>
                </label>
                
                <a href="#" class="text-sm text-primary-600 hover:underline dark:text-primary-500">
                    Forgot password?
                </a>
            </div>
            
            <!-- Submit Button -->
            <x-mobile.components.ui.button
                type="submit"
                variant="primary"
                size="lg"
                fullWidth
                :loading="false"
                x-bind:loading="loading"
                x-bind:disabled="loading">
                <span x-show="!loading">Sign In</span>
                <span x-show="loading">Signing In...</span>
            </x-mobile.components.ui.button>
        </div>
        
        <!-- Register Link -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Don't have an account? 
                <a href="{{ route('mobile.auth.register') }}" class="text-primary-600 hover:underline dark:text-primary-500 font-medium">
                    Sign up here
                </a>
            </p>
        </div>
    </form>
</x-mobile.components.ui.card>

<script>
function loginForm() {
    return {
        loading: false,
        form: {
            email: '',
            password: '',
            remember: false
        },
        
        async submitForm() {
            this.loading = true;
            
            try {
                const formData = new FormData();
                formData.append('email', this.form.email);
                formData.append('password', this.form.password);
                formData.append('remember', this.form.remember);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                
                const response = await fetch('{{ route("login.auth") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    window.location.href = result.redirect;
                } else {
                    this.showError(result.message || 'Login failed');
                }
            } catch (error) {
                this.showError('An error occurred. Please try again.');
            } finally {
                this.loading = false;
            }
        },
        
        showError(message) {
            // Show toast notification
            if (window.showToast) {
                window.showToast(message, 'error');
            } else {
                alert(message);
            }
        }
    }
}
</script>
