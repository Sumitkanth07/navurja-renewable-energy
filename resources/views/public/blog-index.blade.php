@extends('layouts.site')

@section('title', 'Renewable Energy Blog - Navurja')

@section('content')

<main class="page">

    <span class="eyebrow">
        Blog
    </span>

    <h1 style="margin-bottom:14px;">
        Renewable Energy Insights
    </h1>

    <p
        style="
            max-width:760px;
            margin-bottom:50px;
            color:rgba(255,255,255,.72);
            line-height:1.8;
            font-size:18px;
        "
    >
        Explore renewable energy trends, solar innovations, sustainability strategies,
        and smart energy planning insights from Navurja Renewable Energy Solutions.
    </p>

    <div
        style="
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
            gap:28px;
        "
    >

        @forelse($posts as $post)

            <article
                style="
                    background:rgba(255,255,255,.03);
                    border:1px solid rgba(255,255,255,.08);
                    border-radius:24px;
                    overflow:hidden;
                    transition:.3s ease;
                "
            >

                <a
                    href="{{ route('blog.show', $post->slug) }}"
                    style="
                        text-decoration:none;
                        color:inherit;
                        display:block;
                        height:100%;
                    "
                >

                    @if($post->featured_image)

                        <img
                            src="{{ asset('storage/' . $post->featured_image) }}"
                            alt="{{ $post->title }}"
                            style="
                                width:100%;
                                height:240px;
                                object-fit:cover;
                                display:block;
                            "
                        >

                    @else

                        <div
                            style="
                                height:240px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                background:linear-gradient(135deg,#0c6b3f,#071b12);
                                color:#fff;
                                font-size:24px;
                                font-weight:700;
                            "
                        >

                            Navurja

                        </div>

                    @endif

                    <div style="padding:24px;">

                        <h3
                            style="
                                margin-bottom:16px;
                                line-height:1.4;
                                font-size:26px;
                            "
                        >
                            {{ $post->title }}
                        </h3>

                        <p
                            style="
                                color:rgba(255,255,255,.72);
                                line-height:1.8;
                                margin-bottom:20px;
                            "
                        >
                            {{ $post->meta_description }}
                        </p>

                        <span
                            style="
                                color:var(--primary);
                                font-weight:700;
                                font-size:15px;
                            "
                        >

                            Read Full Article →

                        </span>

                    </div>

                </a>

            </article>

        @empty

            <div
                style="
                    grid-column:1/-1;
                    text-align:center;
                    padding:100px 20px;
                "
            >

                <h2 style="margin-bottom:15px;">
                    No Blog Posts Available
                </h2>

                <p style="color:rgba(255,255,255,.72);">
                    Renewable energy insights and sustainability articles will appear here soon.
                </p>

            </div>

        @endforelse

    </div>

    <div style="margin-top:60px;">

        {{ $posts->links() }}

    </div>

</main>

@endsection