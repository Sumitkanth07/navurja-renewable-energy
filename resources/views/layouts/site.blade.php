@php
use App\Models\Setting; use App\Models\NavigationItem; use App\Models\FooterSetting;
$siteName = Setting::getValue('site_name', 'Navurja');
$tagline = Setting::getValue('tagline', 'Renewable Energy Solutions');
$logo = Setting::getValue('logo');
$footer = FooterSetting::first();
$navItems = NavigationItem::where('is_active', true)->orderBy('sort_order')->get();
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $siteName.' - Powering a Sustainable Tomorrow')</title>
    <meta name="description" content="@yield('description', 'Premium renewable energy solutions for modern homes and businesses.')">
    <meta property="og:title" content="@yield('title', $siteName)">
    <meta property="og:description" content="@yield('description', 'Powering a Sustainable Tomorrow')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body style="--primary: {{ Setting::getValue('primary_color', '#0c6b3f') }}; --secondary: {{ Setting::getValue('secondary_color', '#71c55d') }}">
<header class="site-header">
    <a class="brand navbar-brand" href="{{ route('home') }}">
        @if($logo)
            <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteName }} logo">
        @else
            <span class="brand-mark">N</span>
        @endif
        <div class="brand-text">
            <span class="brand-title">Navurja</span>
            <span class="brand-subtitle">Renewable Energy Solutions</span>
        </div>
    </a>
    <div class="header-actions">
        <button class="theme-toggle" type="button" aria-label="Toggle dark mode" aria-pressed="false">Dark</button>
        <button class="menu-toggle" type="button" aria-label="Open menu">Menu</button>
        <nav class="site-nav">
            @foreach($navItems as $item)
                <a href="{{ str_starts_with($item->url, '#') ? route('home').$item->url : url($item->url) }}">{{ $item->label }}</a>
            @endforeach
        </nav>
    </div>
</header>
@if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
@yield('content')
<footer class="footer">
    <div>
        <h3>{{ $footer->company_name ?? 'Navurja' }}</h3>
        <p>{{ $footer->address ?? 'New Delhi, India' }}</p>
    </div>
    <div class="footer-links">
        @foreach($navItems as $item)<a href="{{ str_starts_with($item->url, '#') ? route('home').$item->url : url($item->url) }}">{{ $item->label }}</a>@endforeach
    </div>
    <div>
        <a href="mailto:{{ $footer->email ?? 'info@navurja.com' }}">{{ $footer->email ?? 'info@navurja.com' }}</a>
        <a href="tel:{{ $footer->phone ?? '+919876543210' }}">{{ $footer->phone ?? '+91 9876543210' }}</a>
        <p>{{ $footer->copyright_text ?? 'Copyright '.date('Y').' Navurja. All rights reserved.' }}</p>
    </div>
</footer>
<script src="{{ asset('js/site.js') }}"></script>
</body>
</html>
