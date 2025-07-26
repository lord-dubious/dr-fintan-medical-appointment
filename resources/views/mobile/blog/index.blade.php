@extends('mobile.layouts.app')

@section('title', 'Medical Blog')

@section('content')
<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Header -->
    <div class="bg-gradient-to-r from-mobile-primary-500 to-mobile-primary-600 text-white">
        <div class="px-4 py-6">
            <h1 class="text-2xl font-bold mb-2">Medical Blog</h1>
            <p class="text-mobile-primary-100 text-sm">Latest health insights and expert advice</p>
        </div>
    </div>

    <!-- Search -->
    <div class="px-4 py-4 bg-white border-b border-gray-200">
        <form method="GET" class="relative">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search articles..." 
                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mobile-primary-500 focus:border-transparent">
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            @if(request('search'))
            <a href="{{ route('blog.index') }}" 
               class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </a>
            @endif
        </form>
    </div>

    <!-- Featured Posts -->
    @if($featuredPosts->count() > 0)
    <div class="px-4 py-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Featured Articles</h2>
        <div class="space-y-4">
            @foreach($featuredPosts->take(2) as $post)
            <article class="bg-white rounded-lg shadow-sm overflow-hidden">
                <img src="{{ $post->featured_image_url }}" 
                     alt="{{ $post->title }}" 
                     class="w-full h-40 object-cover">
                <div class="p-4">
                    <div class="flex items-center text-xs text-gray-500 mb-2">
                        <span class="bg-mobile-primary-100 text-mobile-primary-700 px-2 py-1 rounded-full font-medium">
                            Featured
                        </span>
                        <span class="mx-2">•</span>
                        <span>{{ $post->reading_time }} min read</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                        <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-mobile-primary-600">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ $post->excerpt }}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="{{ $post->author->profile_image_url ?? asset('assets/images/user_img.png') }}" 
                                 alt="{{ $post->author->name }}" 
                                 class="w-6 h-6 rounded-full mr-2">
                            <span class="text-xs text-gray-700">{{ $post->author->name }}</span>
                        </div>
                        <span class="text-xs text-gray-500">
                            {{ $post->published_at->format('M j') }}
                        </span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Popular Tags -->
    @if($popularTags->count() > 0)
    <div class="px-4 py-4 bg-white border-b border-gray-200">
        <h3 class="text-sm font-medium text-gray-900 mb-3">Popular Topics</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($popularTags->take(6) as $tag)
            <a href="{{ route('blog.tag', $tag->slug) }}" 
               class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs hover:bg-mobile-primary-100 hover:text-mobile-primary-700 transition-colors">
                {{ $tag->name }}
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Blog Posts -->
    <div class="px-4 py-6">
        <div class="space-y-4">
            @forelse($posts as $post)
            <article class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="flex">
                    <img src="{{ $post->featured_image_url }}" 
                         alt="{{ $post->title }}" 
                         class="w-24 h-24 object-cover flex-shrink-0">
                    <div class="flex-1 p-4">
                        <div class="flex items-center text-xs text-gray-500 mb-1">
                            @if($post->tags->first())
                            <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">
                                {{ $post->tags->first()->name }}
                            </span>
                            <span class="mx-2">•</span>
                            @endif
                            <span>{{ $post->reading_time }} min</span>
                        </div>
                        <h3 class="font-medium text-gray-900 mb-1 line-clamp-2 text-sm">
                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-mobile-primary-600">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-xs line-clamp-2 mb-2">{{ $post->excerpt }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">{{ $post->author->name }}</span>
                            <span class="text-xs text-gray-500">{{ $post->published_at->format('M j') }}</span>
                        </div>
                    </div>
                </div>
            </article>
            @empty
            <div class="text-center py-12">
                <i class="fas fa-search text-3xl text-gray-400 mb-3"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No articles found</h3>
                <p class="text-gray-600 text-sm">Try adjusting your search terms.</p>
            </div>
            @endforelse
        </div>

        <!-- Load More Button -->
        @if($posts->hasMorePages())
        <div class="mt-6 text-center">
            <a href="{{ $posts->nextPageUrl() }}" 
               class="inline-flex items-center px-6 py-3 bg-mobile-primary-500 text-white rounded-lg hover:bg-mobile-primary-600 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Load More Articles
            </a>
        </div>
        @endif
    </div>
</div>
@endsection