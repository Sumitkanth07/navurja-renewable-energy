@php
use App\Models\Setting;
use App\Models\NavigationItem;
use App\Models\FooterSetting;

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

    <title>@yield('title', $siteName . ' - Powering a Sustainable Tomorrow')</title>

    <meta name="description" content="@yield('description', 'Premium renewable energy solutions for modern homes and businesses.')">

    <meta property="og:title" content="@yield('title', $siteName)">
    <meta property="og:description" content="@yield('description', 'Powering a Sustainable Tomorrow')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    @if($logo)
        <link rel="icon" type="image/png" href="{{ asset('storage/app/public/' . $logo) }}">
    @endif

    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <style>

.calculator-page{
    min-height:100vh !important;
    padding:80px clamp(20px,6vw,90px) !important;
}

.calc-shell{
    display:grid !important;
    grid-template-columns:1.1fr .9fr !important;
    gap:32px !important;
    align-items:start !important;
}

.calc-panel{
    padding:42px !important;
    border-radius:30px !important;
    background:#0b1711 !important;
    border:1px solid rgba(255,255,255,.06) !important;
    box-shadow:0 30px 80px rgba(0,0,0,.3) !important;
}

.calc-panel h2{
    color:#fff !important;
    font-size:42px !important;
    margin-bottom:35px !important;
}

.calc-form{
    display:grid !important;
    grid-template-columns:1fr 1fr !important;
    gap:24px !important;
}

.calc-form label{
    display:flex !important;
    flex-direction:column !important;
    gap:12px !important;
    color:#fff !important;
    font-size:15px !important;
    font-weight:700 !important;
}

.calc-form input,
.calc-form select{
    width:100% !important;
    padding:18px 20px !important;
    border-radius:18px !important;
    border:1px solid rgba(255,255,255,.08) !important;
    background:rgba(255,255,255,.04) !important;
    color:#fff !important;
    font-size:16px !important;
}

.results{
    display:grid !important;
    gap:20px !important;
}

.result-card{
    padding:30px !important;
    border-radius:24px !important;
    background:#102018 !important;
    border:1px solid rgba(255,255,255,.05) !important;
}

.result-card strong{
    display:block !important;
    font-size:52px !important;
    color:#fff !important;
}

.result-card.featured{
    background:linear-gradient(
        135deg,
        var(--primary),
        var(--secondary)
    ) !important;
}

@media(max-width:900px){

    .calc-shell{
        grid-template-columns:1fr !important;
    }

    .calc-form{
        grid-template-columns:1fr !important;
    }

}

</style>
</head>

<body style="--primary: {{ Setting::getValue('primary_color', '#0c6b3f') }}; --secondary: {{ Setting::getValue('secondary_color', '#71c55d') }}">

<header class="site-header">
    <a class="brand navbar-brand" href="{{ route('home') }}">
        @if($logo)
            <img src="{{ asset('storage/app/public/' . $logo) }}" alt="{{ $siteName }} logo">
        @else
            <span class="brand-mark">N</span>
        @endif

        <div class="brand-text">
            <span class="brand-title">Navurja</span>
            <span class="brand-subtitle">Renewable Energy Solutions</span>
        </div>
    </a>

    <div class="header-actions">
        <button class="theme-toggle" type="button" aria-label="Toggle dark mode" aria-pressed="false">
            Dark
        </button>

        <button class="menu-toggle" type="button" aria-label="Open menu">
            Menu
        </button>

        <nav class="site-nav">
            @foreach($navItems as $item)
                <a href="{{ str_starts_with($item->url, '#') ? route('home') . $item->url : url($item->url) }}">
                    {{ $item->label }}
                </a>
            @endforeach
        </nav>
    </div>
</header>

@if(session('success'))
    <div class="flash">
        {{ session('success') }}
    </div>
@endif

@yield('content')

<footer class="footer">

    <div>

        <h3>
            {{ $footer->company_name ?? 'Navurja' }}
        </h3>

        <p>
            {{ $footer->address ?? 'New Delhi, India' }}
        </p>

        <div
            style="
                display:flex;
                gap:14px;
                margin-top:20px;
                flex-wrap:wrap;
            "
        >

            @if(!empty($footer->facebook))

                <a
                    href="{{ $footer->facebook }}"
                    target="_blank"
                >
                    Facebook
                </a>

            @endif

            @if(!empty($footer->instagram))

                <a
                    href="{{ $footer->instagram }}"
                    target="_blank"
                >
                    Instagram
                </a>

            @endif

            @if(!empty($footer->linkedin))

                <a
                    href="{{ $footer->linkedin }}"
                    target="_blank"
                >
                    LinkedIn
                </a>

            @endif

            @if(!empty($footer->whatsapp))

                <a
                    href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footer->whatsapp) }}"
                    target="_blank"
                >
                    WhatsApp
                </a>

            @endif

        </div>

    </div>

    <div class="footer-links">

        @foreach($navItems as $item)

            <a href="{{ str_starts_with($item->url, '#') ? route('home') . $item->url : url($item->url) }}">

                {{ $item->label }}

            </a>

        @endforeach

    </div>

    <div>

        <a href="mailto:{{ $footer->email ?? 'info@navurja.com' }}">

            {{ $footer->email ?? 'info@navurja.com' }}

        </a>

        <a href="tel:{{ $footer->phone ?? '+919876543210' }}">

            {{ $footer->phone ?? '+91 9876543210' }}

        </a>

        <p>

            {{ $footer->copyright_text ?? 'Copyright ' . date('Y') . ' Navurja. All rights reserved.' }}

        </p>

    </div>

</footer>

@if(!empty($footer->map_iframe))

    <div style="margin-top:40px;">

        {!! $footer->map_iframe !!}

    </div>

@endif

@if(!empty($footer->whatsapp))

    <a
        href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footer->whatsapp) }}"
        target="_blank"
        style="
            position:fixed;
            right:20px;
            bottom:20px;
            background:#25D366;
            color:#fff;
            padding:14px 18px;
            border-radius:999px;
            z-index:9999;
            font-weight:700;
            text-decoration:none;
            box-shadow:0 10px 30px rgba(0,0,0,.25);
        "
    >
        WhatsApp
    </a>

@endif

<script src="{{ asset('js/site.js') }}"></script>

</body>
</html>
