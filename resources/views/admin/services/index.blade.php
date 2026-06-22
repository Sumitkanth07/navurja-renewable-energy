@extends('layouts.admin')

@section('content')

<h1>Services</h1>

<a
    href="{{ route('admin.services.create') }}"
    style="display:inline-block; margin-bottom:30px;"
>
    Add Service
</a>

<div class="panel">

    @foreach($services as $service)

        <div style="margin-bottom:40px;">

            @if($service->image)

                <img
                    src="{{ asset('storage/' . $service->image) }}"
                    style="width:220px; border-radius:16px; margin-bottom:15px;"
                >

            @endif

            <h2>{{ $service->title }}</h2>

            <p>{{ $service->excerpt }}</p>

            <div style="display:flex; gap:10px; margin-top:15px;">

                <a href="{{ route('admin.services.edit', $service) }}">
                    Edit
                </a>

                <form
                    method="post"
                    action="{{ route('admin.services.destroy', $service) }}"
                >

                    @csrf
                    @method('delete')

                    <button>
                        Delete
                    </button>

                </form>

            </div>

        </div>

    @endforeach

</div>

@endsection
