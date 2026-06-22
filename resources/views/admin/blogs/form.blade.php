@extends('layouts.admin')

@section('content')

<h1>

    {{ $post->exists ? 'Edit Blog' : 'Add Blog' }}

</h1>

<form
    class="panel form"
    method="post"
    enctype="multipart/form-data"
    action="{{ $post->exists
        ? route('admin.blogs.update', $post)
        : route('admin.blogs.store') }}"
>

    @csrf

    @if($post->exists)

        @method('put')

    @endif

    <label>

        Title

        <input
            name="title"
            value="{{ old('title', $post->title) }}"
            required
        >

    </label>

    <label>

        Slug

        <input
            name="slug"
            value="{{ old('slug', $post->slug) }}"
        >

    </label>

    <label>

        Category

        <select name="blog_category_id">

            <option value="">
                Select
            </option>

            @foreach($categories as $cat)

                <option
                    value="{{ $cat->id }}"
                    @selected(old('blog_category_id', $post->blog_category_id) == $cat->id)
                >

                    {{ $cat->name }}

                </option>

            @endforeach

        </select>

    </label>

    <label>

        Featured Image

        <input
            type="file"
            name="featured_image"
            accept="image/*"
        >

    </label>

    @if($post->featured_image)

        <img
            class="preview"
            src="{{ asset('storage/' . $post->featured_image) }}"
            alt="Blog preview"
            style="
                width:240px;
                border-radius:16px;
                margin:18px 0;
            "
        >

    @endif

    <label>

        Content

        <textarea
            id="content"
            name="content"
        >{{ old('content', $post->content) }}</textarea>

    </label>

    <label>

        Meta Title

        <input
            name="meta_title"
            value="{{ old('meta_title', $post->meta_title) }}"
        >

    </label>

    <label>

        Meta Description

        <textarea
            name="meta_description"
        >{{ old('meta_description', $post->meta_description) }}</textarea>

    </label>

    <label class="check">

        <input
            type="checkbox"
            name="is_published"
            value="1"
            @checked(old('is_published', $post->is_published))
        >

        Published

    </label>

    <button type="submit">

        Save Blog

    </button>

</form>

@endsection
