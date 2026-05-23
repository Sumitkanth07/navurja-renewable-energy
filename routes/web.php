<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CalculatorSettingController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\RedirectController as AdminRedirectController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\HomeController;
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
    Route::resource('projects', AdminProjectController::class)->except('show');
    Route::resource('navigation', NavigationController::class)->except('show');
    Route::resource('redirects', AdminRedirectController::class)->except('show');
    Route::get('homepage', [HomeSectionController::class, 'edit'])->name('homepage.edit');
    Route::put('homepage', [HomeSectionController::class, 'update'])->name('homepage.update');
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('calculator-settings', [CalculatorSettingController::class, 'edit'])->name('calculator.edit');
    Route::put('calculator-settings', [CalculatorSettingController::class, 'update'])->name('calculator.update');
    Route::post('upload-image', [UploadController::class, 'store'])->name('upload.image');
});
