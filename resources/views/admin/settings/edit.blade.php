@extends('layouts.admin')
@section('content')
<h1>Branding & Footer</h1>
<form class="panel form" method="post" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}">
    @csrf
    @method('put')

    <h2>Branding</h2>
    <label>Site name<input name="site_name" value="{{ old('site_name', $settings->site_name) }}"></label>
    <label>Tagline<input name="tagline" value="{{ old('tagline', $settings->tagline) }}"></label>
    <label>Primary color<input name="primary_color" value="{{ old('primary_color', $settings->primary_color) }}"></label>
    <label>Secondary color<input name="secondary_color" value="{{ old('secondary_color', $settings->secondary_color) }}"></label>
    <label>Logo<input type="file" name="logo" accept="image/*"></label>

    @if(!empty($settings->logo))
        <div class="logo-preview">
            <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo Preview">
        </div>
    @endif

    <h2>Footer</h2>
    <label>Company name<input name="company_name" value="{{ old('company_name', $footer->company_name ?? 'Navurja') }}"></label>
    <label>Email<input name="email" value="{{ old('email', $footer->email ?? 'info@navurja.com') }}"></label>
    <label>Phone<input name="phone" value="{{ old('phone', $footer->phone ?? '+91 9876543210') }}"></label>
    <label>Address<textarea name="address">{{ old('address', $footer->address ?? 'New Delhi, India') }}</textarea></label>
    <label>Copyright<input name="copyright_text" value="{{ old('copyright_text', $footer->copyright_text ?? 'Copyright '.date('Y').' Navurja. All rights reserved.') }}"></label>
    <button>Save Settings</button>
</form>
@endsection
