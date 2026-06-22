@extends('layouts.site')

@section('content')

@php
    $hero = $sections['hero'] ?? null;
    $heroImage = $hero->hero_image ?? $hero->image ?? null;
@endphp

<section id="home" class="hero">

    <div class="hero-copy">

        <span class="eyebrow">
            Powering a Sustainable Tomorrow
        </span>

        <h1>
            {{ $hero->title ?? 'Renewable Energy Made Simple for Homes, Businesses and Industries' }}
        </h1>

        <p>
            {{ $hero->subtitle ?? 'Right Energy. Right Savings. Right Future.' }}
        </p>

        <div class="actions">

            <a class="btn" href="#contact">
                Start a Project
            </a>

            <a class="btn ghost" href="{{ route('calculator.index') }}">
                Calculate Savings
            </a>

        </div>

    </div>

    <figure class="hero-media hero-image">

        <img
    src="{{ $heroImage ? asset('storage/' . $heroImage) : asset('images/hero-placeholder.svg') }}"
    alt="Renewable energy solutions"
>

    </figure>

</section>

<section id="about" class="section split">

    <div>

        <span class="eyebrow">
            About
        </span>

        <h2>
            {{ $sections['about']->title ?? 'Helping Customers Move from Power Bills to Power Strategy' }}
        </h2>

        <p>
            {{ $sections['about']->content ?? 'Navurja is an integrated renewable energy solutions company helping residential, commercial, and industrial customers adopt practical clean energy systems with confidence.' }}
        </p>

    </div>

    @if(isset($sections['about']) && $sections['about']->image)

        <div class="section-image">

            <img
                src="{{ asset('storage/' . $sections['about']->image) }}"
                alt="About Navurja"
                style="width:100%; border-radius:20px;"
            >

        </div>

    @endif

</section>
<<<<<<< HEAD
<section id="services" class="section soft"><span class="eyebrow">Services</span><h2>Renewable Energy Services</h2><div class="grid four">@foreach($services as $service)<article class="card"><span>{{ $service->icon ?? '*' }}</span><h3>{{ $service->title }}</h3><p>{{ $service->description }}</p></article>@endforeach</div></section>
<section id="projects" class="section"><span class="eyebrow">Projects</span><h2>Recent Clean Energy Work</h2><div class="grid three">@foreach($projects as $project)<article class="project-card">@if($project->image)<img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->title }}">@endif<h3>{{ $project->title }}</h3><p>{{ $project->description }}</p></article>@endforeach</div></section>
<section id="why" class="section split deep"><div><span class="eyebrow">Why Choose Us</span><h2>{{ $sections['why']->title ?? 'Premium guidance without unnecessary complexity.' }}</h2></div><ul class="ticks"><li>Renewable-first strategy</li><li>Transparent lifecycle savings</li><li>Responsive support</li><li>Hostinger-ready digital CMS</li></ul></section>
<section class="section soft"><span class="eyebrow">Insights</span><h2>Renewable Energy Blog</h2><div class="grid three">@foreach($posts as $post)<a class="card link-card" href="{{ route('blog.show', $post->slug) }}"><h3>{{ $post->title }}</h3><p>{{ $post->meta_description }}</p></a>@endforeach</div></section>
<section id="contact" class="section contact">
    <div>
        <span class="eyebrow">Contact</span>
        <h2>Let's plan your clean energy upgrade.</h2>
        <div style="margin-bottom: 20px; line-height: 1.6;">
            <strong>Address:</strong> {{ $location->address ?? 'New Delhi, India' }}<br>
            <strong>Phone:</strong> {{ $location->phone ?? '+91 9876543210' }} @if(!empty($location->alt_phone)) / {{ $location->alt_phone }} @endif<br>
            <strong>Email:</strong> <a href="mailto:{{ $location->email ?? 'info@navurja.com' }}">{{ $location->email ?? 'info@navurja.com' }}</a><br>
            @if(!empty($location->working_hours))<strong>Hours:</strong> {{ $location->working_hours }}@endif
        </div>
        @if(!empty($location->map_url))
            @if(str_contains($location->map_url, '<iframe'))
                <div class="map-embed-container" style="border-radius: 8px; overflow: hidden; margin-top: 15px;">
                    {!! $location->map_url !!}
                </div>
            @else
                <iframe src="{{ $location->map_url }}" width="100%" height="250" style="border:0; border-radius: 8px; margin-top: 15px;" allowfullscreen="" loading="lazy"></iframe>
            @endif
        @else
            <div class="map">Map Placeholder</div>
        @endif
    </div>
    <form method="post" action="{{ route('contact.submit') }}">
        @csrf
        <input name="name" placeholder="Your name" required>
        <input type="email" name="email" placeholder="Email address" required>
        <textarea name="message" placeholder="Tell us about your project" required></textarea>
        <button class="btn">Send Message</button>
    </form>
</section>
@endsection
=======

<section id="services" class="section soft">

    <span class="eyebrow">
        Services
    </span>

    <h2>
        {{ $sections['services']->title ?? 'Renewable Energy Services' }}
    </h2>

    <p style="margin-bottom:40px;">
        {{ $sections['services']->content ?? 'Smart renewable energy solutions for homes and industries.' }}
    </p>

    <div class="grid three">

        @foreach($services as $service)

            <article class="card">

                @if($service->image)

                    <img
                        src="{{ asset('storage/' . $service->image) }}"
                        alt="{{ $service->title }}"
                        style="width:100%; border-radius:16px; margin-bottom:15px;"
                    >

                @endif

                <h3>
                    {{ $service->title }}
                </h3>

                <p>
                    {{ $service->description }}
                </p>

            </article>

        @endforeach

    </div>

</section>

<section id="projects" class="section">

    <span class="eyebrow">
        Projects
    </span>

    <h2>
        Recent Clean Energy Work
    </h2>

    <div class="grid three">

        @foreach($projects as $project)

            <article class="project-card">

                @if($project->image)

                    <img
                        src="{{ asset('storage/' . $project->image) }}"
                        alt="{{ $project->title }}"
                        style="width:100%; border-radius:16px; margin-bottom:15px;"
                    >

                @endif

                <h3>
                    {{ $project->title }}
                </h3>

                <p>
                    {{ $project->description }}
                </p>

            </article>

        @endforeach

    </div>

</section>

<section id="why" class="section split deep">

    <div>

        <span class="eyebrow">
            Why Choose Us
        </span>

        <h2>
            {{ $sections['why']->title ?? 'Why Businesses Trust Navurja for Renewable Energy Solutions' }}
        </h2>

        <p>
            {{ $sections['why']->content ?? 'We combine practical engineering, transparent consultation, and long-term renewable planning to help customers reduce electricity costs and improve sustainability performance.' }}
        </p>

    </div>

    @if(isset($sections['why']) && $sections['why']->image)

        <div class="section-image">

            <img
                src="{{ asset('storage/' . $sections['why']->image) }}"
                alt="Why Choose Navurja"
                style="width:100%; border-radius:20px;"
            >

        </div>

    @endif

</section>

<section class="section soft">

    <span class="eyebrow">
        Insights
    </span>

    <h2>
        Renewable Energy Blog
    </h2>

    <div class="grid three">

        @foreach($posts as $post)

            <a class="card link-card" href="{{ route('blog.show', $post->slug) }}">

                @if($post->featured_image)

                    <img
                        src="{{ asset('storage/' . $post->featured_image) }}"
                        alt="{{ $post->title }}"
                        style="width:100%; border-radius:16px; margin-bottom:15px;"
                    >

                @endif

                <h3>
                    {{ $post->title }}
                </h3>

                <p>
                    {{ $post->meta_description }}
                </p>

            </a>

        @endforeach

    </div>

</section>

<section id="contact" class="section contact">

    <div>

        <span class="eyebrow">
            Contact
        </span>

        <h2>
            {{ $sections['contact']->title ?? "Let's Plan Your Clean Energy Upgrade" }}
        </h2>

        <p>
            {{ $sections['contact']->content ?? 'Connect with Navurja Renewable Energy Solutions for renewable consultation and smart energy planning.' }}
        </p>

        <div
            style="
                display:flex;
                flex-direction:column;
                gap:18px;
                margin-top:30px;
                font-size:18px;
            "
        >

            <div>
                📧 {{ $footer->email ?? 'info@navurja.com' }}
            </div>

            <div>
                📞 {{ $footer->phone ?? '+91 9876543210' }}
            </div>

            <div>
                📍 {{ $footer->address ?? 'New Delhi, India' }}
            </div>

        </div>

    </div>

    <div>

        @if(isset($sections['contact']) && $sections['contact']->image)

            <img
                src="{{ asset('storage/' . $sections['contact']->image) }}"
                alt="Contact Navurja"
                style="
                    width:100%;
                    border-radius:24px;
                    box-shadow:0 20px 60px rgba(0,0,0,.25);
                "
            >

        @endif

    </div>

</section>

@endsection
>>>>>>> 08199bb0a324947ac31950b6abf03bd01005c56b
