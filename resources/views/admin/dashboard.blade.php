@include('layouts.header')
<style>
    .stat-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-left: 4px solid;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .stat-card.total { border-left-color: #3498db; }
    .stat-card.pending { border-left-color: #f39c12; }
    .stat-card.active { border-left-color: #2ecc71; }
    .stat-card.doctors { border-left-color: #9b59b6; }
    .stat-card.patients { border-left-color: #1abc9c; }
    .stat-card.expired { border-left-color: #e74c3c; }
    
    .stat-icon {
        font-size: 2rem;
        opacity: 0.8;
    }
    
    .appointment-table {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .appointment-table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .badge-pending { background-color: #f39c12; }
    .badge-confirmed { background-color: #2ecc71; }
    .badge-cancelled { background-color: #e74c3c; }
    
    @media (max-width: 768px) {
        .stat-card { margin-bottom: 20px; }
    }
</style>

<body class="bg-gray-50 dark:bg-gray-900 font-inter">
    <section class="dashboard pt-24 pb-16 min-h-screen">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 wow fadeInLeft" data-wow-duration="1s">
                    @include('layouts.admin_navbar')
                </div>
            
                <div class="col-xl-9 col-lg-8">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-200/50 dark:border-gray-700/50">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-4 mb-6 border-bottom border-gray-200 dark:border-gray-700">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Admin Dashboard</h1>
                            <div class="btn-toolbar mb-2 mb-md-0">
                                <div class="btn-group me-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>
                    
                        <!-- Stats Cards -->
                        <div class="row mb-6">
                            @foreach([
                                ['total', 'calendar-check', 'blue', 'Total Appointments', $stats['total_appointments'], $stats['today_appointments'].' today'],
                                ['pending', 'clock', 'orange', 'Pending Appointments', $stats['pending_appointments'], 'Needs approval'],
                                ['active', 'check-circle', 'green', 'Active Appointments', $stats['active_appointments'], 'Upcoming'],
                                ['doctors', 'user-md', 'purple', 'Total Doctors', $stats['total_doctors'], 'View all'],
                                ['patients', 'procedures', 'teal', 'Total Patients', $stats['total_patients'], 'View all'],
                                ['expired', 'calendar-times', 'red', 'Expired/Cancelled', $stats['expired_appointments'], 'Past appointments']
                            ] as $card)
                            <div class="col-md-4 mb-4">
                                <div class="bg-gradient-to-r from-{{ $card[2] }}-50 to-{{ $card[2] }}-100 dark:from-{{ $card[2] }}-900/20 dark:to-{{ $card[2] }}-800/20 rounded-xl p-6 border border-{{ $card[2] }}-200/50 dark:border-{{ $card[2] }}-700/50 hover:shadow-lg transition-all duration-300 h-100">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-gray-600 dark:text-gray-300 text-sm font-medium mb-2">{{ $card[3] }}</h6>
                                            <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-0">{{ $card[4] }}</h3>
                                        </div>
                                        <div class="h-12 w-12 bg-{{ $card[2] }}-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-{{ $card[1] }} text-white text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        @if(in_array($card[0], ['doctors', 'patients']))
                                            <a href="{{ route('admin.'.$card[0].'.index') }}" class="text-{{ $card[2] }}-600 dark:text-{{ $card[2] }}-400 hover:underline font-medium">{{ $card[5] }}</a>
                                        @else
                                            <span class="text-{{ $card[2] }}-600 dark:text-{{ $card[2] }}-400 font-medium">
                                                @if($card[0] === 'total')<i class="fas fa-calendar-day mr-1"></i>@endif
                                                {{ $card[5] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    
                        <!-- Pending Appointments Table -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 mb-4">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h5 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-0">Pending Appointments</h5>
                            </div>
                            <div class="p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Patient</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Doctor</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Department</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date & Time</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                        @forelse($pendingAppointments as $appointment)
                                        <tr id="appointment-{{ $appointment->id }}">
                                            <td>#{{ $appointment->id }}</td>
                                            <td>{{ $appointment->patient->name }}</td>
                                            <td>{{ $appointment->doctor->name }}</td>
                                            <td> {{ $appointment->doctor->department }}</td>
                                            <td>
                                            <td>
                                                {{ $appointment->appointment_date->format('M d, Y') }}<br>
                                                <small class="text-muted">{{ $appointment->appointment_time }}</small>
                                            </td>
                                            <td>
                                                @include('components.status-badge', ['status' => $appointment->status])
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-success btn-sm approve-btn" data-id="{{ $appointment->id }}">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                    <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $appointment->id }}">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">No pending appointments found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            {{ $pendingAppointments->links() }}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11"></div>

    <script>
        // Handle approve/reject buttons
      document.addEventListener('DOMContentLoaded', function() {
    // Handle approve/reject buttons
    document.querySelectorAll('.approve-btn, .reject-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const appointmentId = this.getAttribute('data-id');
            const action = this.classList.contains('approve-btn') ? 'confirmed' : 'cancelled';
            const button = this;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }
            // Disable button during processing
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing';

            fetch(`/admin/appointments/${appointmentId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                   'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: action
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Find the row and update status
                    const row = button.closest('tr');
                    row.querySelector('.badge').outerHTML = data.status_badge;
                    
                    // Remove action buttons
                    row.querySelector('td:last-child').innerHTML = 
                        `<span class="text-muted">Processed</span>`;
                    
                    // Show success message
                    showToast('success', data.message);
                }
            })
            .catch(error => {
                button.disabled = false;
                button.innerHTML = action === 'confirmed' 
                    ? '<i class="fas fa-check"></i> Approve' 
                    : '<i class="fas fa-times"></i> Reject';
                
                const message = error.message || 'An error occurred';
                showToast('error', message);
            });
        });
    });

    // Helper function for toast notifications
    function showToast(type, message) {
        // Implement your toast notification here
        // Example using Bootstrap toasts:
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type}`;
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>`;
        
        const toastContainer = document.getElementById('toast-container') || document.body;
        toastContainer.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }
});
    </script>
</body>
</html>
