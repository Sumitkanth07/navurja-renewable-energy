@extends('layouts.admin')

@section('content')

<h1>Branding & Footer</h1>

<form class="panel form" method="post" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}">
    @csrf
    @method('put')

    <h2>Branding</h2>

    <label>Site name
        <input name="site_name" value="{{ old('site_name', $settings->site_name) }}">
    </label>

    <label>Tagline
        <input name="tagline" value="{{ old('tagline', $settings->tagline) }}">
    </label>

    <label>Primary color
        <input name="primary_color" value="{{ old('primary_color', $settings->primary_color) }}">
    </label>

    <label>Secondary color
        <input name="secondary_color" value="{{ old('secondary_color', $settings->secondary_color) }}">
    </label>

    <label>Logo
        <input type="file" name="logo" accept="image/*">
    </label>

    @if(!empty($settings->logo))
        <div class="logo-preview" style="margin-bottom: 20px;">
            <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo Preview" style="max-height: 50px; width: auto; border-radius: 4px;">
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

    <h2>Social Media Links</h2>
    <label>Facebook URL<input type="url" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url ?? '') }}"></label>
    <label>Twitter URL<input type="url" name="twitter_url" value="{{ old('twitter_url', $settings->twitter_url ?? '') }}"></label>
    <label>LinkedIn URL<input type="url" name="linkedin_url" value="{{ old('linkedin_url', $settings->linkedin_url ?? '') }}"></label>
    <label>Instagram URL<input type="url" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url ?? '') }}"></label>

    <h2>Footer</h2>
    <label>Company name<input name="company_name" value="{{ old('company_name', $footer->company_name ?? 'Navurja') }}"></label>
    <label>Email<input name="email" value="{{ old('email', $footer->email ?? 'info@navurja.com') }}"></label>
    <label>Phone<input name="phone" value="{{ old('phone', $footer->phone ?? '+91 9876543210') }}"></label>
    <label>Address<textarea name="address">{{ old('address', $footer->address ?? 'New Delhi, India') }}</textarea></label>
    <label>Copyright<input name="copyright_text" value="{{ old('copyright_text', $footer->copyright_text ?? 'Copyright '.date('Y').' Navurja. All rights reserved.') }}"></label>
    
    <h2>Cookie Consent</h2>
    <label class="check"><input type="checkbox" name="cookie_consent_enabled" value="1" {{ old('cookie_consent_enabled', $settings->cookie_consent_enabled ?? '0') === '1' ? 'checked' : '' }}> Enable Cookie Consent Banner</label>
    <label>Popup Title<input name="cookie_popup_title" value="{{ old('cookie_popup_title', $settings->cookie_popup_title ?? 'We Value Your Privacy') }}"></label>
    <label>Popup Content<textarea name="cookie_popup_content">{{ old('cookie_popup_content', $settings->cookie_popup_content ?? 'This website uses cookies to ensure you get the best experience.') }}</textarea></label>
    <label>Accept Button Text<input name="cookie_accept_text" value="{{ old('cookie_accept_text', $settings->cookie_accept_text ?? 'Accept') }}"></label>
    <label>Reject Button Text<input name="cookie_reject_text" value="{{ old('cookie_reject_text', $settings->cookie_reject_text ?? 'Decline') }}"></label>
    <label>Cookie Expiry Duration (Days)<input type="number" name="cookie_consent_expiry" value="{{ old('cookie_consent_expiry', $settings->cookie_consent_expiry ?? '30') }}" min="1"></label>

    <button>Save Settings</button>
</form>

@endsection