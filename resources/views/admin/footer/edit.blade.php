@extends('layouts.admin')
@section('content')
<h1>Footer Manager</h1>

<form class="panel form" method="post" enctype="multipart/form-data" action="{{ route('admin.footer.update') }}">
    @csrf
    @method('put')

    <h2>Business & Footer Info</h2>
    <label>Company Name
        <input name="company_name" value="{{ old('company_name', $footer->company_name) }}" required>
    </label>

    <label>Footer Description
        <textarea name="footer_description" style="height: 100px;">{{ old('footer_description', $footer->footer_description) }}</textarea>
    </label>

    <label>Footer Logo
        <input type="file" name="footer_logo_file" accept="image/*">
    </label>
    @if(!empty($footer->footer_logo))
        <div class="logo-preview" style="margin-bottom: 20px;">
            <img src="{{ asset('storage/' . $footer->footer_logo) }}" alt="Footer Logo Preview" style="max-height: 50px; background: #eee; padding: 5px; border-radius: 4px;">
        </div>
    @endif

    <label>Copyright Text
        <input name="copyright_text" value="{{ old('copyright_text', $footer->copyright_text) }}" required>
    </label>

    <h2>Contact Information</h2>
    <label>Phone Number
        <input name="phone" value="{{ old('phone', $footer->phone) }}">
    </label>

    <label>Alternate Phone Number (Optional)
        <input name="alternate_phone" value="{{ old('alternate_phone', $footer->alternate_phone) }}">
    </label>

    <label>Email Address
        <input type="email" name="email" value="{{ old('email', $footer->email) }}">
    </label>

    <label>Office Address
        <textarea name="address" style="height: 80px;">{{ old('address', $footer->address) }}</textarea>
    </label>

    <label>Google Map URL (View on Google Maps Link)
        <input type="url" name="map_url" value="{{ old('map_url', $footer->map_url) }}">
    </label>

    <h2>WhatsApp Chat & Floating Button</h2>
    <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <input type="checkbox" name="whatsapp_enabled" id="whatsapp_enabled" value="1" {{ old('whatsapp_enabled', $footer->whatsapp_enabled) ? 'checked' : '' }}>
        <label for="whatsapp_enabled" style="margin-bottom: 0; cursor: pointer; font-weight: 500;">Enable WhatsApp Floating Button</label>
    </div>

    <label>WhatsApp Number (With Country Code, e.g. 919876543210)
        <input name="whatsapp_number" value="{{ old('whatsapp_number', $footer->whatsapp_number) }}">
    </label>

    <label>WhatsApp Default Message (Pre-filled message when clicked)
        <textarea name="whatsapp_message" style="height: 60px;">{{ old('whatsapp_message', $footer->whatsapp_message) }}</textarea>
    </label>

    <h2>Social Network Links</h2>
    <label>Facebook URL
        <input type="url" name="facebook_url" value="{{ old('facebook_url', $footer->facebook_url) }}">
    </label>

    <label>Instagram URL
        <input type="url" name="instagram_url" value="{{ old('instagram_url', $footer->instagram_url) }}">
    </label>

    <label>LinkedIn URL
        <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $footer->linkedin_url) }}">
    </label>

    <label>YouTube URL
        <input type="url" name="youtube_url" value="{{ old('youtube_url', $footer->youtube_url) }}">
    </label>

    <label>Twitter/X URL
        <input type="url" name="twitter_url" value="{{ old('twitter_url', $footer->twitter_url) }}">
    </label>

    <button style="margin-top: 15px;">Save Footer Settings</button>
</form>
@endsection
