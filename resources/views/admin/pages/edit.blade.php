@extends('layouts.admin')
@section('content')
<div class="topbar">
    <h1>Edit Page: {{ $page->title }}</h1>
    <a href="{{ route('admin.pages.index') }}">Back to Pages</a>
</div>
<form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.pages.form')
    <button type="submit" class="button">Update Page</button>
</form>
@endsection
