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
use Illuminate\Support\Facades\Route;

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

// Fallback route for dynamic pages
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
