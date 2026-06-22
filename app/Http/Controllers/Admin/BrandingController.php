<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresUploads;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class BrandingController extends Controller
{
    use StoresUploads;

    public function edit()
    {
        return view('admin.branding.edit', [
            'settings' => (object) [
                'site_name' => Setting::getValue('site_name', 'Navurja'),
                'tagline' => Setting::getValue('tagline', 'Renewable Energy Solutions'),
                'primary_color' => Setting::getValue('primary_color', '#0c6b3f'),
                'secondary_color' => Setting::getValue('secondary_color', '#71c55d'),
                'logo' => Setting::getValue('logo'),
                'favicon' => Setting::getValue('favicon'),
                'facebook_url' => Setting::getValue('facebook_url'),
                'twitter_url' => Setting::getValue('twitter_url'),
                'linkedin_url' => Setting::getValue('linkedin_url'),
                'instagram_url' => Setting::getValue('instagram_url'),
            ],
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'required|max:150',
            'tagline' => 'required|max:180',
            'primary_color' => 'required|max:20',
            'secondary_color' => 'required|max:20',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,webp|max:1024',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
        ], [
            'site_name.required' => 'Please enter the site name.',
            'site_name.max' => 'The site name cannot exceed 150 characters.',
            'tagline.required' => 'Please enter the site tagline.',
            'tagline.max' => 'The tagline cannot exceed 180 characters.',
            'primary_color.required' => 'Please select a primary color.',
            'secondary_color.required' => 'Please select a secondary color.',
            'logo.image' => 'The logo file must be a valid image.',
            'logo.max' => 'The logo size must not exceed 2MB.',
            'favicon.image' => 'The favicon file must be a valid image.',
            'favicon.max' => 'The favicon size must not exceed 1MB.',
            'facebook_url.url' => 'Please enter a valid Facebook URL.',
            'twitter_url.url' => 'Please enter a valid Twitter URL.',
            'linkedin_url.url' => 'Please enter a valid LinkedIn URL.',
            'instagram_url.url' => 'Please enter a valid Instagram URL.',
        ]);

        foreach (['site_name', 'tagline', 'primary_color', 'secondary_color', 'facebook_url', 'twitter_url', 'linkedin_url', 'instagram_url'] as $key) {
            Setting::putValue($key, $data[$key] ?? '');
        }
        
        if ($request->hasFile('logo')) {
            if ($path = $this->uploadImage($request->file('logo'))) {
                Setting::putValue('logo', $path);
            }
        }
        if ($request->hasFile('favicon')) {
            if ($path = $this->uploadImage($request->file('favicon'))) {
                Setting::putValue('favicon', $path);
            }
        }

        return back()->with('success', 'Branding settings updated successfully.');
    }
}
