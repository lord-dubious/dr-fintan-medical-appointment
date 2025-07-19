@include('layouts.header')

<body class="bg-gray-50 dark:bg-gray-900 font-inter">
    <section class="dashboard pt-24 pb-16 min-h-screen">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    @include('layouts.admin_navbar')
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-200/50 dark:border-gray-700/50">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                            Edit {{ $setting->label ?? ucwords(str_replace('_', ' ', $setting->key)) }}
                        </h1>
                        <div id="alert-success" class="mb-4 hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">Setting updated successfully!</span>
                            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="document.getElementById('alert-success').classList.add('hidden');">
                                <svg class="fill-current h-6 w-6 text-green-500" role="button" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 8.586L15.95 2.636a1 1 0 111.414 1.414L11.414 10l5.95 5.95a1 1 0 11-1.414 1.414L10 11.414l-5.95 5.95a1 1 0 11-1.414-1.414L8.586 10 2.636 4.05a1 1 0 111.414-1.414L10 8.586z" clip-rule="evenodd"/></svg>
                            </button>
                        </div>
                        <form id="settings-form">
                            @csrf
                            @include('admin.settings.components.settings-form', ['setting' => $setting])
                            <div class="mt-6 space-x-2">
                                <a href="{{ route('admin.settings.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">Cancel</a>
                                @if($setting->type !== 'image')
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">Save Changes</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($setting->type === 'rich_text')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @endif
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize TinyMCE for rich text fields
            const settingType = '{{ $setting->type }}';
            const settingKey = '{{ $setting->key }}';
            
            if (settingType === 'rich_text') {
                tinymce.init({
                    selector: '#setting_' + settingKey,
                    plugins: 'link image code lists',
                    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | code',
                    height: 300
                });
            }

            // Set CSRF token for axios
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

            if (settingType === 'image') {
                // Image upload handler
                const imageInput = document.getElementById('image_input_' + settingKey);
                if (imageInput) {
                    imageInput.addEventListener('change', function (e) {
                        const file = e.target.files[0];
                        const key = e.target.dataset.key;
                        const formData = new FormData();
                        formData.append('image', file);
                        formData.append('setting_key', key);

                        axios.post('{{ route("admin.settings.upload-image") }}', formData, {
                            headers: { 'Content-Type': 'multipart/form-data' }
                        })
                        .then(response => {
                            const preview = document.getElementById('preview_' + key);
                            if (preview && preview.tagName === 'IMG') {
                                preview.src = response.data.image_url;
                            }
                            document.getElementById('alert-success').classList.remove('hidden');
                        })
                        .catch(error => {
                            if (error.response && error.response.data.errors && error.response.data.errors.image) {
                                const errorEl = document.getElementById('error_' + key);
                                if (errorEl) {
                                    errorEl.textContent = error.response.data.errors.image[0];
                                }
                            }
                        });
                    });
                }
            } else {
                // Form submission handler for non-image settings
                const settingsForm = document.getElementById('settings-form');
                if (settingsForm) {
                    settingsForm.addEventListener('submit', function (e) {
                        e.preventDefault();
                        
                        // Trigger TinyMCE save if it's a rich text field
                        if (settingType === 'rich_text' && typeof tinymce !== 'undefined') {
                            tinymce.triggerSave();
                        }
                        
                        const formData = new FormData(this);

                        axios.post('{{ route("admin.settings.update") }}', formData)
                            .then(response => {
                                document.getElementById('alert-success').classList.remove('hidden');
                            })
                            .catch(error => {
                                if (error.response && error.response.data.errors) {
                                    Object.keys(error.response.data.errors).forEach(function(fieldName) {
                                        const key = fieldName.replace('settings.', '');
                                        const el = document.getElementById('error_' + key);
                                        if (el) {
                                            el.textContent = error.response.data.errors[fieldName][0];
                                        }
                                    });
                                }
                            });
                    });
                }
            }
        });
    </script>
</body>
</html>