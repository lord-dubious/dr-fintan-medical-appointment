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
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">Media Library</h1>
                        <div class="mb-4 flex items-center space-x-4">
                            <input type="file" id="media-files" name="files[]" multiple class="block">
                            <button id="upload-btn" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">Upload</button>
                            <button id="bulk-delete-btn" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded ml-auto">Delete Selected</button>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3"><input type="checkbox" id="select-all"></th>
                                    <th class="px-6 py-3 text-left">Preview</th>
                                    <th class="px-6 py-3 text-left">Filename</th>
                                    <th class="px-6 py-3 text-left">Size</th>
                                    <th class="px-6 py-3 text-left">MIME Type</th>
                                    <th class="px-6 py-3 text-left">Alt Text</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody id="media-table-body" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($media as $mediaItem)
                                    @include('admin.media.components.media-item', ['media' => $mediaItem])
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $media->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Define route URLs
            const routes = {
                upload: '{{ route("admin.media.upload") }}',
                bulkDelete: '{{ route("admin.media.bulk-delete") }}'
            };
            
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const uploadBtn = document.getElementById('upload-btn');
            const filesInput = document.getElementById('media-files');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const selectAllCheckbox = document.getElementById('select-all');
            const mediaTbody = document.getElementById('media-table-body');

            uploadBtn.addEventListener('click', function() {
                const files = filesInput.files;
                if (!files.length) {
                    alert('Please select files to upload.');
                    return;
                }
                const formData = new FormData();
                Array.from(files).forEach(file => formData.append('files[]', file));
                axios.post(routes.upload, formData)
                    .then(response => {
                        alert(response.data.message);
                        location.reload();
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Error uploading files.');
                    });
            });

            mediaTbody.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-btn')) {
                    const url = e.target.getAttribute('data-url');
                    if (!confirm('Are you sure you want to delete this media item?')) return;
                    axios.delete(url)
                        .then(response => {
                            alert(response.data.message);
                            e.target.closest('tr').remove();
                        })
                        .catch(error => {
                            console.error(error);
                            alert('Error deleting media item.');
                        });
                }
                if (e.target.classList.contains('edit-alt-btn')) {
                    const url = e.target.getAttribute('data-url');
                    const currentAlt = e.target.getAttribute('data-alt-text') || '';
                    const newAlt = prompt('Enter new alt text:', currentAlt);
                    if (newAlt === null) return;
                    axios.put(url, { alt_text: newAlt })
                        .then(response => {
                            alert('Alt text updated.');
                            const row = e.target.closest('tr');
                            row.querySelector('td:nth-child(6)').textContent = newAlt;
                            e.target.setAttribute('data-alt-text', newAlt);
                        })
                        .catch(error => {
                            console.error(error);
                            alert('Error updating alt text.');
                        });
                }
            });

            bulkDeleteBtn.addEventListener('click', function() {
                const selected = Array.from(document.querySelectorAll('.select-media:checked')).map(cb => cb.value);
                if (!selected.length) {
                    alert('No items selected.');
                    return;
                }
                if (!confirm('Delete selected items?')) return;
                axios.post(routes.bulkDelete, { ids: selected })
                    .then(response => {
                        alert(response.data.message);
                        selected.forEach(id => {
                            const row = document.getElementById('media-row-' + id);
                            if (row) row.remove();
                        });
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Error deleting selected items.');
                    });
            });

            selectAllCheckbox.addEventListener('change', function() {
                document.querySelectorAll('.select-media').forEach(cb => cb.checked = selectAllCheckbox.checked);
            });
        });
    </script>
</body>
</html>