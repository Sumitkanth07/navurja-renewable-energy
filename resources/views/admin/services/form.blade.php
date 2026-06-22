@extends('layouts.admin')

@section('content')

<h1>
    {{ $service->exists ? 'Edit Service' : 'Add Service' }}
</h1>

<form
    class="panel form"
    method="post"
    enctype="multipart/form-data"
    action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}"
>

    @csrf

    @if($service->exists)
        @method('put')
    @endif

    <label>

        Title

        <input
            name="title"
            value="{{ old('title', $service->title) }}"
            required
        >

    </label>

    <label>

        Description

        <textarea
            name="description"
            required
            >{{ old('description', $service->description) }}</textarea>

    </label>

    <label>

        Image

        <input
            type="file"
            name="image"
            accept="image/*"
        >

        @if($service->image)

            <img
                src="{{ asset('storage/' . $service->image) }}"
                style="width:220px; border-radius:16px; margin-top:15px;"
            >

        @endif

    </label>

    <button>
        Save Service
    </button>

</form>

@endsection
