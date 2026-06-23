<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogCategory::query();
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
        }
        $categories = $query->orderBy('name')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form', ['category' => new BlogCategory()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:blog_categories,name',
            'slug' => 'nullable|max:100|unique:blog_categories,slug',
        ], [
            'name.required' => 'Please enter the category name.',
            'name.max' => 'The category name cannot exceed 100 characters.',
            'name.unique' => 'This category name already exists.',
            'slug.unique' => 'This slug is already in use by another category.',
            'slug.max' => 'The slug cannot exceed 100 characters.',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $validated['is_active'] = $request->has('is_active');

        BlogCategory::create($validated);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.categories.form', ['category' => $blogCategory]);
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:blog_categories,name,' . $blogCategory->id,
            'slug' => 'required|max:100|unique:blog_categories,slug,' . $blogCategory->id,
        ], [
            'name.required' => 'Please enter the category name.',
            'name.max' => 'The category name cannot exceed 100 characters.',
            'name.unique' => 'This category name already exists.',
            'slug.required' => 'Please enter the category slug.',
            'slug.unique' => 'This slug is already in use by another category.',
            'slug.max' => 'The slug cannot exceed 100 characters.',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $blogCategory->update($validated);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();
        return redirect()->route('admin.blog-categories.index')->with('success', 'Category deleted successfully.');
    }

    public function quickStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:blog_categories,name',
        ], [
            'name.required' => 'Please enter the category name.',
            'name.max' => 'The category name cannot exceed 100 characters.',
            'name.unique' => 'This category name already exists.',
        ]);

        $name = $request->name;
        $slug = Str::slug($name);

        // Ensure unique slug
        $count = BlogCategory::where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . time();
        }

        $category = BlogCategory::create([
            'name' => $name,
            'slug' => $slug,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'id' => $category->id,
            'name' => $category->name,
        ]);
    }
}
