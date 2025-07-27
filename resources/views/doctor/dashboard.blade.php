  @include('layouts.header')

<body class="bg-gray-50 dark:bg-gray-900 font-inter">
  <!--============================
        DASHBOARD START
    ==============================-->
    <section class="dashboard pt-24 pb-16 min-h-screen">
        <div class="container">
            <div class="row">

                <div class="col-xl-3 col-lg-4 wow fadeInLeft" data-wow-duration="1s">
                @include('layouts.doctor_navbar')
                </div>

                <div class="col-xl-9 col-lg-8 mb-5">
                    <div class="dashboard_content bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-200/50 dark:border-gray-700/50">
                        @if(session('original_admin_id'))
                        <div class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-user-shield text-yellow-600 dark:text-yellow-400 mr-2"></i>
                                    <span class="text-yellow-800 dark:text-yellow-200 font-medium">
                                        You are logged in as a doctor (Admin Mode)
                                    </span>
                                </div>
                                <form action="{{ route('admin.return-to-admin') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning">
                                        <i class="fas fa-arrow-left mr-1"></i> Return to Admin
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif

                        <h5 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Doctor Overview</h5>

                        <div class="row">
                            <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200/50 dark:border-blue-700/50 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-gray-600 dark:text-gray-300 text-sm font-medium mb-2">Total Appointments</p>
                                            <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $appointmentStats['total'] }}</h3>
                                            <p class="text-blue-600 dark:text-blue-400 text-sm mt-1">{{ $appointmentStats['today'] }} Today</p>
                                        </div>
                                        <div class="h-12 w-12 bg-blue-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-calendar-check text-white text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-6 border border-green-200/50 dark:border-green-700/50 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-gray-600 dark:text-gray-300 text-sm font-medium mb-2">Active Appointments</p>
                                            <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $appointmentStats['active'] }}</h3>
                                            <p class="text-green-600 dark:text-green-400 text-sm mt-1">Upcoming</p>
                                        </div>
                                        <div class="h-12 w-12 bg-green-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check-circle text-white text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                                <div class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 rounded-xl p-6 border border-red-200/50 dark:border-red-700/50 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-gray-600 dark:text-gray-300 text-sm font-medium mb-2">Expired/Cancelled</p>
                                            <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $appointmentStats['expired'] }}</h3>
                                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">Past appointments</p>
                                        </div>
                                        <div class="h-12 w-12 bg-red-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-calendar-times text-white text-xl"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-800/50 dark:to-blue-900/20 rounded-xl p-6 border border-gray-200/50 dark:border-gray-700/50">
                            <h5 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Doctor Profile Information</h5>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-blue-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-md text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $doctor->name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-green-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-phone text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $doctor->mobile }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-purple-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $doctor->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-indigo-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-hospital text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Department</p>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $doctor->department }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 md:col-span-2">
                                    <div class="h-10 w-10 bg-orange-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-clock text-white"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Availability</p>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $doctor->availability }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        DASHBOARD END
    ==============================-->
</body>

</html>
