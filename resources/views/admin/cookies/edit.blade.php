@extends('layouts.admin')
@section('content')
<h1>Cookie Settings</h1>

<form class="panel form" method="post" action="{{ route('admin.cookie-settings.update') }}">
    @csrf
    @method('put')

    <h2>Cookie Consent Configuration</h2>
    <label class="check">
        <input type="checkbox" name="cookie_consent_enabled" value="1" {{ old('cookie_consent_enabled', $settings->cookie_consent_enabled) === '1' ? 'checked' : '' }}> Enable Cookie Consent Banner
    </label>
    
    <label>Popup Title
        <input name="cookie_popup_title" value="{{ old('cookie_popup_title', $settings->cookie_popup_title) }}">
    </label>
    
    <label>Popup Content / Description
        <textarea name="cookie_popup_content" style="height: 100px;">{{ old('cookie_popup_content', $settings->cookie_popup_content) }}</textarea>
    </label>
    
    <label>Accept Button Text
        <input name="cookie_accept_text" value="{{ old('cookie_accept_text', $settings->cookie_accept_text) }}">
    </label>
    
    <label>Reject Button Text
        <input name="cookie_reject_text" value="{{ old('cookie_reject_text', $settings->cookie_reject_text) }}">
    </label>

    <label>Cookie Expiry Duration (Days)
        <input type="number" name="cookie_consent_expiry" value="{{ old('cookie_consent_expiry', $settings->cookie_consent_expiry) }}" min="1">
    </label>

    <button>Save Cookie Settings</button>
</form>
@endsection
