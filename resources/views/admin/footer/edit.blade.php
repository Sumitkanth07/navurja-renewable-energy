@extends('layouts.admin')
@section('content')
<h1>Footer Manager</h1>

<form class="panel form" method="post" action="{{ route('admin.footer.update') }}">
    @csrf
    @method('put')

    <h2>Footer Content Settings</h2>
    <label>Company Name
        <input name="company_name" value="{{ old('company_name', $footer->company_name) }}" required>
    </label>
    
    <label>Copyright Text
        <input name="copyright_text" value="{{ old('copyright_text', $footer->copyright_text) }}" required>
    </label>

    <button>Save Footer Settings</button>
</form>
@endsection
