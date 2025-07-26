{{-- Real-time Mobile Calendar Component --}}
<div x-data="realTimeCalendar()" x-init="init()" class="bg-white rounded-xl shadow-sm">
    <!-- Calendar Header -->
    <div class="flex items-center justify-between p-4 border-b">
        <button @click="previousMonth()" class="p-2 touch-target hover:bg-gray-100 rounded-lg">
            <i class="fas fa-chevron-left text-gray-600"></i>
        </button>
        <div class="text-center">
            <h3 class="font-semibold text-gray-900" x-text="currentMonthYear"></h3>
            <p class="text-sm text-gray-500" x-text="selectedDateText"></p>
        </div>
        <button @click="nextMonth()" class="p-2 touch-target hover:bg-gray-100 rounded-lg">
            <i class="fas fa-chevron-right text-gray-600"></i>
        </button>
    </div>

    <!-- Doctor Selection -->
    <div class="p-4 border-b">
        <label class="block text-sm font-medium text-gray-700 mb-2">Select Doctor</label>
        <select x-model="selectedDoctor" @change="fetchAvailability()" 
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary focus:border-transparent">
            <option value="">Choose a doctor...</option>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->department }}</option>
            @endforeach
        </select>
    </div>

    <!-- Calendar Grid -->
    <div class="p-4">
        <!-- Day Headers -->
        <div class="grid grid-cols-7 gap-1 mb-2">
            <template x-for="day in dayHeaders">
                <div class="text-center text-xs font-medium text-gray-500 py-2" x-text="day"></div>
            </template>
        </div>

        <!-- Calendar Dates -->
        <div class="grid grid-cols-7 gap-1">
            <template x-for="date in calendarDates" :key="date.dateString">
                <button @click="selectDate(date)" 
                        :disabled="!date.available || date.isDisabled"
                        :class="{
                            'bg-mobile-primary text-white': date.isSelected,
                            'bg-green-100 text-green-800 hover:bg-green-200': date.available && !date.isSelected && !date.isDisabled,
                            'bg-red-100 text-red-500': date.hasAppointments && !date.available,
                            'bg-gray-100 text-gray-400 cursor-not-allowed': date.isDisabled || !date.available,
                            'text-gray-400': !date.isCurrentMonth,
                            'ring-2 ring-mobile-primary ring-offset-2': date.isToday && !date.isSelected
                        }"
                        class="aspect-square flex items-center justify-center text-sm font-medium rounded-lg transition-all duration-200 touch-target relative">
                    <span x-text="date.day"></span>
                    <!-- Availability indicator -->
                    <div x-show="date.hasAppointments" class="absolute bottom-1 left-1/2 transform -translate-x-1/2">
                        <div class="w-1 h-1 rounded-full" 
                             :class="date.available ? 'bg-green-500' : 'bg-red-500'"></div>
                    </div>
                </button>
            </template>
        </div>
    </div>

    <!-- Available Time Slots -->
    <div x-show="selectedDate && selectedDoctor" class="p-4 border-t">
        <h4 class="font-medium text-gray-900 mb-3">Available Times</h4>
        
        <div x-show="loadingSlots" class="flex items-center justify-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-mobile-primary"></div>
        </div>

        <div x-show="!loadingSlots && availableSlots.length === 0" class="text-center py-8 text-gray-500">
            <i class="fas fa-calendar-times text-2xl mb-2"></i>
            <p>No available slots for this date</p>
        </div>

        <div x-show="!loadingSlots && availableSlots.length > 0" class="grid grid-cols-3 gap-2">
            <template x-for="slot in availableSlots" :key="slot.time">
                <button @click="selectTimeSlot(slot)" 
                        :class="{
                            'bg-mobile-primary text-white': selectedTimeSlot === slot.time,
                            'bg-gray-100 text-gray-900 hover:bg-gray-200': selectedTimeSlot !== slot.time
                        }"
                        class="p-3 rounded-lg text-sm font-medium transition-colors">
                    <span x-text="slot.time"></span>
                    <div class="text-xs opacity-75" x-text="slot.available ? 'Available' : 'Booked'"></div>
                </button>
            </template>
        </div>
    </div>
</div>

<script>
function realTimeCalendar() {
    return {
        currentDate: new Date(),
        selectedDate: null,
        selectedDoctor: '',
        selectedTimeSlot: null,
        availableSlots: [],
        loadingSlots: false,
        dayHeaders: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        
        init() {
            this.updateCalendar();
            // Set up real-time updates every 30 seconds
            setInterval(() => {
                if (this.selectedDoctor && this.selectedDate) {
                    this.fetchAvailability();
                }
            }, 30000);
        },
        
        get currentMonthYear() {
            return this.currentDate.toLocaleDateString('en-US', {
                month: 'long',
                year: 'numeric'
            });
        },
        
        get selectedDateText() {
            if (!this.selectedDate) return 'Select a date';
            return this.selectedDate.toLocaleDateString('en-US', {
                weekday: 'long',
                month: 'short',
                day: 'numeric'
            });
        },
        
        get calendarDates() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());
            
            const dates = [];
            const today = new Date();
            
            for (let i = 0; i < 42; i++) {
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);
                
                const dateString = date.toISOString().split('T')[0];
                const isCurrentMonth = date.getMonth() === month;
                const isToday = date.toDateString() === today.toDateString();
                const isPast = date < today.setHours(0, 0, 0, 0);
                
                dates.push({
                    date: new Date(date),
                    day: date.getDate(),
                    dateString: dateString,
                    isCurrentMonth: isCurrentMonth,
                    isToday: isToday,
                    isSelected: this.selectedDate && date.toDateString() === this.selectedDate.toDateString(),
                    isDisabled: isPast || !isCurrentMonth,
                    available: !isPast && isCurrentMonth,
                    hasAppointments: false // Will be updated by fetchAvailability
                });
            }
            
            return dates;
        },
        
        previousMonth() {
            this.currentDate.setMonth(this.currentDate.getMonth() - 1);
            this.updateCalendar();
        },
        
        nextMonth() {
            this.currentDate.setMonth(this.currentDate.getMonth() + 1);
            this.updateCalendar();
        },
        
        updateCalendar() {
            this.$nextTick(() => {
                if (this.selectedDoctor) {
                    this.fetchAvailability();
                }
            });
        },
        
        selectDate(date) {
            if (!date.available || date.isDisabled) return;
            
            this.selectedDate = new Date(date.date);
            this.selectedTimeSlot = null;
            this.fetchAvailableSlots();
            
            // Dispatch event for parent components
            this.$dispatch('date-selected', {
                date: this.selectedDate,
                dateString: date.dateString
            });
        },
        
        selectTimeSlot(slot) {
            if (!slot.available) return;
            
            this.selectedTimeSlot = slot.time;
            
            // Dispatch event for parent components
            this.$dispatch('time-selected', {
                time: slot.time,
                slot: slot
            });
        },
        
        async fetchAvailability() {
            if (!this.selectedDoctor) return;
            
            try {
                const year = this.currentDate.getFullYear();
                const month = this.currentDate.getMonth() + 1;
                
                const response = await fetch(`/mobile-api/appointments/availability?doctor=${this.selectedDoctor}&year=${year}&month=${month}`);
                const data = await response.json();
                
                if (data.success) {
                    // Update calendar dates with availability info
                    this.updateDateAvailability(data.availability);
                }
            } catch (error) {
                console.error('Error fetching availability:', error);
            }
        },
        
        async fetchAvailableSlots() {
            if (!this.selectedDoctor || !this.selectedDate) {
                this.availableSlots = [];
                return;
            }
            
            this.loadingSlots = true;
            try {
                const dateString = this.selectedDate.toISOString().split('T')[0];
                const response = await fetch(`/mobile-api/appointments/slots/${this.selectedDoctor}/${dateString}`);
                const data = await response.json();
                
                if (data.success) {
                    this.availableSlots = data.slots || [];
                } else {
                    this.availableSlots = [];
                }
            } catch (error) {
                console.error('Error fetching slots:', error);
                this.availableSlots = [];
            } finally {
                this.loadingSlots = false;
            }
        },
        
        updateDateAvailability(availability) {
            // Update the calendar dates with real availability data
            // This would be called after fetching availability from the server
            console.log('Updating availability:', availability);
        }
    }
}
</script>