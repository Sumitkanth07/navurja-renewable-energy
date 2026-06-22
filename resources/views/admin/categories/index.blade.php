@extends('layouts.admin')
@section('content')
<div class="topbar">
    <h1>Blog Categories</h1>
    <div style="display: flex; gap: 15px; align-items: center;">
        <form method="get" action="{{ route('admin.blog-categories.index') }}" style="display: flex; gap: 5px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..." style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
            <button class="button" style="padding: 8px 16px;">Search</button>
        </form>
        <a class="button" href="{{ route('admin.blog-categories.create') }}">Add Category</a>
    </div>
</div>

<table>
    <tr>
        <th>Name</th>
        <th>Slug</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    @forelse($categories as $category)
    <tr>
        <td>{{ $category->name }}</td>
        <td>{{ $category->slug }}</td>
        <td>{{ $category->is_active ? 'Active' : 'Disabled' }}</td>
        <td>
            <a href="{{ route('admin.blog-categories.edit', $category) }}">Edit</a>
            <form method="post" action="{{ route('admin.blog-categories.destroy', $category) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category? All posts inside it will have their category set to uncategorized.');">
                @csrf
                @method('delete')
                <button style="background:none; border:none; color:red; cursor:pointer; text-decoration:underline; padding:0;">Delete</button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="4" style="text-align: center; color: #777; padding: 20px;">No categories found.</td>
    </tr>
    @endforelse
</table>

{{ $categories->appends(request()->query())->links() }}
@endsection
