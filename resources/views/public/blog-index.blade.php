@extends('layouts.site')
@section('title','Renewable Energy Blog - Navurja')
@section('content')
<main class="page"><span class="eyebrow">Blog</span><h1>Renewable Energy Insights</h1><div class="grid three">@foreach($posts as $post)<a class="project-card" href="{{ route('blog.show',$post->slug) }}">@if($post->featured_image)<img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->title }}">@endif<h3>{{ $post->title }}</h3><p>{{ $post->meta_description }}</p></a>@endforeach</div>{{ $posts->links() }}</main>
@endsection
