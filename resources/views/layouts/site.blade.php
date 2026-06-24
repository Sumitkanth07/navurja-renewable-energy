@php
use App\Models\Setting;
use App\Models\NavigationItem;
use App\Models\FooterSetting;
use App\Models\Location;

$siteName = Setting::getValue('site_name', 'Navurja');
$tagline = Setting::getValue('tagline', 'Renewable Energy Solutions');
$logo = Setting::getValue('logo');
$favicon = Setting::getValue('favicon');
$footer = FooterSetting::first() ?? new FooterSetting();
$location = Location::first();
$facebook_url = !empty($footer->facebook_url) ? $footer->facebook_url : Setting::getValue('facebook_url');
$twitter_url = !empty($footer->twitter_url) ? $footer->twitter_url : Setting::getValue('twitter_url');
$linkedin_url = !empty($footer->linkedin_url) ? $footer->linkedin_url : Setting::getValue('linkedin_url');
$instagram_url = !empty($footer->instagram_url) ? $footer->instagram_url : Setting::getValue('instagram_url');
$youtube_url = !empty($footer->youtube_url) ? $footer->youtube_url : Setting::getValue('youtube_url');
$headerItems = NavigationItem::where('is_active', true)->where('menu_position', 'header')->whereNull('parent_id')->with(['children' => function($q) { $q->where('is_active', true); }])->orderBy('sort_order')->get();
$footerItems = NavigationItem::where('is_active', true)->where('menu_position', 'footer')->orderBy('sort_order')->get();

$cookieEnabled = Setting::getValue('cookie_consent_enabled', '1');
$cookieTitle = Setting::getValue('cookie_popup_title', 'We Value Your Privacy');
$cookieContent = Setting::getValue('cookie_popup_content', 'This website uses cookies to ensure you get the best experience.');
$cookieAccept = Setting::getValue('cookie_accept_text', 'Accept');
$cookieReject = Setting::getValue('cookie_reject_text', 'Decline');
$cookieExpiry = Setting::getValue('cookie_consent_expiry', '30');

$defaultOgImage = $logo ? asset('storage/' . $logo) : asset('images/logo.png');
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $siteName.' - '.$tagline)</title>
    <meta name="description" content="@yield('meta_description', 'Premium renewable energy solutions for modern homes and businesses.')">
    @if(View::hasSection('meta_keywords'))
    <meta name="keywords" content="@yield('meta_keywords')">
    @endif
    @if(View::hasSection('robots'))
    <meta name="robots" content="@yield('robots')">
    @endif
    @if(View::hasSection('canonical'))
    <link rel="canonical" href="@yield('canonical')">
    @endif
    
    <link rel="icon" type="image/x-icon" href="{{ $favicon ? asset('storage/' . $favicon) : asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $favicon ? asset('storage/' . $favicon) : asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ $favicon ? asset('storage/' . $favicon) : asset('favicon.ico') }}">

    <!-- Open Graph Tags -->
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="@yield('og_title', View::hasSection('title') ? View::yieldContent('title') : $siteName)">
    <meta property="og:description" content="@yield('og_description', View::hasSection('meta_description') ? View::yieldContent('meta_description') : $tagline)">
    <meta property="og:image" content="@yield('og_image', $defaultOgImage)">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ $siteName }}">
    <meta name="twitter:title" content="@yield('og_title', View::hasSection('title') ? View::yieldContent('title') : $siteName)">
    <meta name="twitter:description" content="@yield('og_description', View::hasSection('meta_description') ? View::yieldContent('meta_description') : $tagline)">
    <meta name="twitter:image" content="@yield('og_image', $defaultOgImage)">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "Organization",
      "name": "{{ $siteName }}",
      "url": "{{ url('/') }}",
      "logo": "{{ $logo ? asset('storage/' . $logo) : asset('images/logo.png') }}"
    }
    </script>
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "WebSite",
      "name": "{{ $siteName }}",
      "url": "{{ url('/') }}"
    }
    </script>

    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <style>
        .site-nav .has-dropdown { position: relative; }
        .site-nav .dropdown { display: none; position: absolute; top: 100%; left: 0; background: var(--bg); padding: 10px; border-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); min-width: 150px; z-index: 10; }
        .site-nav .has-dropdown:hover .dropdown { display: flex; flex-direction: column; }
        .site-nav .dropdown a { padding: 5px 10px; display: block; }
        
        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            left: 40px;
            background-color: #25d366;
            color: #fff;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 99999;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
        }
        .whatsapp-float:hover {
            transform: scale(1.1);
            background-color: #20ba5a;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            color: #fff;
        }
        @media (max-width: 768px) {
            .whatsapp-float {
                width: 50px;
                height: 50px;
                bottom: 20px;
                left: 20px;
            }
        }

        .cookie-consent-banner {
            position: fixed;
            bottom: 30px;
            right: 30px;
            left: 30px;
            background: rgba(255, 255, 255, 0.98);
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 15px;
            border: 1px solid rgba(0,0,0,0.05);
            max-width: 450px;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            transform: translateY(180px);
            opacity: 0;
            box-sizing: border-box;
        }
        @media (min-width: 768px) {
            .cookie-consent-banner {
                left: auto;
            }
        }
        .cookie-consent-banner.show {
            transform: translateY(0);
            opacity: 1;
        }
        .cookie-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cookie-header svg {
            color: var(--primary);
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }
        .cookie-header strong {
            font-size: 1.1rem;
            color: #0f172a;
            font-weight: 700;
        }
        .cookie-body {
            font-size: 0.9rem;
            color: #475569;
            line-height: 1.5;
            margin: 0;
        }
        .cookie-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .cookie-buttons button {
            padding: 10px 18px;
            font-weight: 600;
            font-size: 0.85rem;
            border-radius: 8px;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-accept {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 10px rgba(12, 107, 63, 0.2);
        }
        .btn-accept:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(12, 107, 63, 0.3);
        }
        .btn-reject {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        .btn-reject:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
        .social-links { display: flex; gap: 15px; margin-top: 15px; }
        .social-links a { color: var(--primary); text-decoration: none; font-weight: bold; }
    </style>
</head>
<body style="--primary: {{ Setting::getValue('primary_color', '#0c6b3f') }}; --secondary: {{ Setting::getValue('secondary_color', '#71c55d') }}">
<header class="site-header">
    <a class="brand navbar-brand" href="{{ route('home') }}">
        @if($logo)
            <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteName }} logo">
        @elseif(file_exists(public_path('images/logo.png')))
            <img src="{{ asset('images/logo.png') }}" alt="{{ $siteName }} logo">
        @else
            <span class="brand-mark">N</span>
        @endif
        <div class="brand-text">
            <span class="brand-title">{{ $siteName }}</span>
            <span class="brand-subtitle">{{ $tagline }}</span>
        </div>
    </a>
    <div class="header-actions">
        <button class="theme-toggle" type="button" aria-label="Toggle dark mode" aria-pressed="false">Dark</button>
        <button class="menu-toggle" type="button" aria-label="Open menu">Menu</button>
        <nav class="site-nav">
            @foreach($headerItems as $item)
                @if($item->children->count() > 0)
                    <div class="has-dropdown">
                        <a href="{{ str_starts_with($item->url, '#') ? route('home').$item->url : url($item->url) }}">{{ $item->label }} ▾</a>
                        <div class="dropdown">
                            @foreach($item->children as $child)
                                <a href="{{ str_starts_with($child->url, '#') ? route('home').$child->url : url($child->url) }}">{{ $child->label }}</a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ str_starts_with($item->url, '#') ? route('home').$item->url : url($item->url) }}">{{ $item->label }}</a>
                @endif
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
        @if(!empty($footer->footer_logo))
            <img src="{{ asset('storage/' . $footer->footer_logo) }}" alt="{{ $footer->company_name }} Logo" style="max-height: 55px; margin-bottom: 12px; display: block; border-radius: 4px;">
        @else
            <h3>{{ $footer->company_name ?? 'Navurja' }}</h3>
        @endif

        @if(!empty($footer->footer_description))
            <p style="margin-bottom: 15px; max-width: 320px; line-height: 1.5; font-size: 0.95em; color: var(--muted, #64748b);">{{ $footer->footer_description }}</p>
        @endif

        <p>
            {{ $footer->address ?? $location?->address ?? 'New Delhi, India' }}
            @if(!empty($footer->map_url))
                <br><a href="{{ $footer->map_url }}" target="_blank" rel="noopener noreferrer" style="font-size: 0.85em; text-decoration: underline; color: var(--primary, #0c6b3f);">View on Google Maps</a>
            @endif
        </p>
        
        <div class="social-links">
            @if($facebook_url)<a href="{{ $facebook_url }}" target="_blank" rel="noopener noreferrer">Facebook</a>@endif
            @if($twitter_url)<a href="{{ $twitter_url }}" target="_blank" rel="noopener noreferrer">Twitter/X</a>@endif
            @if($linkedin_url)<a href="{{ $linkedin_url }}" target="_blank" rel="noopener noreferrer">LinkedIn</a>@endif
            @if($instagram_url)<a href="{{ $instagram_url }}" target="_blank" rel="noopener noreferrer">Instagram</a>@endif
            @if($youtube_url)<a href="{{ $youtube_url }}" target="_blank" rel="noopener noreferrer">YouTube</a>@endif
        </div>
    </div>
    <div class="footer-links" style="display:flex; flex-direction:column; gap:5px;">
        @forelse($footerItems as $item)
            <a href="{{ str_starts_with($item->url, '#') ? route('home').$item->url : url($item->url) }}">{{ $item->label }}</a>
        @empty
            <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
            <a href="{{ url('/terms-and-conditions') }}">Terms & Conditions</a>
            <a href="{{ url('/cookie-policy') }}">Cookie Policy</a>
            <a href="{{ url('/dmca-policy') }}">DMCA Policy</a>
        @endforelse
    </div>
    <div>
        @if(!empty($footer->email) || !empty($location?->email))
            <a href="mailto:{{ $footer->email ?? $location->email }}">{{ $footer->email ?? $location->email }}</a><br>
        @endif
        @if(!empty($footer->phone) || !empty($location?->phone))
            <a href="tel:{{ $footer->phone ?? $location->phone }}">{{ $footer->phone ?? $location->phone }}</a><br>
        @endif
        @if(!empty($footer->alternate_phone))
            <a href="tel:{{ $footer->alternate_phone }}">{{ $footer->alternate_phone }}</a><br>
        @endif
        @if(!empty($footer->whatsapp_number))
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footer->whatsapp_number) }}{{ !empty($footer->whatsapp_message) ? '?text=' . urlencode($footer->whatsapp_message) : '' }}" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 6px; margin-top: 8px; color: #25d366; font-weight: 600; text-decoration: none;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor" style="vertical-align: middle;"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.963C16.58 1.98 14.11 1.01 11.998 1.01c-5.442 0-9.866 4.372-9.87 9.802 0 1.714.47 3.388 1.357 4.921l-.995 3.635 3.73-.974zm12.338-7.391c-.328-.164-1.94-.959-2.241-1.07-.301-.111-.521-.165-.741.164-.221.33-.854 1.071-1.047 1.29-.193.221-.387.248-.715.084-.329-.164-1.389-.511-2.645-1.631-.977-.872-1.637-1.95-1.829-2.277-.193-.329-.021-.507.143-.671.147-.148.328-.385.493-.576.164-.193.22-.33.328-.549.11-.22.055-.412-.027-.577-.082-.164-.741-1.785-1.014-2.443-.267-.643-.538-.553-.74-.563-.19-.01-.41-.011-.628-.011-.22 0-.576.082-.877.411-.301.33-1.15 1.125-1.15 2.742 0 1.617 1.178 3.185 1.342 3.404.164.22 2.317 3.538 5.61 4.962.783.338 1.395.54 1.872.691.787.25 1.5.215 2.066.13.63-.095 1.94-.794 2.215-1.562.274-.768.274-1.426.192-1.562-.082-.137-.301-.22-.628-.384z"/></svg>
                WhatsApp Contact
            </a><br>
        @endif
        <p style="margin-top: 10px;">{{ $footer->copyright_text ?? 'Copyright '.date('Y').' Navurja. All rights reserved.' }}</p>
    </div>
</footer>

@if($cookieEnabled === '1')
<div id="cookieConsent" class="cookie-consent-banner" style="display: none;">
    <div class="cookie-header">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5Z"/><path d="M12 10h.01M16 14h.01M8 14h.01M12 18h.01M12 6h.01M17 9h.01"/></svg>
        <strong>{{ $cookieTitle }}</strong>
    </div>
    <p class="cookie-body">{{ $cookieContent }}</p>
    <div class="cookie-buttons">
        <button class="btn-reject" onclick="handleCookie('rejected')">{{ $cookieReject }}</button>
        <button class="btn-accept" onclick="handleCookie('accepted')">{{ $cookieAccept }}</button>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const consent = getCookie('cookie_consent');
        if (!consent) {
            const banner = document.getElementById('cookieConsent');
            banner.style.display = 'flex';
            setTimeout(() => {
                banner.classList.add('show');
            }, 800);
        }
    });

    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/; SameSite=Lax";
    }

    function getCookie(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function handleCookie(status) {
        setCookie('cookie_consent', status, {{ (int) ($cookieExpiry ?: 30) }});
        const banner = document.getElementById('cookieConsent');
        banner.classList.remove('show');
        setTimeout(() => {
            banner.style.display = 'none';
        }, 500);
    }
</script>
@endif

<script src="{{ asset('js/site.js') }}"></script>

@if(!empty($footer->whatsapp_enabled) && !empty($footer->whatsapp_number))
<a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $footer->whatsapp_number) }}{{ !empty($footer->whatsapp_message) ? '?text=' . urlencode($footer->whatsapp_message) : '' }}" class="whatsapp-float" target="_blank" rel="noopener noreferrer" title="Chat with us on WhatsApp" id="whatsappFloatBtn">
    <svg viewBox="0 0 24 24" width="30" height="30" fill="currentColor">
        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.458L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.963C16.58 1.98 14.11 1.01 11.998 1.01c-5.442 0-9.866 4.372-9.87 9.802 0 1.714.47 3.388 1.357 4.921l-.995 3.635 3.73-.974zm12.338-7.391c-.328-.164-1.94-.959-2.241-1.07-.301-.111-.521-.165-.741.164-.221.33-.854 1.071-1.047 1.29-.193.221-.387.248-.715.084-.329-.164-1.389-.511-2.645-1.631-.977-.872-1.637-1.95-1.829-2.277-.193-.329-.021-.507.143-.671.147-.148.328-.385.493-.576.164-.193.22-.33.328-.549.11-.22.055-.412-.027-.577-.082-.164-.741-1.785-1.014-2.443-.267-.643-.538-.553-.74-.563-.19-.01-.41-.011-.628-.011-.22 0-.576.082-.877.411-.301.33-1.15 1.125-1.15 2.742 0 1.617 1.178 3.185 1.342 3.404.164.22 2.317 3.538 5.61 4.962.783.338 1.395.54 1.872.691.787.25 1.5.215 2.066.13.63-.095 1.94-.794 2.215-1.562.274-.768.274-1.426.192-1.562-.082-.137-.301-.22-.628-.384z"/>
    </svg>
</a>
@endif

</body>
</html>
