<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Services\FileUploadService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected FileUploadService $files)
    {
    }

    public function index()
    {
        return view('admin.blogs.index', ['blogs' => Blog::with('category')->latest()->paginate(15)]);
    }

    public function create()
    {
        $this->authorize('create', Blog::class);

        return view('admin.blogs.create', ['categories' => BlogCategory::all()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blog_category_id' => ['required', 'exists:blog_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $thumbnail = $request->hasFile('thumbnail')
            ? $this->files->upload($request->file('thumbnail'), 'blogs')
            : null;

        Blog::create([
            ...$validated,
            'user_id' => Auth::id(),
            'slug' => Str::slug($validated['title']) . '-' . random_int(1000, 99999),
            'thumbnail' => $thumbnail,
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created.');
    }

    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);

        return view('admin.blogs.edit', ['blog' => $blog, 'categories' => BlogCategory::all()]);
    }

    public function update(Request $request, Blog $blog)
    {
        $this->authorize('update', $blog);

        $validated = $request->validate([
            'blog_category_id' => ['required', 'exists:blog_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $blog->update([
            ...$validated,
            'published_at' => $validated['status'] === 'published' ? ($blog->published_at ?? now()) : null,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated.');
    }

    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);

        $blog->delete();

        return back()->with('success', 'Blog post deleted.');
    }
}
