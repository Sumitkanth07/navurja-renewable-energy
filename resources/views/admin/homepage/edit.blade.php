@extends('layouts.admin')

@section('content')

<h1>Homepage Manager</h1>

<form
    class="panel form"
    method="post"
    enctype="multipart/form-data"
    action="{{ route('admin.homepage.update') }}"
>

    @csrf
    @method('put')

    @foreach([

        'hero' => 'Hero Section',

        'about' => 'About Section',

        'services' => 'Services Section',

        'why' => 'Why Choose Us',

        'contact' => 'Contact Section'

    ] as $key => $label)

        @php($s = $sections[$key] ?? null)

        <h2>{{ $label }}</h2>

        <label>

            Title

            <input
                name="{{ $key }}[title]"
                value="{{ old($key.'.title', $s->title ?? '') }}"
            >

        </label>

        <label>

            Subtitle

            <textarea
                name="{{ $key }}[subtitle]"
            >{{ old($key.'.subtitle', $s->subtitle ?? '') }}</textarea>

        </label>

        <label>

            Content

            <textarea
                name="{{ $key }}[content]"
            >{{ old($key.'.content', $s->content ?? '') }}</textarea>

        </label>

        @if($key === 'hero')

            @php($heroPreview = $s->hero_image ?? $s->image ?? null)

            <label>

                Hero Image

                <input
                    type="file"
                    name="hero[hero_image]"
                    accept="image/*"
                >

            </label>

            @if($heroPreview)

                <img
                    class="preview"
                    src="{{ asset('storage/app/public/' . $heroPreview) }}"
                    alt="Hero preview"
                    style="
                        width:220px;
                        border-radius:16px;
                        margin-top:15px;
                    "
                >

            @else

                <img
                    class="preview"
                    src="{{ asset('images/hero-placeholder.svg') }}"
                    alt="Fallback preview"
                    style="
                        width:220px;
                        border-radius:16px;
                        margin-top:15px;
                    "
                >

            @endif

        @else

            <label>

                Image

                <input
                    type="file"
                    name="{{ $key }}[image]"
                    accept="image/*"
                >

            </label>

            @if($s?->image)

                <img
                    class="preview"
                    src="{{ asset('storage/app/public/' . $s->image) }}"
                    alt="{{ $label }} preview"
                    style="
                        width:220px;
                        border-radius:16px;
                        margin-top:15px;
                    "
                >

            @endif

        @endif

        <hr style="margin:50px 0; opacity:0.2;">

    @endforeach

    <button type="submit">

        Save Homepage

    </button>

</form>

@endsection