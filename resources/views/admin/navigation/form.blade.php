@extends('layouts.admin')
@section('content')
@php
    $parents = \App\Models\NavigationItem::where('id', '!=', $item->id)->whereNull('parent_id')->get();
@endphp
<h1>{{ $item->exists ? 'Edit Navigation' : 'Add Navigation' }}</h1>
<form class="panel form" method="post" action="{{ $item->exists ? route('admin.navigation.update',$item) : route('admin.navigation.store') }}">
    @csrf 
    @if($item->exists) @method('put') @endif
    
    <label>Label<input name="label" value="{{ old('label',$item->label) }}" required></label>
    
    <label>Link Type</label>
    <select id="link_type" onchange="toggleLinkInput()">
        <option value="page">CMS Page</option>
        <option value="custom" {{ (old('url', $item->url) && !str_starts_with(old('url', $item->url), '/')) || old('url', $item->url) === '/' ? 'selected' : '' }}>Custom Link</option>
    </select>

    <div id="page_selector" style="margin-top: 10px;">
        <label>Select Page
            <select id="page_url" name="url" {{ old('url', $item->url) && !str_starts_with(old('url', $item->url), '/') && old('url', $item->url) !== '/' ? 'disabled' : '' }}>
                <option value="/">Home Page (/)</option>
                <option value="/blog" {{ old('url', $item->url) == '/blog' ? 'selected' : '' }}>Blog (/blog)</option>
                <option value="/calculator" {{ old('url', $item->url) == '/calculator' ? 'selected' : '' }}>Calculator (/calculator)</option>
                @foreach($pages as $page)
                    <option value="/{{ $page->slug }}" {{ old('url', $item->url) == '/'.$page->slug ? 'selected' : '' }}>{{ $page->title }} ({{ '/'.$page->slug }})</option>
                @endforeach
            </select>
        </label>
    </div>

    <div id="custom_link_input" style="display: none; margin-top: 10px;">
        <label>Custom URL
            <input id="custom_url" name="url" value="{{ old('url',$item->url) }}" placeholder="https://example.com or #section" {{ old('url', $item->url) && str_starts_with(old('url', $item->url), '/') && old('url', $item->url) !== '/' ? 'disabled' : '' }}>
        </label>
    </div>

    <script>
        function toggleLinkInput() {
            var type = document.getElementById('link_type').value;
            if (type === 'page') {
                document.getElementById('page_selector').style.display = 'block';
                document.getElementById('page_url').disabled = false;
                document.getElementById('custom_link_input').style.display = 'none';
                document.getElementById('custom_url').disabled = true;
            } else {
                document.getElementById('page_selector').style.display = 'none';
                document.getElementById('page_url').disabled = true;
                document.getElementById('custom_link_input').style.display = 'block';
                document.getElementById('custom_url').disabled = false;
            }
        }
        // Initialize on load
        window.onload = function() {
            var initialUrl = "{{ old('url', $item->url) }}";
            var isCustom = initialUrl !== '' && !initialUrl.startsWith('/') && initialUrl !== '/' && initialUrl !== '/blog' && initialUrl !== '/calculator';
            // Also check if it's a page that doesn't exist anymore
            
            if (isCustom) {
                document.getElementById('link_type').value = 'custom';
            }
            toggleLinkInput();
        };
    </script>
    
    <label style="margin-top: 15px;">Menu Position
        <select name="menu_position" required>
            <option value="header" {{ old('menu_position', $item->menu_position) === 'header' ? 'selected' : '' }}>Header Menu</option>
            <option value="footer" {{ old('menu_position', $item->menu_position) === 'footer' ? 'selected' : '' }}>Footer Menu</option>
        </select>
    </label>

    <label>Parent Item (For nested header menus)
        <select name="parent_id">
            <option value="">None (Top Level)</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" {{ old('parent_id', $item->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->label }} ({{ ucfirst($parent->menu_position) }})</option>
            @endforeach
        </select>
    </label>

    <label>Sort order<input type="number" name="sort_order" value="{{ old('sort_order',$item->sort_order ?? 0) }}"></label>
    <label class="check"><input type="checkbox" name="is_active" value="1" {{ old('is_active',$item->is_active ?? true) ? 'checked' : '' }}> Active</label>
    <button>Save Navigation</button>
</form>
@endsection
