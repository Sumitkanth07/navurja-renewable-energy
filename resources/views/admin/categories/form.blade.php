@extends('layouts.admin')
@section('content')
<h1>{{ $category->exists ? 'Edit Category' : 'Add Category' }}</h1>

<form class="panel form" method="post" action="{{ $category->exists ? route('admin.blog-categories.update', $category) : route('admin.blog-categories.store') }}">
    @csrf
    @if($category->exists)
        @method('put')
    @endif

    <label>Category Name
        <input id="name" name="name" value="{{ old('name', $category->name) }}" required>
    </label>

    <label>Slug
        <input id="slug" name="slug" value="{{ old('slug', $category->slug) }}" data-edited="{{ $category->exists ? 'true' : 'false' }}">
    </label>

    <label class="check">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->exists ? $category->is_active : true) ? 'checked' : '' }}> Active
    </label>

    <button>Save Category</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function() {
            if (slugInput.dataset.edited !== 'true') {
                slugInput.value = nameInput.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)+/g, '');
            }
        });
        
        slugInput.addEventListener('input', function() {
            slugInput.dataset.edited = 'true';
        });
    }
});
</script>
@endsection
