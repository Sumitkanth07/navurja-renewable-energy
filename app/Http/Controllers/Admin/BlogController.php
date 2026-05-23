<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresUploads;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use StoresUploads;

    public function index() { return view('admin.blogs.index', ['posts' => Blog::with('category')->latest()->paginate(15)]); }
    public function create() { return view('admin.blogs.form', ['post' => new Blog(), 'categories' => BlogCategory::orderBy('name')->get()]); }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;
        $data['featured_image'] = $this->uploadImage($request->file('featured_image'));
        Blog::create($data);
        return redirect()->route('admin.blogs.index')->with('success', 'Blog saved successfully.');
    }

    public function edit(Blog $blog) { return view('admin.blogs.form', ['post' => $blog, 'categories' => BlogCategory::orderBy('name')->get()]); }

    public function update(Request $request, Blog $blog)
    {
        $data = $this->validated($request, $blog->id);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($blog->published_at ?? now()) : null;
        if ($path = $this->uploadImage($request->file('featured_image'))) $data['featured_image'] = $path;
        $blog->update($data);
        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return back()->with('success', 'Blog deleted successfully.');
    }

    private function validated(Request $request, ?int $ignore = null): array
    {
        return $request->validate([
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'title' => 'required|max:180',
            'slug' => 'nullable|max:200|unique:blogs,slug,'.($ignore ?? 'NULL'),
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'content' => 'required',
            'meta_title' => 'nullable|max:180',
            'meta_description' => 'nullable|max:300',
        ]);
    }
}
