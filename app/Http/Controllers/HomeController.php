<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\FooterSetting;
use App\Models\HomepageSection;
use App\Models\NavigationItem;
use App\Models\Project;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        return view('public.home', [
            'sections' => HomepageSection::all()->keyBy('key'),
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get(),
            'projects' => Project::where('is_active', true)->latest()->take(6)->get(),
            'posts' => Blog::where('is_published', true)->latest('published_at')->take(3)->get(),
            'location' => \App\Models\Location::first(),
        ]);
    }

    public function contact()
    {
        request()->validate(['name' => 'required|max:100', 'email' => 'required|email', 'message' => 'required|max:2000']);
        return back()->with('success', 'Thank you. Your message has been received.');
    }

    public function sitemap()
    {
        $posts = Blog::where('is_published', true)->get();
        return response()->view('public.sitemap', compact('posts'))->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        return response("User-agent: *\nAllow: /\nSitemap: ".url('/sitemap.xml')."\n", 200)->header('Content-Type', 'text/plain');
    }
}
