{{-- Mobile Stats Widget Component --}}
<div class="bg-white rounded-xl shadow-sm p-4" x-data="statsWidget()">
    <!-- Widget Header -->
    <div class="flex items-center justify-between mb-4" x-show="title || actions">
        <h3 x-show="title" class="text-lg font-semibold text-gray-900" x-text="title"></h3>
        <div x-show="actions" class="flex space-x-2">
            <template x-for="action in actions" :key="action.id">
                <button @click="handleAction(action)"
                        class="p-2 text-gray-500 hover:text-gray-700 touch-target">
                    <i :class="action.icon"></i>
                </button>
            </template>
        </div>
    </div>

    <!-- Single Stat Display -->
    <template x-if="displayType === 'single'">
        <div class="text-center">
            <div class="flex items-center justify-center mb-2" x-show="icon">
                <div class="h-12 w-12 rounded-full flex items-center justify-center"
                     :class="iconBg || 'bg-blue-100'">
                    <i :class="icon" :class="iconColor || 'text-blue-600'"></i>
                </div>
            </div>
            <div class="text-3xl font-bold mb-1" 
                 :class="valueColor || 'text-gray-900'" 
                 x-text="formatValue(value)"></div>
            <div class="text-sm text-gray-600" x-text="label"></div>
            <div x-show="change !== null" class="mt-2">
                <span class="inline-flex items-center text-xs font-medium px-2 py-1 rounded-full"
                      :class="getChangeClasses()">
                    <i :class="change >= 0 ? 'fas fa-arrow-up' : 'fas fa-arrow-down'" class="mr-1"></i>
                    <span x-text="Math.abs(change) + '%'"></span>
                </span>
            </div>
        </div>
    </template>

    <!-- Grid Stats Display -->
    <template x-if="displayType === 'grid'">
        <div class="grid grid-cols-2 gap-4">
            <template x-for="stat in stats" :key="stat.id">
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-center mb-2" x-show="stat.icon">
                        <div class="h-8 w-8 rounded-full flex items-center justify-center"
                             :class="stat.iconBg || 'bg-blue-100'">
                            <i :class="stat.icon" :class="stat.iconColor || 'text-blue-600'" class="text-sm"></i>
                        </div>
                    </div>
                    <div class="text-xl font-bold mb-1" 
                         :class="stat.valueColor || 'text-gray-900'" 
                         x-text="formatValue(stat.value)"></div>
                    <div class="text-xs text-gray-600" x-text="stat.label"></div>
                </div>
            </template>
        </div>
    </template>

    <!-- List Stats Display -->
    <template x-if="displayType === 'list'">
        <div class="space-y-3">
            <template x-for="stat in stats" :key="stat.id">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div x-show="stat.icon" 
                             class="h-8 w-8 rounded-full flex items-center justify-center mr-3"
                             :class="stat.iconBg || 'bg-blue-100'">
                            <i :class="stat.icon" :class="stat.iconColor || 'text-blue-600'" class="text-sm"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900" x-text="stat.label"></div>
                            <div x-show="stat.description" 
                                 class="text-xs text-gray-500" 
                                 x-text="stat.description"></div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold" 
                             :class="stat.valueColor || 'text-gray-900'" 
                             x-text="formatValue(stat.value)"></div>
                        <div x-show="stat.change !== null && stat.change !== undefined" class="mt-1">
                            <span class="inline-flex items-center text-xs font-medium"
                                  :class="stat.change >= 0 ? 'text-green-600' : 'text-red-600'">
                                <i :class="stat.change >= 0 ? 'fas fa-arrow-up' : 'fas fa-arrow-down'" class="mr-1"></i>
                                <span x-text="Math.abs(stat.change) + '%'"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </template>

    <!-- Progress Stats Display -->
    <template x-if="displayType === 'progress'">
        <div class="space-y-4">
            <template x-for="stat in stats" :key="stat.id">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div x-show="stat.icon" 
                                 class="h-6 w-6 rounded-full flex items-center justify-center mr-2"
                                 :class="stat.iconBg || 'bg-blue-100'">
                                <i :class="stat.icon" :class="stat.iconColor || 'text-blue-600'" class="text-xs"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-900" x-text="stat.label"></span>
                        </div>
                        <span class="text-sm font-bold" 
                              :class="stat.valueColor || 'text-gray-900'" 
                              x-text="formatValue(stat.value) + (stat.total ? '/' + formatValue(stat.total) : '')"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all duration-300"
                             :class="stat.progressColor || 'bg-blue-600'"
                             :style="`width: ${getProgressPercentage(stat)}%`"></div>
                    </div>
                    <div x-show="stat.description" 
                         class="text-xs text-gray-500 mt-1" 
                         x-text="stat.description"></div>
                </div>
            </template>
        </div>
    </template>

    <!-- Chart Placeholder -->
    <template x-if="displayType === 'chart'">
        <div class="h-32 bg-gray-50 rounded-lg flex items-center justify-center">
            <div class="text-center text-gray-500">
                <i class="fas fa-chart-line text-2xl mb-2"></i>
                <div class="text-sm">Chart View</div>
                <div class="text-xs">Coming Soon</div>
            </div>
        </div>
    </template>

    <!-- Footer -->
    <div x-show="footer" class="mt-4 pt-4 border-t border-gray-200">
        <div class="text-xs text-gray-500 text-center" x-text="footer"></div>
    </div>
</div>

<script>
function statsWidget(config = {}) {
    return {
        // Configuration
        title: config.title || null,
        displayType: config.displayType || 'single', // single, grid, list, progress, chart
        
        // Single stat properties
        value: config.value || 0,
        label: config.label || '',
        icon: config.icon || null,
        iconBg: config.iconBg || null,
        iconColor: config.iconColor || null,
        valueColor: config.valueColor || null,
        change: config.change || null,
        
        // Multiple stats
        stats: config.stats || [],
        
        // Additional properties
        actions: config.actions || null,
        footer: config.footer || null,
        formatType: config.formatType || 'number', // number, currency, percentage
        
        formatValue(value) {
            if (value === null || value === undefined) return '—';
            
            switch (this.formatType) {
                case 'currency':
                    return '€' + Number(value).toLocaleString();
                case 'percentage':
                    return Number(value).toFixed(1) + '%';
                case 'number':
                default:
                    return Number(value).toLocaleString();
            }
        },

        getChangeClasses() {
            if (this.change === null || this.change === undefined) return '';
            
            if (this.change >= 0) {
                return 'bg-green-100 text-green-800';
            } else {
                return 'bg-red-100 text-red-800';
            }
        },

        getProgressPercentage(stat) {
            if (!stat.total || stat.total === 0) return 0;
            return Math.min((stat.value / stat.total) * 100, 100);
        },

        handleAction(action) {
            if (action.callback) {
                action.callback();
            }
            
            this.$dispatch('widget-action', {
                action: action.id,
                widget: this.title
            });
        },

        // Public methods for updating data
        updateValue(newValue) {
            this.value = newValue;
        },

        updateStats(newStats) {
            this.stats = newStats;
        },

        updateStat(statId, newValue) {
            const stat = this.stats.find(s => s.id === statId);
            if (stat) {
                stat.value = newValue;
            }
        },

        addStat(stat) {
            this.stats.push(stat);
        },

        removeStat(statId) {
            this.stats = this.stats.filter(s => s.id !== statId);
        },

        // Animation methods
        animateValue(targetValue, duration = 1000) {
            const startValue = this.value;
            const startTime = Date.now();
            
            const animate = () => {
                const elapsed = Date.now() - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function (ease-out)
                const easeOut = 1 - Math.pow(1 - progress, 3);
                
                this.value = Math.round(startValue + (targetValue - startValue) * easeOut);
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            };
            
            requestAnimationFrame(animate);
        }
    }
}

// Predefined widget configurations
window.StatsWidgetPresets = {
    appointmentOverview: {
        title: 'Appointments',
        displayType: 'grid',
        stats: [
            {
                id: 'today',
                label: 'Today',
                value: 8,
                icon: 'fas fa-calendar-day',
                iconBg: 'bg-blue-100',
                iconColor: 'text-blue-600'
            },
            {
                id: 'upcoming',
                label: 'Upcoming',
                value: 24,
                icon: 'fas fa-clock',
                iconBg: 'bg-green-100',
                iconColor: 'text-green-600'
            },
            {
                id: 'completed',
                label: 'Completed',
                value: 156,
                icon: 'fas fa-check-circle',
                iconBg: 'bg-purple-100',
                iconColor: 'text-purple-600'
            },
            {
                id: 'cancelled',
                label: 'Cancelled',
                value: 3,
                icon: 'fas fa-times-circle',
                iconBg: 'bg-red-100',
                iconColor: 'text-red-600'
            }
        ]
    },

    patientStats: {
        title: 'Patient Statistics',
        displayType: 'list',
        stats: [
            {
                id: 'total',
                label: 'Total Patients',
                value: 1247,
                icon: 'fas fa-users',
                iconBg: 'bg-blue-100',
                iconColor: 'text-blue-600',
                change: 12
            },
            {
                id: 'new',
                label: 'New This Month',
                value: 89,
                icon: 'fas fa-user-plus',
                iconBg: 'bg-green-100',
                iconColor: 'text-green-600',
                change: 23
            },
            {
                id: 'active',
                label: 'Active Patients',
                value: 892,
                icon: 'fas fa-heartbeat',
                iconBg: 'bg-red-100',
                iconColor: 'text-red-600',
                change: 5
            }
        ]
    },

    revenueWidget: {
        title: 'Revenue',
        displayType: 'single',
        value: 12450,
        label: 'This Month',
        formatType: 'currency',
        icon: 'fas fa-euro-sign',
        iconBg: 'bg-green-100',
        iconColor: 'text-green-600',
        change: 18,
        footer: 'Updated 2 hours ago'
    }
};
</script>
