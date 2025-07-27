<!-- Fintan-style Footer -->
<footer class="bg-gray-600 text-white pt-12 pb-6">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Column 1: About -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="h-8 w-8 rounded-full bg-white flex items-center justify-center text-blue-600 font-bold text-lg">F</div>
                    <span class="font-semibold text-xl">Dr. Fintan</span>
                </div>
                <p class="text-gray-300 mb-4">
                    Providing accessible virtual healthcare consultations with personalized care and professional expertise.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-white hover:text-blue-400 transition-colors" aria-label="Facebook">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-white hover:text-blue-400 transition-colors" aria-label="Twitter">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-white hover:text-blue-400 transition-colors" aria-label="Instagram">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-4 text-white">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Home</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-blue-400 transition-colors">About Dr. Fintan</a></li>
                    <li><a href="{{ route('appointment') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Book Appointment</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Contact Us</a></li>
                    <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Login</a></li>
                </ul>
            </div>

            <!-- Column 3: Services -->
            <div>
                <h4 class="text-lg font-semibold mb-4 text-white">Our Services</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('appointment') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Video Consultations</a></li>
                    <li><a href="{{ route('appointment') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Integrative Medicine</a></li>
                    <li><a href="{{ route('appointment') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Lifestyle Medicine</a></li>
                    <li><a href="{{ route('appointment') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Functional Medicine</a></li>
                </ul>
            </div>

            <!-- Column 4: Contact Info -->
            <div>
                <h4 class="text-lg font-semibold mb-4 text-white">Contact Information</h4>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-envelope text-blue-400 mr-2 mt-1"></i>
                        <span class="text-gray-300">dr.fintan@medical.com</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt text-blue-400 mr-2 mt-1"></i>
                        <span class="text-gray-300">ESUT Teaching Hospital<br/>Enugu, Nigeria</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-globe text-blue-400 mr-2 mt-1"></i>
                        <span class="text-gray-300">Virtual Consultations<br/>Available Worldwide</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-500 mt-8 pt-6 text-center text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} Dr. Fintan Virtual Care Hub. All rights reserved.</p>
        </div>
    </div>
</footer>

    <!--=========================
        SCROLL BUTTON START
    ===========================-->
    <div class="scroll_btn">
        <span><i class="fas fa-arrow-alt-up"></i></span>
    </div>
    <!--==========================
        SCROLL BUTTON END
    ===========================-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--jquery library js-->
    <script src="{{ asset('assets/js/jquery-3.7.0.min.js ') }}"></script>
    <!--bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js ') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('assets/js/Font-Awesome.js ') }}"></script>
    <!--countup js-->
    <script src="{{ asset('assets/js/jquery.countup.min.js ') }}"></script>
    <script src="{{ asset('assets/js/jquery.waypoints.min.js ') }}"></script>
    <!--countup js-->
    <script src="{{ asset('assets/js/select2.min.js ') }}"></script>
    <!--select2 js-->
    <script src="{{ asset('assets/js/slick.min.js ') }}"></script>
    <!--sticky_sidebar js-->
    <script src="{{ asset('assets/js/sticky_sidebar.js ') }}"></script>
    <!--venobox js-->
    <script src="{{ asset('assets/js/venobox.min.js ') }}"></script>
    <!--wow js-->
    <script src="{{ asset('assets/js/wow.min.js ') }}"></script>

    <!--main js-->
    <script src="{{ asset('assets/js/main.js ') }}"></script>
