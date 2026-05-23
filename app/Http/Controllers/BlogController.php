<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        return view('public.blog-index', [
            'posts' => Blog::with('category')->where('is_published', true)->latest('published_at')->paginate(9),
        ]);
    }

    public function show(string $slug)
    {
        $post = Blog::with('category')->where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('public.blog-show', compact('post'));
    }
}
