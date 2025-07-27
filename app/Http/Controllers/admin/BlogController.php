<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with(['author', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('admin.blog.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'featured_image' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
        ]);

        $validated['author_id'] = Auth::id();
        
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle meta data
        $metaData = [];
        if ($request->meta_title) {
            $metaData['meta_title'] = $request->meta_title;
        }
        if ($request->meta_description) {
            $metaData['meta_description'] = $request->meta_description;
        }
        $validated['meta_data'] = $metaData;

        $post = BlogPost::create($validated);

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $post->addMediaFromRequest('featured_image')
                 ->toMediaCollection('featured');
        }

        // Handle tags
        if ($request->tags) {
            $post->attachTags($request->tags);
        }

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function show(BlogPost $post)
    {
        return view('admin.blog.show', compact('post'));
    }

    public function edit(BlogPost $post)
    {
        $tags = Tag::all();
        $postTags = $post->tags->pluck('name')->toArray();
        
        return view('admin.blog.edit', compact('post', 'tags', 'postTags'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:blog_posts,slug,' . $post->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'featured_image' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
        ]);

        // Handle meta data
        $metaData = $post->meta_data ?? [];
        if ($request->meta_title) {
            $metaData['meta_title'] = $request->meta_title;
        }
        if ($request->meta_description) {
            $metaData['meta_description'] = $request->meta_description;
        }
        $validated['meta_data'] = $metaData;

        $post->update($validated);

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $post->clearMediaCollection('featured');
            $post->addMediaFromRequest('featured_image')
                 ->toMediaCollection('featured');
        }

        // Handle tags
        $post->syncTags($request->tags ?? []);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy(BlogPost $post)
    {
        $post->delete();
        
        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    public function mobileIndex()
    {
        $posts = BlogPost::with(['author', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('mobile.admin.blog', compact('posts'));
    }
}
