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
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">Content Management</h1>
                        <div class="space-y-4">
                            @php use App\Models\PageContent; @endphp
                            @foreach($pages as $slug => $name)
                                @php $sections = PageContent::getPageContent($slug); @endphp
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-4 flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                    <div>
                                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{ $name }}</h2>
                                        @if(count($sections) > 0)
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                Sections: {{ implode(', ', array_keys($sections)) }}
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-600 dark:text-gray-300">No sections available</p>
                                        @endif
                                    </div>
                                    <div class="mt-4 sm:mt-0">
                                        <a href="{{ route('admin.content.edit-page', $slug) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>