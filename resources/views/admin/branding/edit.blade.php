@extends('layouts.admin')
@section('content')
<h1>Branding Manager</h1>

<form class="panel form" method="post" enctype="multipart/form-data" action="{{ route('admin.branding.update') }}">
    @csrf
    @method('put')

    <h2>Branding Settings</h2>
    <label>Site Name
        <input name="site_name" value="{{ old('site_name', $settings->site_name) }}" required>
    </label>
    <label>Tagline
        <input name="tagline" value="{{ old('tagline', $settings->tagline) }}" required>
    </label>
    <label>Primary Color (Hex)
        <input name="primary_color" value="{{ old('primary_color', $settings->primary_color) }}" placeholder="#0c6b3f" required>
    </label>
    <label>Secondary Color (Hex)
        <input name="secondary_color" value="{{ old('secondary_color', $settings->secondary_color) }}" placeholder="#71c55d" required>
    </label>
    
    <label>Logo
        <input type="file" name="logo" accept="image/*">
    </label>
    @if(!empty($settings->logo))
        <div class="logo-preview" style="margin-bottom: 20px;">
            <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo Preview" style="max-height: 50px; background: #eee; padding: 5px; border-radius: 4px;">
        </div>
    @endif

    <label>Favicon
        <input type="file" name="favicon" accept="image/*">
    </label>
    @if(!empty($settings->favicon))
        <div class="logo-preview" style="margin-bottom: 20px;">
            <img src="{{ asset('storage/' . $settings->favicon) }}" alt="Favicon Preview" style="max-height: 32px;">
        </div>
    @endif

    <h2>Social Links</h2>
    <label>Facebook URL
        <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}">
    </label>
    <label>Twitter URL
        <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings->twitter_url) }}">
    </label>
    <label>LinkedIn URL
        <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings->linkedin_url) }}">
    </label>
    <label>Instagram URL
        <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}">
    </label>

    <button>Save Branding</button>
</form>
@endsection
