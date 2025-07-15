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
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">Settings Management</h1>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Key</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Group</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($settingGroups as $groupKey => $groupLabel)
                                    @if(isset($settings[$groupKey]))
                                        @foreach($settings[$groupKey] as $setting)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $setting->key }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $groupLabel }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('admin.settings.edit', $setting->key) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>