<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'featured_image', 'content',
        'meta_title', 'meta_description', 'meta_keywords', 'canonical_url',
        'og_title', 'og_description', 'og_image',
        'is_index', 'is_published'
    ];

    protected $casts = [
        'is_index' => 'boolean',
        'is_published' => 'boolean',
    ];
    protected static function booted()
    {
        static::saved(function ($page) {
            $slug = $page->slug;
            $url = '/' . $slug;

            if ($page->isDirty('slug')) {
                $oldSlug = $page->getOriginal('slug');
                if ($oldSlug) {
                    $oldUrl = '/' . $oldSlug;
                    \App\Models\NavigationItem::where('url', $oldUrl)->update(['url' => $url]);
                }
            }

            if ($page->is_published) {
                // Header item
                $headerItem = \App\Models\NavigationItem::where('url', $url)
                    ->where('menu_position', 'header')
                    ->first();
                if (!$headerItem) {
                    \App\Models\NavigationItem::create([
                        'label' => $page->title,
                        'url' => $url,
                        'menu_position' => 'header',
                        'is_active' => false,
                        'sort_order' => 10
                    ]);
                }

                // Footer item
                $footerItem = \App\Models\NavigationItem::where('url', $url)
                    ->where('menu_position', 'footer')
                    ->first();
                if (!$footerItem) {
                    $isPolicy = in_array($slug, ['privacy-policy', 'terms-and-conditions', 'cookie-policy', 'dmca-policy']);
                    \App\Models\NavigationItem::create([
                        'label' => $page->title,
                        'url' => $url,
                        'menu_position' => 'footer',
                        'is_active' => $isPolicy,
                        'sort_order' => 10
                    ]);
                }
            } else {
                \App\Models\NavigationItem::where('url', $url)->update(['is_active' => false]);
            }
        });

        static::deleted(function ($page) {
            $url = '/' . $page->slug;
            \App\Models\NavigationItem::where('url', $url)->delete();
        });
    }
}
