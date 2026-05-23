@extends('layouts.admin')
@section('content')
<h1>Homepage Manager</h1>
<form class="panel form" method="post" enctype="multipart/form-data" action="{{ route('admin.homepage.update') }}">
    @csrf
    @method('put')

    @foreach(['hero' => 'Hero Section', 'about' => 'About Section', 'why' => 'Why Choose Us'] as $key => $label)
        @php($s = $sections[$key] ?? null)
        <h2>{{ $label }}</h2>
        <label>Title<input name="{{ $key }}[title]" value="{{ old($key.'.title', $s->title ?? '') }}"></label>
        <label>Subtitle<textarea name="{{ $key }}[subtitle]">{{ old($key.'.subtitle', $s->subtitle ?? '') }}</textarea></label>
        <label>Content<textarea name="{{ $key }}[content]">{{ old($key.'.content', $s->content ?? '') }}</textarea></label>

        @if($key === 'hero')
            @php($heroPreview = $s->hero_image ?? $s->image ?? null)
            <label>Hero image<input type="file" name="hero[hero_image]" accept="image/*"></label>
            @if($heroPreview)
                <img class="preview" src="{{ asset('storage/' . $heroPreview) }}" alt="Current hero image preview">
            @else
                <img class="preview" src="{{ asset('images/hero-placeholder.svg') }}" alt="Fallback hero image preview">
            @endif
        @else
            <label>Image<input type="file" name="{{ $key }}[image]" accept="image/*"></label>
            @if($s?->image)
                <img class="preview" src="{{ asset('storage/' . $s->image) }}" alt="{{ $label }} image preview">
            @endif
        @endif
    @endforeach

    <button>Save Homepage</button>
</form>
@endsection
