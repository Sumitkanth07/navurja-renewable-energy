<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->first();
        
        if (!$page && in_array($slug, ['privacy-policy', 'terms-and-conditions', 'cookie-policy', 'dmca-policy'])) {
            $title = ucwords(str_replace('-', ' ', $slug));
            if ($slug === 'terms-and-conditions') {
                $title = 'Terms & Conditions';
            }
            $page = Page::create([
                'title' => $title,
                'slug' => $slug,
                'content' => "<p>This is the default {$title} page. You can edit this content in the Admin Panel.</p>",
                'is_published' => true
            ]);
        }
        
        if (!$page || !$page->is_published) {
            abort(404);
        }
        
        return view('public.page', compact('page'));
    }
}
