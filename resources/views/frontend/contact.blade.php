@include('layouts.header')

@include('layouts.navbar')

<!-- Contact Page -->
<main class="flex-grow">
    <!-- Breadcrumb -->
    <section class="py-12 bg-gradient-to-r from-blue-600 to-indigo-600">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Contact Us</h1>
                <nav class="flex justify-center" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-blue-100">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                        <li><i class="fas fa-chevron-right text-sm"></i></li>
                        <li class="text-white font-medium">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-16 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-gray-800">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Get in Touch
                    </h2>
                    <p class="text-center text-gray-600 dark:text-gray-300 mb-10 max-w-xl mx-auto text-lg">
                        Have questions about Dr. Fintan's services? Reach out to us and we'll get back to you as soon as possible.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Contact Information -->
                    <div class="fintan-card shadow-lg">
                        <h3 class="text-2xl font-semibold mb-8 fintan-text-primary">Contact Information</h3>
                        
                        <div class="space-y-6">
                            <!-- Email -->
                            <div class="flex items-start">
                                <div class="h-12 w-12 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/50 dark:to-indigo-900/50 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-envelope text-blue-600 dark:text-blue-400 text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Email</h4>
                                    <p class="text-gray-600 dark:text-gray-300 mb-1">dr.fintan@medical.com</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        For consultations and general inquiries
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Phone -->
                            <div class="flex items-start">
                                <div class="h-12 w-12 bg-gradient-to-br from-green-100 to-blue-100 dark:from-green-900/50 dark:to-blue-900/50 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-phone text-green-600 dark:text-green-400 text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Phone</h4>
                                    <p class="text-gray-600 dark:text-gray-300 mb-1">+1 (555) 123-4567</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Monday to Friday, 9am - 5pm (EST)
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Address -->
                            <div class="flex items-start">
                                <div class="h-12 w-12 bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/50 dark:to-indigo-900/50 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-purple-600 dark:text-purple-400 text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Virtual Practice</h4>
                                    <p class="text-gray-600 dark:text-gray-300 mb-1">
                                        Available Worldwide<br />
                                        Online Consultations
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Virtual consultations available globally
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Hours -->
                            <div class="flex items-start">
                                <div class="h-12 w-12 bg-gradient-to-br from-orange-100 to-yellow-100 dark:from-orange-900/50 dark:to-yellow-900/50 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-clock text-orange-600 dark:text-orange-400 text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Consultation Hours</h4>
                                    <div class="text-gray-600 dark:text-gray-300 space-y-1">
                                        <p>Monday - Friday: 9am - 5pm</p>
                                        <p>Saturday: 10am - 2pm</p>
                                        <p>Sunday: Closed</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Form -->
                    <div class="fintan-card shadow-lg">
                        <h3 class="text-2xl font-semibold mb-8 fintan-text-primary">Send a Message</h3>
                        
                        <form id="contactForm" class="space-y-6">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
                                <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" placeholder="Your full name" required>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" placeholder="Your email address" required>
                            </div>
                            
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject *</label>
                                <input type="text" id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" placeholder="What is this regarding?" required>
                            </div>
                            
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message *</label>
                                <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" placeholder="Your message or question" required></textarea>
                            </div>
                            
                            <button type="submit" class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <span id="submit-text">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Send Message
                                </span>
                                <span id="submit-loading" class="hidden">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                    Sending...
                                </span>
                            </button>
                        </form>
                        
                        <!-- Alert container -->
                        <div id="contact-alert" class="mt-6"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

@include('layouts.footer')

<script>
// Contact form functionality
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitText = document.getElementById('submit-text');
    const submitLoading = document.getElementById('submit-loading');
    const alertContainer = document.getElementById('contact-alert');
    
    // Show loading state
    submitText.classList.add('hidden');
    submitLoading.classList.remove('hidden');
    
    // Simulate form submission (replace with actual endpoint)
    setTimeout(() => {
        // Hide loading state
        submitText.classList.remove('hidden');
        submitLoading.classList.add('hidden');
        
        // Show success message
        alertContainer.innerHTML = `
            <div class="bg-green-50 border border-green-200 text-green-800 dark:bg-green-900/20 dark:border-green-700 dark:text-green-300 rounded-xl p-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-semibold">Message sent successfully!</h4>
                        <p class="text-sm mt-1">Thank you for your message. We'll get back to you within 24 hours.</p>
                    </div>
                </div>
            </div>
        `;
        
        // Reset form
        this.reset();
        
        // Clear alert after 5 seconds
        setTimeout(() => {
            alertContainer.innerHTML = '';
        }, 5000);
    }, 2000);
});
</script>
</body>
</html>
