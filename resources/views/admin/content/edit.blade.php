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
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">Edit {{ $pageName }}</h1>
                        <div id="alert-success" class="mb-4 hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">Content updated successfully!</span>
                            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="document.getElementById('alert-success').classList.add('hidden');">
                                <svg class="fill-current h-6 w-6 text-green-500" role="button" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 8.586L15.95 2.636a1 1 0 111.414 1.414L11.414 10l5.95 5.95a1 1 0 11-1.414 1.414L10 11.414l-5.95 5.95a1 1 0 11-1.414-1.414L8.586 10 2.636 4.05a1 1 0 111.414-1.414L10 8.586z" clip-rule="evenodd"/></svg>
                            </button>
                        </div>
                        <form id="content-form">
                            @csrf
                            @foreach($pageContent as $section => $contents)
                                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-6 mb-4">{{ ucwords(str_replace('_',' ',$section)) }}</h2>
                                @foreach($contents as $key => $value)
                                    @include('admin.content.components.content-form', ['section' => $section, 'key' => $key, 'value' => $value])
                                @endforeach
                            @endforeach
                            <div class="mt-6">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'link image code lists',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | code',
        height: 300
    });

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

    document.getElementById('content-form').addEventListener('submit', function(e) {
        e.preventDefault();
        tinymce.triggerSave();
        const formData = new FormData(this);

        axios.post("{{ route('admin.content.update-page', $page) }}", formData)
            .then(response => {
                document.getElementById('alert-success').classList.remove('hidden');
            })
            .catch(error => {
                if (error.response && error.response.data.errors) {
                    Object.keys(error.response.data.errors).forEach(function(fieldName) {
                        const field = fieldName.replace('content.','').replace(/\./g,'_');
                        const el = document.getElementById('error_' + field);
                        if (el) {
                            el.textContent = error.response.data.errors[fieldName][0];
                        }
                    });
                }
            });
    });
</script>
</body>
</html>
