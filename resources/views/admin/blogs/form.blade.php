@extends('layouts.admin')
@section('content')
<style>
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<h1>{{ $post->exists ? 'Edit Blog' : 'Add Blog' }}</h1>
<form class="panel form" method="post" enctype="multipart/form-data" action="{{ $post->exists ? route('admin.blogs.update',$post) : route('admin.blogs.store') }}">
    @csrf 
    @if($post->exists)@method('put')@endif
    
    <label>Title<input name="title" value="{{ old('title',$post->title) }}" required></label>
    <label>Slug<input name="slug" value="{{ old('slug',$post->slug) }}"></label>
    
    <label>Category
        <div style="display:flex; gap:10px; align-items:center; margin-top:5px;">
            <select id="blog_category_id" name="blog_category_id" style="flex:1;">
                <option value="">Select</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('blog_category_id',$post->blog_category_id)==$cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="button" id="quick-add-cat-btn" style="padding: 10px 15px; background: var(--primary, #0c6b3f); color: white; border: none; border-radius: 4px; cursor: pointer; white-space: nowrap;">+ Add New Category</button>
        </div>
    </label>
    <label>Featured Image<input type="file" name="featured_image" accept="image/*"></label>
    @if($post->featured_image)
        <img class="preview" src="{{ asset('storage/'.$post->featured_image) }}" alt="Blog preview" style="width:240px; border-radius:16px; margin:18px 0; display:block;">
    @endif
    
    <label>Content<textarea id="content" name="content">{{ old('content',$post->content) }}</textarea></label>
    <label>Meta Title<input name="meta_title" value="{{ old('meta_title',$post->meta_title) }}"></label>
    <label>Meta Description<textarea name="meta_description">{{ old('meta_description',$post->meta_description) }}</textarea></label>
    <label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published',$post->is_published))> Published</label>
    <button type="submit">Save Blog</button>
</form>

<!-- Quick Add Category Modal -->
<div id="quick-add-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 99999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: white; border-radius: 8px; width: 100%; max-width: 400px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); position: relative;">
        <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 1.25rem;">Quick Add Category</h3>
        
        <div id="quick-cat-error" style="display:none; color:red; margin-bottom:15px; font-size:0.9rem;"></div>
        
        <div style="margin-bottom: 20px;">
            <label style="display:block; font-weight:600; margin-bottom:8px; font-size:0.95rem;">Category Name</label>
            <input type="text" id="quick-cat-name" style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:4px; box-sizing:border-box;">
        </div>
        
        <div style="display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" id="quick-cat-cancel" style="padding:10px 20px; background:#f1f5f9; border:1px solid #cbd5e1; border-radius:4px; cursor:pointer;">Cancel</button>
            <button type="button" id="quick-cat-save" style="padding:10px 20px; background:var(--primary, #0c6b3f); color:white; border:none; border-radius:4px; cursor:pointer; display:flex; align-items:center; gap:5px;">
                <span>Save Category</span>
                <span id="quick-cat-spinner" style="display:none; border:2px solid rgba(255,255,255,0.3); border-top-color:white; border-radius:50%; width:12px; height:12px; animation:spin 0.6s linear infinite;"></span>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quickAddBtn = document.getElementById('quick-add-cat-btn');
    const modal = document.getElementById('quick-add-modal');
    const cancelBtn = document.getElementById('quick-cat-cancel');
    const saveBtn = document.getElementById('quick-cat-save');
    const nameInput = document.getElementById('quick-cat-name');
    const errorDiv = document.getElementById('quick-cat-error');
    const spinner = document.getElementById('quick-cat-spinner');
    const categorySelect = document.getElementById('blog_category_id');

    if (quickAddBtn && modal) {
        // Open modal
        quickAddBtn.addEventListener('click', function() {
            nameInput.value = '';
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';
            modal.style.display = 'flex';
            nameInput.focus();
        });

        // Close modal
        cancelBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Save via AJAX
        saveBtn.addEventListener('click', function() {
            const name = nameInput.value.trim();
            if (!name) {
                errorDiv.textContent = 'Please enter a category name.';
                errorDiv.style.display = 'block';
                return;
            }

            errorDiv.style.display = 'none';
            spinner.style.display = 'inline-block';
            saveBtn.disabled = true;

            fetch('{{ route("admin.blog-categories.quick-store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name: name })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                spinner.style.display = 'none';
                saveBtn.disabled = false;
                modal.style.display = 'none';

                if (data.success) {
                    // Create new option
                    const option = document.createElement('option');
                    option.value = data.id;
                    option.textContent = data.name;
                    option.selected = true;

                    // Append to select
                    categorySelect.appendChild(option);
                }
            })
            .catch(error => {
                spinner.style.display = 'none';
                saveBtn.disabled = false;
                
                let msg = 'An error occurred while saving the category.';
                if (error && error.errors && error.errors.name) {
                    msg = error.errors.name[0];
                } else if (error && error.message) {
                    msg = error.message;
                }
                
                errorDiv.textContent = msg;
                errorDiv.style.display = 'block';
            });
        });
    }
});
</script>
@endsection
