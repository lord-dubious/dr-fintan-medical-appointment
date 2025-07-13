@include('layouts.header')

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
                                <img
                                    src="{{ asset('fintan/Drekochin portrait.png') }}"
                                    alt="Dr. Fintan Ekochin"
                                    class="w-full h-full object-cover object-center"
                                    style="display: block;"
                                    onError="this.style.display='none'; this.parentElement.querySelector('.fallback-avatar').style.display='flex';"
                                />
                                <div
                                    class="fallback-avatar absolute inset-0 bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-blue-800 dark:to-indigo-900 flex items-center justify-center text-6xl font-bold text-blue-600 dark:text-blue-300"
                                    style="display: none;"
                                >
                                    FE
                                </div>
                            </div>
                        </div>

                        <!-- Profile Info - Updated with detailed content from fintan -->
                        <div class="lg:col-span-3 p-8 lg:p-12 flex flex-col justify-center bg-gradient-to-r from-white to-blue-50 dark:from-gray-800 dark:to-blue-900/20">
                            <div class="mb-4">
                                <h1 class="text-4xl md:text-5xl font-bold mb-3 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                    Dr. Fintan Ekochin, MD
                                </h1>
                                <p class="text-xl md:text-2xl text-blue-600 dark:text-blue-400 font-medium mb-6">
                                    Fellow WACP • Neurologist • Integrative Medicine Specialist
                                </p>
                            </div>

                            <div class="space-y-4 mb-8">
                                <p class="text-gray-600 dark:text-gray-300 text-base leading-relaxed">
                                    Dr. Ekochin Fintan is one of two generations of the EKOCHIN Family of Doctors. He largely grew up in
                                    Nigeria with some years of childhood spent in Austria, where he added German to his Igbo and English
                                    language proficiency.
                                </p>

                                <p class="text-gray-600 dark:text-gray-300 text-base leading-relaxed">
                                    After completing Primary and Secondary schools in Enugu and Nsukka, he earned an MBBS from the premier
                                    University of Nigeria, College of Medicine. Post graduation activities were first in the Paklose
                                    Specialist Hospital before going to do House training in Internal Medicine at the University Teaching
                                    Hospital both in New Delhi (2011).
                                </p>

                                <p class="text-gray-600 dark:text-gray-300 text-base leading-relaxed">
                                    He later completed neurology residency in India and the USA, earning Fellowship of the West African
                                    College of Physicians. He currently serves as Head of Neurology at ESUT Teaching Hospital Enugu and
                                    Senior Lecturer for Neurophysiology at Godfrey Okoye University.
                                </p>

                                <p class="text-gray-600 dark:text-gray-300 text-base leading-relaxed">
                                    Dr. Ekochin served as Commissioner for Health, Enugu State (2017-2019), bringing extensive leadership
                                    experience to healthcare administration and policy development.
                                </p>

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
                            <h3 class="font-bold text-xl mb-3 text-gray-900 dark:text-gray-100">Smart Scheduling</h3>
                            <p class="text-base text-gray-600 dark:text-gray-300">AI-powered appointment booking system</p>
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

    <!-- Philosophy Section - From Fintan -->
    <section class="py-20 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-8 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    What to expect from a virtual consultation with Dr. Fintan
                </h2>

                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-l-4 border-blue-600 shadow-xl rounded-2xl">
                    <div class="p-8">
                        <blockquote class="text-lg md:text-xl italic text-gray-700 dark:text-gray-300 mb-6 leading-relaxed">
                            "Dr. Fintan's medical practice is an amalgamation of Orthodox and Alternative medicine,
                            yielding a blend of Complementary, Functional, Orthomolecular, and Lifestyle Medicine.
                            This delivers a pharmacologically minimalist approach to healthcare. Most consultations
                            end without a drug prescription, which makes for efficient cross border client care."
                        </blockquote>
                        <p class="font-semibold text-lg text-blue-600 dark:text-blue-400">— Dr. Fintan Ekochin</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mt-12">
                    <div class="flex items-start gap-4 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-check-circle h-6 w-6 text-green-500 flex-shrink-0 mt-1"></i>
                        <span class="text-base text-gray-700 dark:text-gray-300 leading-relaxed">Amalgamation of Orthodox and Alternative medicine</span>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-check-circle h-6 w-6 text-green-500 flex-shrink-0 mt-1"></i>
                        <span class="text-base text-gray-700 dark:text-gray-300 leading-relaxed">Complementary, Functional, Orthomolecular approach</span>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-check-circle h-6 w-6 text-green-500 flex-shrink-0 mt-1"></i>
                        <span class="text-base text-gray-700 dark:text-gray-300 leading-relaxed">Pharmacologically minimalist healthcare - most consultations end without drug prescriptions</span>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-check-circle h-6 w-6 text-green-500 flex-shrink-0 mt-1"></i>
                        <span class="text-base text-gray-700 dark:text-gray-300 leading-relaxed">Focus on lifestyle medicine and natural healing approaches</span>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 md:col-span-2">
                        <i class="fas fa-check-circle h-6 w-6 text-green-500 flex-shrink-0 mt-1"></i>
                        <span class="text-base text-gray-700 dark:text-gray-300 leading-relaxed">Efficient cross-border client care</span>
                    </div>
                </div>

                <div class="mt-12">
                    <a href="{{ route('appointment') }}">
                        <button class="py-4 px-8 text-lg bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 rounded-xl font-semibold">
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