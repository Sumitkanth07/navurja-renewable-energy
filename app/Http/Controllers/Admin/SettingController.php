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

            'company_name' => 'required|max:150',

            'email' => 'required|email',

            'phone' => 'required|max:40',

            'address' => 'required|max:400',

            'copyright_text' => 'required|max:200',

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

        if ($path = $this->uploadImage($request->file('logo'))) {

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
    }
}