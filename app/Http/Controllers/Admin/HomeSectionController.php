<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresUploads;
use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\Request;

class HomeSectionController extends Controller
{
    use StoresUploads;

    public function edit()
    {
        return view('admin.homepage.edit', [

            'sections' => HomepageSection::all()->keyBy('key')

        ]);
    }

    public function update(Request $request)
    {
        $request->validate([

            'hero.hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',

            'about.image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',

            'why.image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',

            'services.image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',

            'contact.image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',

        ]);

        foreach ([
            'hero',
            'about',
            'services',
            'why',
            'contact'
        ] as $key) {

            $section = HomepageSection::firstOrCreate([
                'key' => $key
            ]);

            $data = [

                'title' => $request->input("$key.title"),

                'subtitle' => $request->input("$key.subtitle"),

                'content' => $request->input("$key.content"),

            ];

            if ($key === 'hero') {

                if ($path = $this->uploadImage(
                    $request->file('hero.hero_image')
                )) {

                    $data['hero_image'] = $path;

                }

            } else {

                if ($path = $this->uploadImage(
                    $request->file("$key.image")
                )) {

                    $data['image'] = $path;

                }

            }

            $section->update($data);

        }

        return back()->with(
            'success',
            'Homepage content saved successfully.'
        );
    }
}