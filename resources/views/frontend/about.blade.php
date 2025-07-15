@include('layouts.header')

@include('layouts.navbar')

<!-- About Page -->
<main class="flex-grow">
    <!-- Breadcrumb -->
    <section class="py-12 bg-gradient-to-r from-blue-600 to-indigo-600">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">About Dr. Fintan Ekochin</h1>
                <nav class="flex justify-center" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-blue-100">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                        <li><i class="fas fa-chevron-right text-sm"></i></li>
                        <li class="text-white font-medium">About</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Profile Section -->
    <section class="py-16 md:py-24 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-blue-900">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="fintan-card shadow-2xl">
                    <div class="p-4 md:p-8">
                        <div class="grid lg:grid-cols-3 gap-8 items-center">
                            <!-- Profile Image -->
                            <div class="lg:col-span-1">
                                <div class="relative">
                                    <img 
                                        src="{{ asset('fintan/Drekochin portrait.png') }}" 
                                        alt="Dr. Fintan Ekochin" 
                                        class="w-full h-96 object-cover object-center rounded-2xl shadow-lg"
                                        onError="this.style.display='none'; this.parentElement.querySelector('.fallback-avatar').style.display='flex';"
                                    />
                                    <div 
                                        class="fallback-avatar absolute inset-0 bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-blue-800 dark:to-indigo-900 flex items-center justify-center text-6xl font-bold text-blue-600 dark:text-blue-300 rounded-2xl"
                                        style="display: none;"
                                    >
                                        FE
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Profile Info -->
                            <div class="lg:col-span-2">
                                <h2 class="text-3xl md:text-4xl font-bold mb-4 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                    Dr. Fintan Ekochin, MD
                                </h2>
                                <p class="text-xl text-blue-600 dark:text-blue-400 font-medium mb-6">
                                    Fellow WACP • Neurologist • Integrative Medicine Specialist
                                </p>
                                
                                <div class="space-y-4 text-gray-600 dark:text-gray-300">
                                                                    {!! $content['about_intro']['text'] ?? '' !!}
                                                                </div>
                                
                                    @php
                                        $specialties = json_decode($content['specialties']['items'] ?? '[]', true);
                                    @endphp
                                    @if(!empty($specialties))
                                <div class="flex flex-wrap gap-2 mt-6">
                                    @foreach($specialties as $specialty)
                                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 text-sm rounded-full font-medium">{{ $specialty }}</span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Education & Experience Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    Education & Experience
                </h2>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Education -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-8">
                        <h3 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Education</h3>
                        @php
                            $educationItems = json_decode($content['education']['items'] ?? '[]', true);
                        @endphp
                        @if(!empty($educationItems))
                            <div class="space-y-4">
                                @foreach($educationItems as $item)
                                    <div class="border-l-4 border-blue-600 pl-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $item['title'] }}</h4>
                                        <p class="text-gray-600 dark:text-gray-300">{{ $item['description'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <!-- Experience -->
                    <div class="bg-gradient-to-br from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 rounded-2xl p-8">
                        <h3 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Experience</h3>
                        @php
                            $experienceItems = json_decode($content['experience']['items'] ?? '[]', true);
                        @endphp
                        @if(!empty($experienceItems))
                            <div class="space-y-4">
                                @foreach($experienceItems as $item)
                                    <div class="border-l-4 border-green-600 pl-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $item['title'] }}</h4>
                                        <p class="text-gray-600 dark:text-gray-300">{{ $item['description'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Ready to Experience Integrative Healthcare?
            </h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Schedule a consultation with Dr. Fintan and discover a holistic approach to your health and wellness.
            </p>
            <a href="{{ route('appointment') }}" class="inline-block">
                <button class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 text-lg">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Book Your Consultation
                </button>
            </a>
        </div>
    </section>
</main>

@include('layouts.footer')

<script>
// Hide loading spinner when page loads
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('loading')) {
        document.getElementById('loading').style.display = 'none';
    }
});
</script>
</body>
</html>
