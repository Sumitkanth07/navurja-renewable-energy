@extends('layouts.admin')
@section('content')
<h1>Location Manager</h1>

<form class="panel form" method="post" action="{{ route('admin.location.update') }}">
    @csrf
    @method('put')

    <h2>Office & Location Details</h2>
    
    <label>Office Name
        <input name="office_name" value="{{ old('office_name', $location->office_name) }}" required>
    </label>
    
    <label>Address
        <input name="address" value="{{ old('address', $location->address) }}" required>
    </label>

    <label>City
        <input name="city" value="{{ old('city', $location->city) }}">
    </label>

    <label>State
        <input name="state" value="{{ old('state', $location->state) }}">
    </label>

    <label>Country
        <input name="country" value="{{ old('country', $location->country) }}">
    </label>

    <label>Pincode / ZIP Code
        <input name="pincode" value="{{ old('pincode', $location->pincode) }}">
    </label>

    <h2>Contact Information</h2>
    
    <label>Primary Phone Number
        <input name="phone" value="{{ old('phone', $location->phone) }}">
    </label>

    <label>Alternate Phone Number
        <input name="alt_phone" value="{{ old('alt_phone', $location->alt_phone) }}">
    </label>

    <label>Email Address
        <input type="email" name="email" value="{{ old('email', $location->email) }}">
    </label>

    <h2>Google Maps & Working Hours</h2>

    <label>Google Maps Embed URL or Share Link
        <textarea name="map_url" style="height: 80px;" placeholder="https://www.google.com/maps/embed?... or Google Maps Share URL">{{ old('map_url', $location->map_url) }}</textarea>
        <small style="color: #64748b; margin-top: 5px; display: block;">Paste either the full Google Maps Share Link, or the src attribute of the Embedded Iframe.</small>
    </label>

    @if(!empty($location->map_url))
        <div class="map-preview" style="margin-bottom: 20px;">
            <label>Current Map Preview</label>
            @if(str_contains($location->map_url, '<iframe'))
                <div style="border-radius: 8px; overflow: hidden; max-height: 250px;">
                    {!! $location->map_url !!}
                </div>
            @else
                <iframe src="{{ $location->map_url }}" width="100%" height="200" style="border:0; border-radius: 8px;" allowfullscreen="" loading="lazy"></iframe>
            @endif
        </div>
    @endif

    <label>Latitude
        <input name="latitude" value="{{ old('latitude', $location->latitude) }}" placeholder="e.g. 28.6256">
    </label>

    <label>Longitude
        <input name="longitude" value="{{ old('longitude', $location->longitude) }}" placeholder="e.g. 77.2183">
    </label>

    <label>Working Hours
        <input name="working_hours" value="{{ old('working_hours', $location->working_hours) }}" placeholder="e.g. Mon - Sat: 9:00 AM - 6:00 PM">
    </label>

    <button>Save Location</button>
</form>
@endsection
