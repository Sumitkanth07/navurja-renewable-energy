<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query();
        
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('is_published', $request->status);
        }

        $pages = $query->latest()->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:pages,slug|max:255',
            'featured_image' => 'nullable|image|max:2048',
            'content' => 'nullable',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|max:255',
            'og_description' => 'nullable',
            'og_image' => 'nullable|image|max:2048',
            'is_index' => 'boolean',
            'is_published' => 'boolean',
        ], [
            'title.required' => 'Please enter the page title.',
            'title.max' => 'The page title cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already in use by another page. Please choose a different slug.',
            'slug.max' => 'The slug cannot exceed 255 characters.',
            'featured_image.image' => 'The featured file must be a valid image.',
            'featured_image.max' => 'The featured image size must not exceed 2MB.',
            'canonical_url.url' => 'Please enter a valid canonical URL.',
            'og_image.image' => 'The Open Graph file must be a valid image.',
            'og_image.max' => 'The Open Graph image size must not exceed 2MB.',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            // Ensure unique
            $count = Page::where('slug', $validated['slug'])->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . time();
            }
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }
        
        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $request->file('og_image')->store('pages', 'public');
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:pages,slug,' . $page->id,
            'featured_image' => 'nullable|image|max:2048',
            'content' => 'nullable',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|max:255',
            'og_description' => 'nullable',
            'og_image' => 'nullable|image|max:2048',
            'is_index' => 'boolean',
            'is_published' => 'boolean',
        ], [
            'title.required' => 'Please enter the page title.',
            'title.max' => 'The page title cannot exceed 255 characters.',
            'slug.required' => 'Please enter the page slug.',
            'slug.unique' => 'This slug is already in use by another page. Please choose a different slug.',
            'slug.max' => 'The slug cannot exceed 255 characters.',
            'featured_image.image' => 'The featured file must be a valid image.',
            'featured_image.max' => 'The featured image size must not exceed 2MB.',
            'canonical_url.url' => 'Please enter a valid canonical URL.',
            'og_image.image' => 'The Open Graph file must be a valid image.',
            'og_image.max' => 'The Open Graph image size must not exceed 2MB.',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }
        
        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $request->file('og_image')->store('pages', 'public');
        }

        // Set booleans if not present (unchecked)
        $validated['is_index'] = $request->has('is_index');
        $validated['is_published'] = $request->has('is_published');

        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No pages selected.');
        }

        switch ($action) {
            case 'publish':
                Page::whereIn('id', $ids)->update(['is_published' => true]);
                $message = 'Selected pages published.';
                break;
            case 'unpublish':
                Page::whereIn('id', $ids)->update(['is_published' => false]);
                $message = 'Selected pages unpublished.';
                break;
            case 'delete':
                Page::whereIn('id', $ids)->delete();
                $message = 'Selected pages deleted.';
                break;
            default:
                return redirect()->back()->with('error', 'Invalid action.');
        }

        return redirect()->back()->with('success', $message);
    }
}
