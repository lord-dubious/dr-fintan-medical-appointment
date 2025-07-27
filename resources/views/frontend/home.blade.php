@include('layouts.header')
@php use Illuminate\Support\Facades\Storage; @endphp

<!-- Loading Spinner -->
<div id="loading" class="fixed inset-0 bg-white/90 backdrop-blur-sm z-50 flex items-center justify-center">
    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-medical-primary"></div>
</div>

@include('layouts.navbar')

<!-- Hero Section -->
<main class="flex-grow">
    <section class="py-16 md:py-24">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <!-- Main Profile Card -->
                <div class="mb-8 overflow-hidden shadow-2xl border-0 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl">
                    <div class="grid lg:grid-cols-5 gap-0">
                        <!-- Profile Image -->
                        <div class="lg:col-span-2 relative bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 flex items-center justify-center overflow-hidden">
                            <div class="w-full h-96 lg:h-[500px] relative">
                                @if(!empty($settings['doctor_profile_image']))
                                    <img
                                        src="{{ Storage::url($settings['doctor_profile_image']) }}"
                                        alt="Dr. Fintan Ekochin"
                                        class="w-full h-full object-cover object-center"
                                        style="display: block;"
                                        onError="this.classList.add('hidden'); this.parentElement.querySelector('.fallback-avatar').classList.remove('hidden');"
                                    />
                                @endif
                                <div
                                    class="fallback-avatar absolute inset-0 bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-blue-800 dark:to-indigo-900 flex items-center justify-center text-6xl font-bold text-blue-600 dark:text-blue-300 {{ empty($settings['doctor_profile_image']) ? '' : 'hidden' }}"
                                >
                                    FE
                                </div>
                            </div>
                        </div>

                        <!-- Profile Info - Dynamic content from admin dashboard -->
                        <div class="lg:col-span-3 p-8 lg:p-12 flex flex-col justify-center bg-gradient-to-r from-white to-blue-50 dark:from-gray-800 dark:to-blue-900/20">
                            <div class="mb-4">
                                <h1 class="text-4xl md:text-5xl font-bold mb-3 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                    {{ $content['hero']['title'] ?? 'Dr. Fintan Ekochin, MD' }}
                                </h1>
                                <p class="text-xl md:text-2xl text-blue-600 dark:text-blue-400 font-medium mb-6">
                                    {{ $content['hero']['subtitle'] ?? 'Fellow WACP • Neurologist • Integrative Medicine Specialist' }}
                                </p>
                            </div>

                            <div class="space-y-4 mb-8">
                                @if(!empty($content['hero']['paragraph_1']))
                                    <p class="text-gray-600 dark:text-gray-300 text-base leading-relaxed">
                                        {{ $content['hero']['paragraph_1'] }}
                                    </p>
                                @endif

                                @if(!empty($content['hero']['paragraph_2']))
                                    <p class="text-gray-600 dark:text-gray-300 text-base leading-relaxed">
                                        {{ $content['hero']['paragraph_2'] }}
                                    </p>
                                @endif

                                @if(!empty($content['hero']['paragraph_3']))
                                    <p class="text-gray-600 dark:text-gray-300 text-base leading-relaxed">
                                        {{ $content['hero']['paragraph_3'] }}
                                    </p>
                                @endif

                                @if(!empty($content['hero']['paragraph_4']))
                                    <p class="text-gray-600 dark:text-gray-300 text-base leading-relaxed">
                                        {{ $content['hero']['paragraph_4'] }}
                                    </p>
                                @endif

                                <div class="flex flex-wrap gap-2 mb-6">
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 text-sm rounded-full font-medium">Fellow WACP</span>
                                    <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 text-sm rounded-full font-medium">Integrative Medicine</span>
                                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 text-sm rounded-full font-medium">Lifestyle Medicine</span>
                                    <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300 text-sm rounded-full font-medium">Former Health Commissioner</span>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('appointment') }}" class="flex-1">
                                    <button class="w-full py-4 px-8 text-lg bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 rounded-xl font-semibold">
                                        Book Consultation
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </a>
                                <a href="/about" class="flex-1">
                                    <button class="w-full py-4 px-8 text-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 transition-all duration-300 rounded-xl font-medium text-gray-900 dark:text-gray-100">
                                        Learn More
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Grid -->
                <div class="grid md:grid-cols-3 gap-6 mb-12">
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border-0 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 rounded-2xl">
                        <div class="p-8 text-center">
                            <i class="fas fa-video h-12 w-12 text-blue-600 dark:text-blue-400 text-5xl mb-4"></i>
                            <h3 class="font-bold text-xl mb-3 text-gray-900 dark:text-gray-100">HD Video Consultations</h3>
                            <p class="text-base text-gray-600 dark:text-gray-300">Crystal clear video calls with screen sharing</p>
                        </div>
                    </div>

                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border-0 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 rounded-2xl">
                        <div class="p-8 text-center">
                            <i class="fas fa-calendar-check h-12 w-12 text-blue-600 dark:text-blue-400 text-5xl mb-4"></i>
                            <h3 class="font-bold text-xl mb-3 text-gray-900 dark:text-gray-100">Easy Scheduling</h3>
                            <p class="text-base text-gray-600 dark:text-gray-300">Simple and convenient appointment booking system</p>
                        </div>
                    </div>

                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border-0 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 rounded-2xl">
                        <div class="p-8 text-center">
                            <i class="fas fa-shield-alt h-12 w-12 text-blue-600 dark:text-blue-400 text-5xl mb-4"></i>
                            <h3 class="font-bold text-xl mb-3 text-gray-900 dark:text-gray-100">Secure & Private</h3>
                            <p class="text-base text-gray-600 dark:text-gray-300">HIPAA compliant with end-to-end encryption</p>
                        </div>
                    </div>
                </div>

                <!-- Specialties Grid -->
                <div class="grid lg:grid-cols-3 gap-4">
                    <div class="text-center p-6 bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm border-0 shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 hover:bg-white dark:hover:bg-gray-800 rounded-2xl">
                        <i class="fas fa-heart h-10 w-10 text-blue-600 dark:text-blue-400 text-4xl mb-3"></i>
                        <h3 class="font-bold text-base mb-2 text-gray-900 dark:text-gray-100">Integrative Medicine</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Combining traditional and alternative approaches</p>
                    </div>

                    <div class="text-center p-6 bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm border-0 shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 hover:bg-white dark:hover:bg-gray-800 rounded-2xl">
                        <i class="fas fa-user-md h-10 w-10 text-blue-600 dark:text-blue-400 text-4xl mb-3"></i>
                        <h3 class="font-bold text-base mb-2 text-gray-900 dark:text-gray-100">Lifestyle Medicine</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Prevention through lifestyle modifications</p>
                    </div>

                    <div class="text-center p-6 bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm border-0 shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 hover:bg-white dark:hover:bg-gray-800 rounded-2xl">
                        <i class="fas fa-globe h-10 w-10 text-blue-600 dark:text-blue-400 text-4xl mb-3"></i>
                        <h3 class="font-bold text-base mb-2 text-gray-900 dark:text-gray-100">Virtual Care</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Accessible healthcare from anywhere</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Philosophy Section - Dynamic content from admin dashboard -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-8 text-gray-900 dark:text-gray-100">
                    {{ $content['philosophy']['title'] ?? 'What to expect from a virtual consultation with Dr. Fintan' }}
                </h2>

                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 mb-12">
                    <blockquote class="text-lg md:text-xl italic text-gray-700 dark:text-gray-300 mb-6">
                        "{{ $content['philosophy']['quote'] ?? 'Dr. Fintan\'s medical practice is an amalgamation of Orthodox and Alternative medicine, yielding a blend of Complementary, Functional, Orthomolecular, and Lifestyle Medicine. This delivers a pharmacologically minimalist approach to healthcare. Most consultations end without a drug prescription, which makes for efficient cross border client care.' }}"
                    </blockquote>
                    <p class="font-semibold text-blue-600 dark:text-blue-400">{{ $content['philosophy']['author'] ?? '— Dr. Fintan Ekochin' }}</p>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="flex items-start gap-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                        <i class="fas fa-check text-green-500 text-lg mt-1"></i>
                        <span class="text-gray-700 dark:text-gray-300">Amalgamation of Orthodox and Alternative medicine</span>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                        <i class="fas fa-check text-green-500 text-lg mt-1"></i>
                        <span class="text-gray-700 dark:text-gray-300">Complementary, Functional, Orthomolecular approach</span>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                        <i class="fas fa-check text-green-500 text-lg mt-1"></i>
                        <span class="text-gray-700 dark:text-gray-300">Pharmacologically minimalist healthcare</span>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                        <i class="fas fa-check text-green-500 text-lg mt-1"></i>
                        <span class="text-gray-700 dark:text-gray-300">Focus on lifestyle medicine</span>
                    </div>
                </div>

                <div class="mt-12">
                    <a href="{{ route('appointment') }}">
                        <button class="py-3 px-8 bg-blue-600 hover:bg-blue-700 text-white shadow-lg hover:shadow-xl transition-all duration-300 rounded-lg font-semibold">
                            <i class="fas fa-stethoscope mr-2"></i>
                            Begin Your Health Journey
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>





















    @include('layouts.footer')

    <script>
    // Hide loading spinner when page loads
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('loading').style.display = 'none';
    });







    </script>
</body>

</html>
