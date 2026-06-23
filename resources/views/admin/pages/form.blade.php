<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
    <div>
        <h3>General Information</h3>
        <label>Page Title</label>
        <input type="text" name="title" value="{{ old('title', $page->title ?? '') }}" required>

        <label>Slug (Leave blank to auto-generate)</label>
        <input type="text" name="slug" value="{{ old('slug', $page->slug ?? '') }}">

        <label>Page Content</label>
        <textarea name="content" id="content">{{ old('content', $page->content ?? '') }}</textarea>

        <hr style="margin: 20px 0;">

        <h3>SEO Settings</h3>
        <label>SEO Title</label>
        <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title ?? '') }}">

        <label>Meta Description</label>
        <textarea name="meta_description" rows="3">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>

        <label>Meta Keywords</label>
        <textarea name="meta_keywords" rows="2">{{ old('meta_keywords', $page->meta_keywords ?? '') }}</textarea>

        <label>Canonical URL</label>
        <input type="url" name="canonical_url" value="{{ old('canonical_url', $page->canonical_url ?? '') }}">

        <label>
            <input type="checkbox" name="is_index" value="1" {{ old('is_index', $page->is_index ?? true) ? 'checked' : '' }}>
            Allow search engines to index this page (Robots Index)
        </label>
    </div>
    
    <div>
        <h3>Publishing</h3>
        <label>
            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $page->is_published ?? true) ? 'checked' : '' }}>
            Published
        </label>
        
        <hr style="margin: 20px 0;">

        <h3>Media</h3>
        <label>Featured Image</label>
        @if(isset($page) && $page->featured_image)
            <img src="{{ asset('storage/' . $page->featured_image) }}" style="max-width: 100%; margin-bottom: 10px;">
        @endif
        <input type="file" name="featured_image" accept="image/*">

        <hr style="margin: 20px 0;">

        <h3>Open Graph Tags (Social Media)</h3>
        <label>OG Title</label>
        <input type="text" name="og_title" value="{{ old('og_title', $page->og_title ?? '') }}">

        <label>OG Description</label>
        <textarea name="og_description" rows="3">{{ old('og_description', $page->og_description ?? '') }}</textarea>

        <label>OG Image</label>
        @if(isset($page) && $page->og_image)
            <img src="{{ asset('storage/' . $page->og_image) }}" style="max-width: 100%; margin-bottom: 10px;">
        @endif
        <input type="file" name="og_image" accept="image/*">
    </div>
</div>
