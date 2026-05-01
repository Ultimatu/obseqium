<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController
{
    public function index(Request $request)
    {
        $categories = BlogCategory::orderBy('order')->withCount('posts')->get();
        $posts = BlogPost::published()
            ->with(['author', 'category'])
            ->when($request->q, fn ($q, $search) => $q->where('title', 'like', "%{$search}%")->orWhere('excerpt', 'like', "%{$search}%"))
            ->latest('published_at')
            ->paginate(9);

        return view('pages.blog.index', compact('posts', 'categories'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->with(['author', 'category', 'tags'])->firstOrFail();
        $post->incrementViews();

        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where('blog_category_id', $post->blog_category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.blog.show', compact('post', 'related'));
    }

    public function category(string $slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();
        $posts = BlogPost::published()
            ->where('blog_category_id', $category->id)
            ->with(['author'])
            ->latest('published_at')
            ->paginate(9);

        return view('pages.blog.category', compact('posts', 'category'));
    }
}
