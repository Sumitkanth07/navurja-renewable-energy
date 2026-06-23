<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CalculatorSettingController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\RedirectController as AdminRedirectController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BrandingController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\CookieController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
// Self-healing symlink check for production/local environments
try {
    $storageLinkPath = public_path('storage');
    if (is_link($storageLinkPath) && !file_exists($storageLinkPath)) {
        @unlink($storageLinkPath);
    }
    if (!file_exists($storageLinkPath)) {
        @symlink(storage_path('app/public'), $storageLinkPath);
    }
} catch (\Throwable $e) {
    // Silently catch to prevent routing exceptions
}

Route::middleware('redirects')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/contact', [HomeController::class, 'contact'])->name('contact.submit');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator.index');
    Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');
    Route::get('/robots.txt', [HomeController::class, 'robots'])->name('robots');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('blogs', AdminBlogController::class)->except('show');
    Route::post('blog-categories/quick-store', [BlogCategoryController::class, 'quickStore'])->name('blog-categories.quick-store');
    Route::resource('blog-categories', BlogCategoryController::class)->except('show');
    Route::resource('projects', AdminProjectController::class)->except('show');
    Route::resource('services', AdminServiceController::class)->except('show');
    Route::resource('navigation', NavigationController::class)->except('show');
    Route::resource('redirects', AdminRedirectController::class)->except('show');
    
    // Page Builder Routes
    Route::post('pages/bulk-action', [AdminPageController::class, 'bulkAction'])->name('pages.bulk-action');
    Route::resource('pages', AdminPageController::class)->except('show');
    
    Route::get('homepage', [HomeSectionController::class, 'edit'])->name('homepage.edit');
    Route::put('homepage', [HomeSectionController::class, 'update'])->name('homepage.update');
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('branding', [BrandingController::class, 'edit'])->name('branding.edit');
    Route::put('branding', [BrandingController::class, 'update'])->name('branding.update');
    Route::get('footer', [FooterController::class, 'edit'])->name('footer.edit');
    Route::put('footer', [FooterController::class, 'update'])->name('footer.update');
    Route::get('location', [LocationController::class, 'edit'])->name('location.edit');
    Route::put('location', [LocationController::class, 'update'])->name('location.update');
    Route::get('cookie-settings', [CookieController::class, 'edit'])->name('cookie-settings.edit');
    Route::put('cookie-settings', [CookieController::class, 'update'])->name('cookie-settings.update');
    Route::get('calculator-settings', [CalculatorSettingController::class, 'edit'])->name('calculator.edit');
    Route::put('calculator-settings', [CalculatorSettingController::class, 'update'])->name('calculator.update');
    Route::post('upload-image', [UploadController::class, 'store'])->name('upload.image');
});

// Fallback storage route for hosting environments where symbolic links are disabled
Route::get('storage/{path}', function ($path) {
    $path = str_replace('../', '', $path);
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath) || is_dir($fullPath)) {
        abort(404);
    }
    return response()->file($fullPath);
})->where('path', '.*')->name('storage.local');

// Temporary deployment helper to clear caches and run migrations on production
Route::get('/debug-deploy-help', function() {
    try {
        $output = "";
        
        // Clear view cache
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        $output .= "View cache cleared: " . \Illuminate\Support\Facades\Artisan::output() . "<br>";
        
        // Clear config and cache
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        $output .= "Config cache cleared: " . \Illuminate\Support\Facades\Artisan::output() . "<br>";
        
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        $output .= "Cache cleared: " . \Illuminate\Support\Facades\Artisan::output() . "<br>";
        
        // Run migrations
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output .= "Migrations run: " . \Illuminate\Support\Facades\Artisan::output() . "<br>";
        
        // Recursively search for image files
        $findImages = function($dir) use (&$findImages) {
            $results = [];
            if (!is_dir($dir)) return $results;
            $files = @scandir($dir);
            if (!$files) return $results;
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $full = $dir . '/' . $file;
                if (is_dir($full)) {
                    // Skip node_modules and vendor to be fast
                    if (str_contains($full, 'node_modules') || str_contains($full, 'vendor') || str_contains($full, '.git')) continue;
                    $results = array_merge($results, $findImages($full));
                } else {
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'ico'])) {
                        $results[] = $full;
                    }
                }
                if (count($results) > 200) break;
            }
            return $results;
        };
        
        $output .= "<b>Found image files on production:</b><br>";
        $foundImages = $findImages(dirname(public_path()));
        foreach ($foundImages as $img) {
            $output .= str_replace(dirname(public_path()), '', $img) . "<br>";
        }
        
        // Heal database image paths
        \App\Models\Setting::putValue('logo', 'uploads/oj0IKH8nXvcRQuZlOdAmJ9f7QmaAJ5Fj3XYsjZrZ.jpg');
        
        $heroSec = \App\Models\HomepageSection::where('key', 'hero')->first();
        if ($heroSec) {
            $heroSec->update(['hero_image' => 'uploads/1TxzFM03wGXubkkZHh990lkkCYjdX0UF49iL7Kdr.png', 'image' => null]);
        }
        $aboutSec = \App\Models\HomepageSection::where('key', 'about')->first();
        if ($aboutSec) {
            $aboutSec->update(['image' => 'uploads/VSCVh8AAND6VTUPFhVUvNSrmvUXPBhbvMOxzPM11.png']);
        }
        $whySec = \App\Models\HomepageSection::where('key', 'why')->first();
        if ($whySec) {
            $whySec->update(['image' => 'uploads/7EB835wnr9L3YQa5sD5k8MZ39iTANHU5t7mbv4My.png']);
        }
        
        $blog1 = \App\Models\Blog::where('slug', 'benefits-of-renewable-energy')->first();
        if ($blog1) {
            $blog1->update(['featured_image' => 'uploads/NjbRezlePMh0pTiVDZlnSD5Bl1eusfixtY7OcNAb.png']);
        }
        $blog2 = \App\Models\Blog::where('slug', 'powering-a-sustainable-future-with-smart-renewable-energy-solutions')->first();
        if ($blog2) {
            $blog2->update(['featured_image' => 'uploads/fE6XP758lkJwpx4MLQwtOhIbP7WbgWVA1I6CT0N1.png']);
        }
        
        $projects = \App\Models\Project::all();
        $projectImages = [
            'uploads/6yE0mUvKnv8ljU558VA1XYC3GDMxxg7dGqQDyNc8.png',
            'uploads/5EvSPUDOfRSQQISku9uw23ZUEErLKClSDanMGsRx.png',
            'uploads/r5oqzc0IAYivsSwqkIYafnA2SuqEDi74hx969HLf.png',
        ];
        $i = 0;
        foreach ($projects as $proj) {
            if (isset($projectImages[$i])) {
                $proj->update(['image' => $projectImages[$i]]);
                $i++;
            }
        }
        
        $output .= "<b>Database values healed and updated:</b><br>";
        $output .= "logo: " . \App\Models\Setting::getValue('logo') . "<br>";
        $output .= "favicon: " . \App\Models\Setting::getValue('favicon') . "<br>";
        if ($heroSec) {
            $output .= "hero image: " . ($heroSec->fresh()->hero_image ?? $heroSec->fresh()->image) . "<br>";
        }
        if ($aboutSec) {
            $output .= "about image: " . $aboutSec->fresh()->image . "<br>";
        }
        
        return "Deployment help executed successfully:<br>" . $output;
    } catch (\Throwable $e) {
        return "Error: " . $e->getMessage() . "<br>File: " . $e->getFile() . " on line " . $e->getLine();
    }
});

// Fallback route for dynamic pages
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
