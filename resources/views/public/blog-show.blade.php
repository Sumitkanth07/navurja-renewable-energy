@extends('layouts.site')

@section('title', $post->meta_title ?: $post->title)

@section('description', $post->meta_description)

@section('content')

<main class="article">

    <a href="{{ route('blog.index') }}">

        ← Back to blog

    </a>

    <h1>

        {{ $post->title }}

    </h1>

    <p class="muted">

        {{ optional($post->category)->name }}

        ·

        {{ optional($post->published_at)->format('M d, Y') }}

    </p>

    @if($post->featured_image)

        <img
            class="article-image"
            src="{{ asset('storage/app/public/' . $post->featured_image) }}"
            alt="{{ $post->title }}"
        >

    @endif

    <div class="rich">

        {!! $post->content !!}

    </div>

</main>

@endsection