@extends('layouts.header')

@section('title', 'Medical Blog - Dr. Fintan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Medical Blog</h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                    Stay informed with the latest medical insights, health tips, and expert advice from our healthcare professionals.
                </p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="flex flex-wrap -mx-4">
            <!-- Main Content -->
            <div class="w-full lg:w-2/3 px-4">
                <!-- Featured Posts -->
                @if($featuredPosts->count() > 0)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Featured Articles</h2>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($featuredPosts as $post)
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ $post->featured_image_url }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-full h-48 object-cover">
                            </div>
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                        Featured
                                    </span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $post->reading_time }} min read</span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-600">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm line-clamp-3">{{ $post->excerpt }}</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img src="{{ $post->author->profile_image_url ?? asset('assets/images/user_img.png') }}" 
                                             alt="{{ $post->author->name }}" 
                                             class="w-8 h-8 rounded-full mr-2">
                                        <span class="text-sm text-gray-700">{{ $post->author->name }}</span>
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        {{ $post->published_at->format('M j, Y') }}
                                    </span>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Search and Filter -->
                <div class="mb-8">
                    <form method="GET" class="flex flex-wrap gap-4">
                        <div class="flex-1 min-w-64">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search articles..." 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                        @if(request('search') || request('tag'))
                        <a href="{{ route('blog.index') }}" 
                           class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            Clear
                        </a>
                        @endif
                    </form>
                </div>

                <!-- Blog Posts -->
                <div class="space-y-8">
                    @forelse($posts as $post)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="md:flex">
                            <div class="md:w-1/3">
                                <img src="{{ $post->featured_image_url }}" 
                                     alt="{{ $post->title }}" 
                                     class="w-full h-48 md:h-full object-cover">
                            </div>
                            <div class="md:w-2/3 p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    @foreach($post->tags as $tag)
                                    <a href="{{ route('blog.tag', $tag->slug) }}" 
                                       class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs font-medium mr-2 hover:bg-gray-200">
                                        {{ $tag->name }}
                                    </a>
                                    @endforeach
                                    <span class="mx-2">•</span>
                                    <span>{{ $post->reading_time }} min read</span>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900 mb-3">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-600">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img src="{{ $post->author->profile_image_url ?? asset('assets/images/user_img.png') }}" 
                                             alt="{{ $post->author->name }}" 
                                             class="w-10 h-10 rounded-full mr-3">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $post->author->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $post->published_at->format('M j, Y') }}</div>
                                        </div>
                                    </div>
                                    <a href="{{ route('blog.show', $post->slug) }}" 
                                       class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                        Read More <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="text-center py-12">
                        <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">No articles found</h3>
                        <p class="text-gray-600">Try adjusting your search or browse our featured articles above.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3 px-4 mt-8 lg:mt-0">
                <!-- Popular Tags -->
                @if($popularTags->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Popular Topics</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($popularTags as $tag)
                        <a href="{{ route('blog.tag', $tag->slug) }}" 
                           class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm hover:bg-blue-100 hover:text-blue-700 transition-colors">
                            {{ $tag->name }} ({{ $tag->blog_posts_count }})
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Newsletter Signup -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Stay Updated</h3>
                    <p class="text-gray-600 text-sm mb-4">Get the latest health tips and medical insights delivered to your inbox.</p>
                    <form class="space-y-3">
                        <input type="email" 
                               placeholder="Your email address" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                            Subscribe
                        </button>
                    </form>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('appointment') }}" class="text-blue-600 hover:text-blue-800 text-sm">Book Appointment</a></li>
                        <li><a href="{{ route('about') }}" class="text-blue-600 hover:text-blue-800 text-sm">Our Doctors</a></li>
                        <li><a href="{{ route('contact') }}" class="text-blue-600 hover:text-blue-800 text-sm">Contact Us</a></li>
                        <li><a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Emergency Services</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
