{{-- Mobile Form Wizard Component --}}
<div x-data="formWizard()" class="min-h-screen bg-gray-50">
    <!-- Progress Header -->
    <div class="bg-white shadow-sm px-4 py-4 sticky top-0 z-10">
        <div class="flex items-center justify-between mb-4">
            <button @click="goBack()" class="p-2 -ml-2 touch-target">
                <i class="fas fa-arrow-left text-gray-600"></i>
            </button>
            <h1 class="text-lg font-semibold text-gray-900" x-text="title"></h1>
            <div class="w-8"></div> <!-- Spacer -->
        </div>
        
        <!-- Progress Bar -->
        <div class="mb-2">
            <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                <template x-for="(step, index) in steps" :key="index">
                    <span :class="currentStep >= index + 1 ? 'text-mobile-primary font-medium' : ''" 
                          x-text="step.label"></span>
                </template>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-mobile-primary h-2 rounded-full transition-all duration-300" 
                     :style="`width: ${(currentStep / steps.length) * 100}%`"></div>
            </div>
        </div>
        
        <!-- Step Info -->
        <div class="text-center">
            <p class="text-sm text-gray-600" x-text="getCurrentStepDescription()"></p>
        </div>
    </div>

    <!-- Form Content -->
    <div class="flex-1 p-4">
        <form @submit.prevent="handleSubmit()">
            <!-- Dynamic Step Content -->
            <template x-for="(step, index) in steps" :key="index">
                <div x-show="currentStep === index + 1" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-x-full"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-x-0"
                     x-transition:leave-end="opacity-0 transform -translate-x-full">
                    
                    <div class="space-y-6">
                        <!-- Step Title -->
                        <div class="text-center" x-show="step.title">
                            <h2 class="text-xl font-bold text-gray-900 mb-2" x-text="step.title"></h2>
                            <p class="text-gray-600" x-text="step.description"></p>
                        </div>

                        <!-- Step Fields -->
                        <div class="space-y-4">
                            <template x-for="field in step.fields" :key="field.name">
                                <div>
                                    <!-- Field Label -->
                                    <label :for="field.name" 
                                           class="block text-sm font-medium text-gray-700 mb-2"
                                           x-text="field.label"></label>
                                    
                                    <!-- Text Input -->
                                    <template x-if="field.type === 'text' || field.type === 'email' || field.type === 'tel'">
                                        <div class="relative">
                                            <input :type="field.type"
                                                   :id="field.name"
                                                   :name="field.name"
                                                   :placeholder="field.placeholder"
                                                   :required="field.required"
                                                   x-model="formData[field.name]"
                                                   :class="getInputClasses(field)"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary">
                                            <i x-show="field.icon" 
                                               :class="field.icon" 
                                               class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        </div>
                                    </template>

                                    <!-- Textarea -->
                                    <template x-if="field.type === 'textarea'">
                                        <textarea :id="field.name"
                                                  :name="field.name"
                                                  :placeholder="field.placeholder"
                                                  :required="field.required"
                                                  :rows="field.rows || 3"
                                                  x-model="formData[field.name]"
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary"></textarea>
                                    </template>

                                    <!-- Select -->
                                    <template x-if="field.type === 'select'">
                                        <select :id="field.name"
                                                :name="field.name"
                                                :required="field.required"
                                                x-model="formData[field.name]"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary">
                                            <option value="" x-text="field.placeholder"></option>
                                            <template x-for="option in field.options" :key="option.value">
                                                <option :value="option.value" x-text="option.label"></option>
                                            </template>
                                        </select>
                                    </template>

                                    <!-- Radio Group -->
                                    <template x-if="field.type === 'radio'">
                                        <div class="space-y-3">
                                            <template x-for="option in field.options" :key="option.value">
                                                <label class="flex items-center p-4 bg-white rounded-xl border-2 transition-colors cursor-pointer"
                                                       :class="formData[field.name] === option.value ? 'border-mobile-primary bg-blue-50' : 'border-gray-200'">
                                                    <input type="radio"
                                                           :name="field.name"
                                                           :value="option.value"
                                                           x-model="formData[field.name]"
                                                           class="sr-only">
                                                    <div class="flex items-center">
                                                        <div x-show="option.icon" 
                                                             class="h-10 w-10 rounded-full flex items-center justify-center mr-3"
                                                             :class="option.iconBg || 'bg-gray-100'">
                                                            <i :class="option.icon" 
                                                               :class="option.iconColor || 'text-gray-600'"></i>
                                                        </div>
                                                        <div class="flex-1">
                                                            <div class="font-medium text-gray-900" x-text="option.label"></div>
                                                            <div x-show="option.description" 
                                                                 class="text-sm text-gray-600" 
                                                                 x-text="option.description"></div>
                                                        </div>
                                                        <div class="ml-2">
                                                            <i class="fas fa-check-circle text-mobile-primary" 
                                                               x-show="formData[field.name] === option.value"></i>
                                                        </div>
                                                    </div>
                                                </label>
                                            </template>
                                        </div>
                                    </template>

                                    <!-- Date Input -->
                                    <template x-if="field.type === 'date'">
                                        <input type="date"
                                               :id="field.name"
                                               :name="field.name"
                                               :required="field.required"
                                               x-model="formData[field.name]"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-mobile-primary focus:border-mobile-primary">
                                    </template>

                                    <!-- Checkbox -->
                                    <template x-if="field.type === 'checkbox'">
                                        <label class="flex items-start">
                                            <input type="checkbox"
                                                   :id="field.name"
                                                   :name="field.name"
                                                   :required="field.required"
                                                   x-model="formData[field.name]"
                                                   class="h-4 w-4 text-mobile-primary focus:ring-mobile-primary border-gray-300 rounded mt-1">
                                            <span class="ml-3 text-sm text-gray-600" x-html="field.label"></span>
                                        </label>
                                    </template>

                                    <!-- Field Error -->
                                    <div x-show="errors[field.name]" 
                                         class="mt-2 text-sm text-red-600" 
                                         x-text="errors[field.name]"></div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </form>
    </div>

    <!-- Bottom Navigation -->
    <div class="bg-white border-t px-4 py-4 space-y-3">
        <div class="flex space-x-3">
            <button x-show="currentStep > 1" 
                    @click="previousStep()"
                    type="button"
                    class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-semibold active:scale-95 transition-transform">
                Back
            </button>
            <button x-show="currentStep < steps.length" 
                    @click="nextStep()"
                    type="button"
                    :disabled="!canProceed()"
                    :class="canProceed() ? 'bg-mobile-primary text-white' : 'bg-gray-300 text-gray-500'"
                    class="flex-1 py-3 px-6 rounded-xl font-semibold active:scale-95 transition-transform">
                Continue
            </button>
            <button x-show="currentStep === steps.length" 
                    @click="submitForm()"
                    type="button"
                    :disabled="isSubmitting"
                    class="flex-1 bg-mobile-primary text-white py-3 px-6 rounded-xl font-semibold active:scale-95 transition-transform disabled:opacity-50">
                <span x-show="!isSubmitting">Submit</span>
                <span x-show="isSubmitting" class="flex items-center justify-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Submitting...
                </span>
            </button>
        </div>
    </div>
</div>

<script>
function formWizard(config = {}) {
    return {
        title: config.title || 'Form Wizard',
        steps: config.steps || [],
        currentStep: 1,
        formData: {},
        errors: {},
        isSubmitting: false,
        onSubmit: config.onSubmit || null,

        init() {
            // Initialize form data with default values
            this.steps.forEach(step => {
                step.fields.forEach(field => {
                    if (field.default !== undefined) {
                        this.formData[field.name] = field.default;
                    } else {
                        this.formData[field.name] = field.type === 'checkbox' ? false : '';
                    }
                });
            });
        },

        getCurrentStepDescription() {
            const step = this.steps[this.currentStep - 1];
            return step ? step.description : '';
        },

        getInputClasses(field) {
            let classes = '';
            if (field.icon) {
                classes += 'pl-12 ';
            }
            if (this.errors[field.name]) {
                classes += 'border-red-500 ';
            }
            return classes;
        },

        canProceed() {
            const currentStepData = this.steps[this.currentStep - 1];
            if (!currentStepData) return false;

            // Check if all required fields in current step are filled
            return currentStepData.fields.every(field => {
                if (!field.required) return true;
                const value = this.formData[field.name];
                return value !== '' && value !== null && value !== undefined;
            });
        },

        nextStep() {
            if (this.canProceed() && this.currentStep < this.steps.length) {
                this.validateCurrentStep();
                if (Object.keys(this.errors).length === 0) {
                    this.currentStep++;
                }
            }
        },

        previousStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
                this.clearErrors();
            }
        },

        goBack() {
            if (this.currentStep > 1) {
                this.previousStep();
            } else {
                window.history.back();
            }
        },

        validateCurrentStep() {
            this.clearErrors();
            const currentStepData = this.steps[this.currentStep - 1];
            
            currentStepData.fields.forEach(field => {
                const value = this.formData[field.name];
                
                // Required field validation
                if (field.required && (!value || value === '')) {
                    this.errors[field.name] = `${field.label} is required`;
                }
                
                // Email validation
                if (field.type === 'email' && value && !this.isValidEmail(value)) {
                    this.errors[field.name] = 'Please enter a valid email address';
                }
                
                // Custom validation
                if (field.validate && value) {
                    const validationResult = field.validate(value);
                    if (validationResult !== true) {
                        this.errors[field.name] = validationResult;
                    }
                }
            });
        },

        isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },

        clearErrors() {
            this.errors = {};
        },

        async submitForm() {
            this.validateCurrentStep();
            
            if (Object.keys(this.errors).length > 0) {
                return;
            }

            this.isSubmitting = true;

            try {
                if (this.onSubmit) {
                    await this.onSubmit(this.formData);
                } else {
                    // Default submission logic
                    console.log('Form submitted:', this.formData);
                }

                this.$dispatch('form-submitted', { data: this.formData });
                
            } catch (error) {
                console.error('Form submission error:', error);
                this.$dispatch('form-error', { error: error.message });
            } finally {
                this.isSubmitting = false;
            }
        },

        // Public methods for external control
        setFormData(data) {
            this.formData = { ...this.formData, ...data };
        },

        goToStep(stepNumber) {
            if (stepNumber >= 1 && stepNumber <= this.steps.length) {
                this.currentStep = stepNumber;
            }
        },

        reset() {
            this.currentStep = 1;
            this.clearErrors();
            this.init();
        }
    }
}
</script>