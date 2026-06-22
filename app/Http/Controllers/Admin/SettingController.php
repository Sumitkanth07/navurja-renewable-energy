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
<<<<<<< HEAD
                'favicon' => Setting::getValue('favicon'),
                'facebook_url' => Setting::getValue('facebook_url'),
                'twitter_url' => Setting::getValue('twitter_url'),
                'linkedin_url' => Setting::getValue('linkedin_url'),
                'instagram_url' => Setting::getValue('instagram_url'),
                'cookie_consent_enabled' => Setting::getValue('cookie_consent_enabled', '0'),
                'cookie_popup_title' => Setting::getValue('cookie_popup_title', 'We use cookies'),
                'cookie_popup_content' => Setting::getValue('cookie_popup_content', 'This website uses cookies to ensure you get the best experience.'),
                'cookie_accept_text' => Setting::getValue('cookie_accept_text', 'Accept'),
                'cookie_reject_text' => Setting::getValue('cookie_reject_text', 'Decline'),
                'cookie_consent_expiry' => Setting::getValue('cookie_consent_expiry', '30'),
=======

>>>>>>> 08199bb0a324947ac31950b6abf03bd01005c56b
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
<<<<<<< HEAD
            'favicon' => 'nullable|image|mimes:ico,png,webp|max:1024',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
=======

>>>>>>> 08199bb0a324947ac31950b6abf03bd01005c56b
            'company_name' => 'required|max:150',

            'email' => 'required|email',

            'phone' => 'required|max:40',

            'address' => 'required|max:400',

            'copyright_text' => 'required|max:200',
<<<<<<< HEAD
            'cookie_popup_title' => 'nullable|string|max:150',
            'cookie_popup_content' => 'nullable|string|max:400',
            'cookie_accept_text' => 'nullable|string|max:50',
            'cookie_reject_text' => 'nullable|string|max:50',
            'cookie_consent_expiry' => 'nullable|integer|min:1',
        ]);

        $data['cookie_consent_enabled'] = $request->has('cookie_consent_enabled') ? '1' : '0';

        foreach (['site_name', 'tagline', 'primary_color', 'secondary_color', 'facebook_url', 'twitter_url', 'linkedin_url', 'instagram_url', 'cookie_consent_enabled', 'cookie_popup_title', 'cookie_popup_content', 'cookie_accept_text', 'cookie_reject_text', 'cookie_consent_expiry'] as $key) {
            Setting::putValue($key, $data[$key] ?? '');
        }
        if ($path = $this->uploadImage($request->file('logo'))) Setting::putValue('logo', $path);
        if ($path = $this->uploadImage($request->file('favicon'))) Setting::putValue('favicon', $path);
=======

            'facebook' => 'nullable|max:255',

            'instagram' => 'nullable|max:255',

            'linkedin' => 'nullable|max:255',

            'whatsapp' => 'nullable|max:255',

            'map_iframe' => 'nullable',

        ]);

        foreach ([
            'site_name',
            'tagline',
            'primary_color',
            'secondary_color'
        ] as $key) {

            Setting::putValue($key, $data[$key]);

        }
>>>>>>> 08199bb0a324947ac31950b6abf03bd01005c56b

        if ($path = $this->uploadImage($request->file('logo'))) {

<<<<<<< HEAD
        return back()->with('success', 'Settings saved successfully.');
=======
            Setting::putValue('logo', $path);

        }

        FooterSetting::query()->updateOrCreate(

            ['id' => 1],

            [

                'company_name' => $data['company_name'],

                'email' => $data['email'],

                'phone' => $data['phone'],

                'address' => $data['address'],

                'copyright_text' => $data['copyright_text'],

                'facebook' => $data['facebook'] ?? null,

                'instagram' => $data['instagram'] ?? null,

                'linkedin' => $data['linkedin'] ?? null,

                'whatsapp' => $data['whatsapp'] ?? null,

                'map_iframe' => $data['map_iframe'] ?? null,

            ]

        );

        return back()->with(
            'success',
            'Branding and footer saved successfully.'
        );
>>>>>>> 08199bb0a324947ac31950b6abf03bd01005c56b
    }
}