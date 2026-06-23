@extends('layouts.site')
@section('title', $page->meta_title ?? $page->title)
@section('meta_description', $page->meta_description)
@section('meta_keywords', $page->meta_keywords)
@if($page->canonical_url)
@section('canonical', $page->canonical_url)
@endif
@if(!$page->is_index)
@section('robots', 'noindex, nofollow')
@endif
@section('og_title', $page->og_title ?? $page->meta_title ?? $page->title)
@section('og_description', $page->og_description ?? $page->meta_description)
@if($page->og_image)
@section('og_image', asset('storage/' . $page->og_image))
@elseif($page->featured_image)
@section('og_image', asset('storage/' . $page->featured_image))
@endif

@section('content')
<div class="page-container" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
    <h1>{{ $page->title }}</h1>
    
    @if($page->featured_image)
        <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}" style="max-width: 100%; height: auto; margin-bottom: 30px;">
    @endif
    
    <div class="page-content">
        {!! $page->content !!}
    </div>
</div>
@endsection
