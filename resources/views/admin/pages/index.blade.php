@extends('layouts.admin')
@section('content')
<div class="topbar">
    <h1>CMS Pages</h1>
    <a class="button" href="{{ route('admin.pages.create') }}">Create Page</a>
</div>

<div style="margin-bottom: 20px;">
    <form method="GET" action="{{ route('admin.pages.index') }}" style="display: flex; gap: 10px; align-items: center;">
        <input type="text" name="search" placeholder="Search title or slug..." value="{{ request('search') }}">
        <select name="status">
            <option value="">All Status</option>
            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Published</option>
            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draft</option>
        </select>
        <button type="submit" class="button">Filter</button>
        <a href="{{ route('admin.pages.index') }}" class="button" style="background: #ccc; color: #333;">Clear</a>
    </form>
</div>

<form method="POST" action="{{ route('admin.pages.bulk-action') }}">
    @csrf
    <div style="margin-bottom: 10px;">
        <select name="action" required>
            <option value="">-- Bulk Actions --</option>
            <option value="publish">Publish Selected</option>
            <option value="unpublish">Unpublish Selected</option>
            <option value="delete">Delete Selected</option>
        </select>
        <button type="submit" onclick="return confirm('Are you sure?')">Apply</button>
    </div>

    <table>
        <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <th>Title</th>
            <th>Slug</th>
            <th>Status</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Actions</th>
        </tr>
        @foreach($pages as $page)
        <tr>
            <td><input type="checkbox" name="ids[]" value="{{ $page->id }}" class="page-checkbox"></td>
            <td>{{ $page->title }}</td>
            <td>/{{ $page->slug }}</td>
            <td>{{ $page->is_published ? 'Published' : 'Draft' }}</td>
            <td>{{ $page->created_at->format('Y-m-d') }}</td>
            <td>{{ $page->updated_at->format('Y-m-d') }}</td>
            <td>
                <a href="{{ route('admin.pages.edit', $page) }}">Edit</a> |
                <a href="{{ route('page.show', $page->slug) }}" target="_blank">View</a>
            </td>
        </tr>
        @endforeach
    </table>
</form>

{{ $pages->appends(request()->query())->links() }}

<script>
    document.getElementById('selectAll').addEventListener('change', function(e) {
        let checkboxes = document.querySelectorAll('.page-checkbox');
        checkboxes.forEach(cb => cb.checked = e.target.checked);
    });
</script>
@endsection
