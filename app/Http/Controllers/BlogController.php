<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index', [
            'blogs' => Blog::published()->with('category', 'author')->latest('published_at')->paginate(9),
            'categories' => BlogCategory::withCount('blogs')->get(),
        ]);
    }

    public function show(Blog $blog)
    {
        abort_unless($blog->status === 'published', 404);

        $blog->increment('views');

        return view('blog.show', [
            'blog' => $blog->load('category', 'author'),
            'recent' => Blog::published()->where('id', '!=', $blog->id)->latest('published_at')->take(4)->get(),
        ]);
    }
}
