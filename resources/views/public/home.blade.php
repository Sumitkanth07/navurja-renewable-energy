@extends('layouts.site')
@section('content')
@php
    $hero = $sections['hero'] ?? null;
    $heroImage = $hero->hero_image ?? $hero->image ?? null;
@endphp
<section id="home" class="hero">
    <div class="hero-copy">
        <span class="eyebrow">Powering a Sustainable Tomorrow</span>
        <h1>{{ $hero->title ?? 'Renewable energy systems built for modern India.' }}</h1>
        <p>{{ $hero->subtitle ?? 'Navurja designs clean energy solutions that lower costs, improve resilience, and make sustainability practical.' }}</p>
        <div class="actions">
            <a class="btn" href="#contact">Start a Project</a>
            <a class="btn ghost" href="{{ route('calculator.index') }}">Calculate Savings</a>
        </div>
    </div>
    <figure class="hero-media hero-image">
        <img src="{{ $heroImage ? asset('storage/' . $heroImage) : asset('images/hero-placeholder.svg') }}" alt="Renewable energy solutions">
    </figure>
</section>
<section id="about" class="section split">
    <div><span class="eyebrow">About</span><h2>{{ $sections['about']->title ?? 'Clean technologies with practical engineering.' }}</h2><p>{{ $sections['about']->content ?? 'We help homes, offices, institutions, and businesses adopt renewable energy through solar, efficient power systems, audits, and long-term sustainability planning.' }}</p></div>
    <div class="glass-panel">Renewable energy consulting, sustainable power design, installation coordination, and efficiency upgrades under one thoughtful roof.</div>
</section>
<section id="services" class="section soft"><span class="eyebrow">Services</span><h2>Renewable Energy Services</h2><div class="grid four">@foreach($services as $service)<article class="card"><span>{{ $service->icon ?? '*' }}</span><h3>{{ $service->title }}</h3><p>{{ $service->description }}</p></article>@endforeach</div></section>
<section id="projects" class="section"><span class="eyebrow">Projects</span><h2>Recent Clean Energy Work</h2><div class="grid three">@foreach($projects as $project)<article class="project-card">@if($project->image)<img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->title }}">@endif<h3>{{ $project->title }}</h3><p>{{ $project->description }}</p></article>@endforeach</div></section>
<section id="why" class="section split deep"><div><span class="eyebrow">Why Choose Us</span><h2>{{ $sections['why']->title ?? 'Premium guidance without unnecessary complexity.' }}</h2></div><ul class="ticks"><li>Renewable-first strategy</li><li>Transparent lifecycle savings</li><li>Responsive support</li><li>Hostinger-ready digital CMS</li></ul></section>
<section class="section soft"><span class="eyebrow">Insights</span><h2>Renewable Energy Blog</h2><div class="grid three">@foreach($posts as $post)<a class="card link-card" href="{{ route('blog.show', $post->slug) }}"><h3>{{ $post->title }}</h3><p>{{ $post->meta_description }}</p></a>@endforeach</div></section>
<section id="contact" class="section contact"><div><span class="eyebrow">Contact</span><h2>Let's plan your clean energy upgrade.</h2><p>Email, call, or send the form. The map panel can be replaced with your live location embed later.</p><div class="map">Map Placeholder</div></div><form method="post" action="{{ route('contact.submit') }}">@csrf<input name="name" placeholder="Your name" required><input type="email" name="email" placeholder="Email address" required><textarea name="message" placeholder="Tell us about your project" required></textarea><button class="btn">Send Message</button></form></section>
@endsection
