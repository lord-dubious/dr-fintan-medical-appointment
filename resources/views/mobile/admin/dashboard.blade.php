@extends('mobile.layouts.app')

@section('title', 'Admin Dashboard - Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="adminDashboard()">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary to-mobile-primary-dark text-white px-4 py-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">Admin Dashboard</h1>
                <p class="text-blue-100 text-sm">Welcome back, {{ Auth::user()->name }}</p>
            </div>
            <div class="flex space-x-2">
                <button @click="refreshData()" class="p-2 bg-white/20 rounded-lg touch-target">
                    <i class="fas fa-sync-alt" :class="{ 'fa-spin': isRefreshing }"></i>
                </button>
                <button @click="showNotifications = true" class="p-2 bg-white/20 rounded-lg touch-target relative">
                    <i class="fas fa-bell"></i>
                    <span x-show="notificationCount > 0" 
                          class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                          x-text="notificationCount"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="px-4 py-6">
        <div class="grid grid-cols-2 gap-4 mb-6">
            <!-- Today's Appointments -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-bold text-gray-900" x-text="stats.todayAppointments"></div>
                        <div class="text-sm text-gray-600">Today's Appointments</div>
                    </div>
                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-day text-blue-600"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-xs">
                    <span :class="stats.appointmentChange >= 0 ? 'text-green-600' : 'text-red-600'">
                        <i :class="stats.appointmentChange >= 0 ? 'fas fa-arrow-up' : 'fas fa-arrow-down'" class="mr-1"></i>
                        <span x-text="Math.abs(stats.appointmentChange) + '%'"></span>
                    </span>
                    <span class="text-gray-500 ml-1">vs yesterday</span>
                </div>
            </div>

            <!-- Total Patients -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-bold text-gray-900" x-text="stats.totalPatients"></div>
                        <div class="text-sm text-gray-600">Total Patients</div>
                    </div>
                    <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-green-600"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-xs">
                    <span class="text-green-600">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span x-text="stats.newPatientsThisMonth"></span>
                    </span>
                    <span class="text-gray-500 ml-1">new this month</span>
                </div>
            </div>

            <!-- Revenue -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-bold text-gray-900">€<span x-text="stats.monthlyRevenue.toLocaleString()"></span></div>
                        <div class="text-sm text-gray-600">Monthly Revenue</div>
                    </div>
                    <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-euro-sign text-purple-600"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-xs">
                    <span :class="stats.revenueChange >= 0 ? 'text-green-600' : 'text-red-600'">
                        <i :class="stats.revenueChange >= 0 ? 'fas fa-arrow-up' : 'fas fa-arrow-down'" class="mr-1"></i>
                        <span x-text="Math.abs(stats.revenueChange) + '%'"></span>
                    </span>
                    <span class="text-gray-500 ml-1">vs last month</span>
                </div>
            </div>

            <!-- Active Doctors -->
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-bold text-gray-900" x-text="stats.activeDoctors"></div>
                        <div class="text-sm text-gray-600">Active Doctors</div>
                    </div>
                    <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-md text-red-600"></i>
                    </div>
                </div>
                <div class="mt-2 flex items-center text-xs">
                    <span class="text-blue-600">
                        <i class="fas fa-clock mr-1"></i>
                        <span x-text="stats.doctorsOnline"></span>
                    </span>
                    <span class="text-gray-500 ml-1">online now</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.appointments') }}" 
                   class="bg-white rounded-xl p-4 shadow-sm active:scale-95 transition-transform">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-calendar-alt text-blue-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Appointments</div>
                            <div class="text-xs text-gray-600">Manage bookings</div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.patients') }}" 
                   class="bg-white rounded-xl p-4 shadow-sm active:scale-95 transition-transform">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-users text-green-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Patients</div>
                            <div class="text-xs text-gray-600">Patient records</div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.doctors') }}" 
                   class="bg-white rounded-xl p-4 shadow-sm active:scale-95 transition-transform">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-md text-purple-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Doctors</div>
                            <div class="text-xs text-gray-600">Staff management</div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.settings') }}" 
                   class="bg-white rounded-xl p-4 shadow-sm active:scale-95 transition-transform">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-cog text-gray-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">Settings</div>
                            <div class="text-xs text-gray-600">System config</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Appointments -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Recent Appointments</h2>
                <a href="{{ route('admin.appointments') }}" class="text-mobile-primary text-sm font-medium">
                    View All
                </a>
            </div>
            
            <div class="space-y-3">
                <template x-for="appointment in recentAppointments" :key="appointment.id">
                    <div class="bg-white rounded-xl p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-sm font-medium text-gray-600" x-text="appointment.patient.initials"></span>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900" x-text="appointment.patient.name"></div>
                                    <div class="text-sm text-gray-600">
                                        <span x-text="appointment.date"></span> at <span x-text="appointment.time"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                     :class="getStatusClasses(appointment.status)">
                                    <span x-text="appointment.status"></span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1" x-text="appointment.type"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- System Status -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">System Status</h2>
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-2 w-2 bg-green-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Database</span>
                        </div>
                        <span class="text-xs text-green-600 font-medium">Online</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-2 w-2 bg-green-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Payment Gateway</span>
                        </div>
                        <span class="text-xs text-green-600 font-medium">Connected</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-2 w-2 bg-green-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Video Service</span>
                        </div>
                        <span class="text-xs text-green-600 font-medium">Active</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-2 w-2 bg-yellow-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Email Service</span>
                        </div>
                        <span class="text-xs text-yellow-600 font-medium">Delayed</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications Modal -->
    <div x-show="showNotifications" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-end"
         @click="showNotifications = false">
        
        <div class="bg-white rounded-t-3xl w-full max-h-96 overflow-y-auto"
             @click.stop
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-full"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-full">
            
            <div class="p-4 border-b">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                    <button @click="showNotifications = false" class="p-2 touch-target">
                        <i class="fas fa-times text-gray-500"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-4 space-y-3">
                <template x-for="notification in notifications" :key="notification.id">
                    <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                        <div class="h-8 w-8 rounded-full flex items-center justify-center mr-3"
                             :class="notification.iconBg">
                            <i :class="notification.icon + ' ' + notification.iconColor" class="text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-900" x-text="notification.title"></div>
                            <div class="text-sm text-gray-600" x-text="notification.message"></div>
                            <div class="text-xs text-gray-500 mt-1" x-text="notification.time"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
function adminDashboard() {
    return {
        isRefreshing: false,
        showNotifications: false,
        notificationCount: 3,
        
        stats: {
            todayAppointments: 12,
            appointmentChange: 8,
            totalPatients: 1247,
            newPatientsThisMonth: 89,
            monthlyRevenue: 24500,
            revenueChange: 15,
            activeDoctors: 8,
            doctorsOnline: 5
        },

        recentAppointments: [
            {
                id: 1,
                patient: { name: 'Sarah Johnson', initials: 'SJ' },
                date: 'Today',
                time: '10:30 AM',
                status: 'confirmed',
                type: 'Video Call'
            },
            {
                id: 2,
                patient: { name: 'Michael Brown', initials: 'MB' },
                date: 'Today',
                time: '2:00 PM',
                status: 'pending',
                type: 'In-Person'
            },
            {
                id: 3,
                patient: { name: 'Emma Wilson', initials: 'EW' },
                date: 'Tomorrow',
                time: '9:00 AM',
                status: 'confirmed',
                type: 'Follow-up'
            }
        ],

        notifications: [
            {
                id: 1,
                title: 'New Appointment',
                message: 'Sarah Johnson booked a video consultation',
                time: '5 minutes ago',
                icon: 'fas fa-calendar-plus',
                iconBg: 'bg-blue-100',
                iconColor: 'text-blue-600'
            },
            {
                id: 2,
                title: 'Payment Received',
                message: 'Payment of €75 received from Michael Brown',
                time: '1 hour ago',
                icon: 'fas fa-euro-sign',
                iconBg: 'bg-green-100',
                iconColor: 'text-green-600'
            },
            {
                id: 3,
                title: 'System Update',
                message: 'Scheduled maintenance tonight at 2:00 AM',
                time: '3 hours ago',
                icon: 'fas fa-tools',
                iconBg: 'bg-yellow-100',
                iconColor: 'text-yellow-600'
            }
        ],

        getStatusClasses(status) {
            const classes = {
                'confirmed': 'bg-green-100 text-green-800',
                'pending': 'bg-yellow-100 text-yellow-800',
                'cancelled': 'bg-red-100 text-red-800',
                'completed': 'bg-blue-100 text-blue-800'
            };
            return classes[status] || 'bg-gray-100 text-gray-800';
        },

        async refreshData() {
            this.isRefreshing = true;
            
            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                // Update stats with new data
                this.stats.todayAppointments += Math.floor(Math.random() * 3);
                
                this.$dispatch('show-toast', {
                    message: 'Dashboard data refreshed',
                    type: 'success'
                });
                
            } catch (error) {
                this.$dispatch('show-toast', {
                    message: 'Failed to refresh data',
                    type: 'error'
                });
            } finally {
                this.isRefreshing = false;
            }
        }
    }
}
</script>
@endsection