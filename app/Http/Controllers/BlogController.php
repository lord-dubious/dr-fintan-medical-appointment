<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::published()
            ->with(['author', 'tags'])
            ->orderBy('published_at', 'desc');

        // Filter by tag
        if ($request->has('tag')) {
            $query->withAnyTags([$request->tag]);
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(12);
        $featuredPosts = BlogPost::published()->featured()->limit(3)->get();
        $popularTags = Tag::withCount('blogPosts')->orderBy('blog_posts_count', 'desc')->limit(10)->get();

        // Detect mobile
        $isMobile = $request->header('User-Agent') && 
                   (strpos($request->header('User-Agent'), 'Mobile') !== false ||
                    strpos($request->header('User-Agent'), 'Android') !== false ||
                    strpos($request->header('User-Agent'), 'iPhone') !== false);

        $view = $isMobile ? 'mobile.blog.index' : 'blog.index';

        return view($view, compact('posts', 'featuredPosts', 'popularTags'));
    }

    public function show(BlogPost $post)
    {
        if (!$post->isPublished()) {
            abort(404);
        }

        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->withAnyTags($post->tags->pluck('name')->toArray())
            ->limit(4)
            ->get();

        // Detect mobile
        $isMobile = request()->header('User-Agent') && 
                   (strpos(request()->header('User-Agent'), 'Mobile') !== false ||
                    strpos(request()->header('User-Agent'), 'Android') !== false ||
                    strpos(request()->header('User-Agent'), 'iPhone') !== false);

        $view = $isMobile ? 'mobile.blog.show' : 'blog.show';

        return view($view, compact('post', 'relatedPosts'));
    }

    public function byTag(Tag $tag)
    {
        $posts = BlogPost::published()
            ->withAnyTags([$tag->name])
            ->with(['author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        // Detect mobile
        $isMobile = request()->header('User-Agent') && 
                   (strpos(request()->header('User-Agent'), 'Mobile') !== false ||
                    strpos(request()->header('User-Agent'), 'Android') !== false ||
                    strpos(request()->header('User-Agent'), 'iPhone') !== false);

        $view = $isMobile ? 'mobile.blog.tag' : 'blog.tag';

        return view($view, compact('posts', 'tag'));
    }
}