<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresUploads;
use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use StoresUploads;

    public function edit()
    {
        return view('admin.settings.edit', [
            'footer' => FooterSetting::first(),
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
                'cookie_consent_enabled' => Setting::getValue('cookie_consent_enabled', '0'),
                'cookie_popup_title' => Setting::getValue('cookie_popup_title', 'We Value Your Privacy'),
                'cookie_popup_content' => Setting::getValue('cookie_popup_content', 'This website uses cookies to ensure you get the best experience.'),
                'cookie_accept_text' => Setting::getValue('cookie_accept_text', 'Accept'),
                'cookie_reject_text' => Setting::getValue('cookie_reject_text', 'Decline'),
                'cookie_consent_expiry' => Setting::getValue('cookie_consent_expiry', '30'),
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
            'company_name' => 'required|max:150',
            'email' => 'required|email',
            'phone' => 'required|max:40',
            'address' => 'required|max:400',
            'copyright_text' => 'required|max:200',
            'cookie_popup_title' => 'nullable|string|max:150',
            'cookie_popup_content' => 'nullable|string|max:400',
            'cookie_accept_text' => 'nullable|string|max:50',
            'cookie_reject_text' => 'nullable|string|max:50',
            'cookie_consent_expiry' => 'nullable|integer|min:1',
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
            'company_name.required' => 'Please enter the company name.',
            'company_name.max' => 'The company name cannot exceed 150 characters.',
            'copyright_text.required' => 'Please enter the copyright text.',
            'copyright_text.max' => 'The copyright text cannot exceed 200 characters.',
            'cookie_popup_title.max' => 'The popup title cannot exceed 150 characters.',
            'cookie_popup_content.max' => 'The popup description content cannot exceed 400 characters.',
            'cookie_accept_text.max' => 'The accept button text cannot exceed 50 characters.',
            'cookie_reject_text.max' => 'The reject button text cannot exceed 50 characters.',
            'cookie_consent_expiry.integer' => 'The expiry days must be a number.',
            'cookie_consent_expiry.min' => 'The expiry days must be at least 1 day.',
        ]);

        $data['cookie_consent_enabled'] = $request->has('cookie_consent_enabled') ? '1' : '0';

        foreach (['site_name', 'tagline', 'primary_color', 'secondary_color', 'facebook_url', 'twitter_url', 'linkedin_url', 'instagram_url', 'cookie_consent_enabled', 'cookie_popup_title', 'cookie_popup_content', 'cookie_accept_text', 'cookie_reject_text', 'cookie_consent_expiry'] as $key) {
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

        FooterSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'company_name' => $data['company_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'copyright_text' => $data['copyright_text'],
            ]
        );

        return back()->with('success', 'Settings saved successfully.');
    }
}