@extends('layouts.admin')
@section('content')
<div class="topbar">
    <h1>Create Page</h1>
    <a href="{{ route('admin.pages.index') }}">Back to Pages</a>
</div>
<form method="POST" action="{{ route('admin.pages.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.pages.form')
    <button type="submit" class="button">Save Page</button>
</form>
@endsection
