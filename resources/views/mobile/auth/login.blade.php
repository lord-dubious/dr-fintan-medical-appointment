@extends('mobile.layouts.app')

@section('title', 'Sign In - Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex flex-col">
    <!-- Header -->
    <div class="text-center pt-12 pb-8 px-4">
        <div class="mx-auto mb-6 h-20 w-20 rounded-full bg-gradient-to-br from-mobile-primary to-mobile-primary-dark flex items-center justify-center shadow-lg">
            <span class="text-white font-bold text-2xl">F</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome Back</h1>
        <p class="text-gray-600">Sign in to your account</p>
    </div>

    <!-- Login Form -->
    <div class="flex-1 px-4">
        <div class="bg-white rounded-t-3xl shadow-xl p-6 min-h-full">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required 
                               autocomplete="email"
                               class="w-full px-4 py-4 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary transition-colors @error('email') border-red-500 @enderror">
                        <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative" x-data="{ showPassword: false }">
                        <input :type="showPassword ? 'text' : 'password'" 
                               id="password" 
                               name="password" 
                               required 
                               autocomplete="current-password"
                               class="w-full px-4 py-4 pl-12 pr-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary transition-colors @error('password') border-red-500 @enderror">
                        <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <button type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 touch-target">
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="remember" 
                               {{ old('remember') ? 'checked' : '' }}
                               class="h-4 w-4 text-mobile-primary focus:ring-mobile-primary border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    
                    <a href="#" class="text-sm text-mobile-primary font-medium">
                        Forgot password?
                    </a>
                </div>

                <!-- Sign In Button -->
                <button type="submit" 
                        class="w-full bg-mobile-primary text-white py-4 px-6 rounded-xl font-semibold text-lg shadow-lg active:scale-95 transition-transform">
                    Sign In
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <!-- Social Login Buttons -->
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" 
                            class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 active:scale-95 transition-transform">
                        <i class="fab fa-google text-red-500 mr-2"></i>
                        Google
                    </button>
                    
                    <button type="button" 
                            class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 active:scale-95 transition-transform">
                        <i class="fab fa-facebook text-blue-600 mr-2"></i>
                        Facebook
                    </button>
                </div>

                <!-- Sign Up Link -->
                <div class="text-center pt-6">
                    <p class="text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-mobile-primary font-semibold">
                            Sign up
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection