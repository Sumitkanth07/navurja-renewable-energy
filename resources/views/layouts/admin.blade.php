<!doctype html>
<<<<<<< HEAD
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Navurja Admin</title><link rel="stylesheet" href="{{ asset('css/admin.css') }}"><script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script></head>
<body><aside class="admin-side"><h2>Navurja<small>Admin CMS</small></h2><a href="{{ route('admin.dashboard') }}">Dashboard</a><a href="{{ route('admin.pages.index') }}">CMS Pages</a><a href="{{ route('admin.homepage.edit') }}">Homepage Manager</a><a href="{{ route('admin.blogs.index') }}">Blog Management</a><a href="{{ route('admin.blog-categories.index') }}">Blog Categories</a><a href="{{ route('admin.projects.index') }}">Projects</a><a href="{{ route('admin.branding.edit') }}">Branding Manager</a><a href="{{ route('admin.footer.edit') }}">Footer Manager</a><a href="{{ route('admin.location.edit') }}">Location Manager</a><a href="{{ route('admin.cookie-settings.edit') }}">Cookie Settings</a><a href="{{ route('admin.calculator.edit') }}">Calculator Settings</a><a href="{{ route('admin.navigation.index') }}">Navigation Manager</a><a href="{{ route('admin.redirects.index') }}">Redirect Manager</a><form method="post" action="{{ route('admin.logout') }}">@csrf<button>Logout</button></form></aside><main class="admin-main">@if(session('success'))<div class="notice">{{ session('success') }}</div>@endif @if($errors->any())<div class="error">{{ $errors->first() }}</div>@endif @yield('content')</main><script src="{{ asset('js/admin.js') }}"></script></body></html>
=======

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Navurja Admin
    </title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>

</head>

<body>

    <aside class="admin-side">

        <h2>
            Navurja
            <small>Admin CMS</small>
        </h2>

        <a href="{{ route('admin.dashboard') }}">
            Dashboard
        </a>

        <a href="{{ route('admin.homepage.edit') }}">
            Homepage Manager
        </a>

        <a href="{{ route('admin.blogs.index') }}">
            Blog Management
        </a>

        <a href="{{ route('admin.projects.index') }}">
            Projects
        </a>

        <a href="{{ route('admin.services.index') }}">
            Services
        </a>

        <a href="{{ route('admin.calculator.edit') }}">
            Calculator Settings
        </a>

        <a href="{{ route('admin.settings.edit') }}">
            Branding & Footer
        </a>

        <a href="{{ route('admin.navigation.index') }}">
            Navigation Manager
        </a>

        <a href="{{ route('admin.redirects.index') }}">
            Redirect Manager
        </a>

        <form
            method="post"
            action="{{ route('admin.logout') }}"
        >

            @csrf

            <button>
                Logout
            </button>

        </form>

    </aside>

    <main class="admin-main">

        @if(session('success'))

            <div class="notice">
                {{ session('success') }}
            </div>

        @endif

        @if($errors->any())

            <div class="error">
                {{ $errors->first() }}
            </div>

        @endif

        @yield('content')

    </main>

    <script src="{{ asset('js/admin.js') }}"></script>

</body>

</html>
>>>>>>> 08199bb0a324947ac31950b6abf03bd01005c56b
