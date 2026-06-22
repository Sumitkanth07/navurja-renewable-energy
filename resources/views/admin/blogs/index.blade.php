@extends('layouts.admin')

@section('content')

<div class="topbar">

    <h1>
        Blogs
    </h1>

    <a
        class="button"
        href="{{ route('admin.blogs.create') }}"
    >
        Add Blog
    </a>

</div>

<table>

    <tr>

        <th>
            Image
        </th>

        <th>
            Title
        </th>

        <th>
            Category
        </th>

        <th>
            Status
        </th>

        <th>
            Action
        </th>

    </tr>

    @foreach($posts as $post)

        <tr>

            <td>

                @if($post->featured_image)

                    <img
                        src="{{ asset('storage/' . $post->featured_image) }}"
                        alt="{{ $post->title }}"
                        style="
                            width:90px;
                            height:70px;
                            object-fit:cover;
                            border-radius:12px;
                        "
                    >

                @endif

            </td>

            <td>

                {{ $post->title }}

            </td>

            <td>

                {{ optional($post->category)->name }}

            </td>

            <td>

                {{ $post->is_published ? 'Published' : 'Draft' }}

            </td>

            <td
                style="
                    display:flex;
                    gap:12px;
                    align-items:center;
                "
            >

                <a href="{{ route('admin.blogs.edit', $post) }}">

                    Edit

                </a>

                <form
                    method="post"
                    action="{{ route('admin.blogs.destroy', $post) }}"
                >

                    @csrf

                    @method('delete')

                    <button>

                        Delete

                    </button>

                </form>

            </td>

        </tr>

    @endforeach

</table>

{{ $posts->links() }}

@endsection
