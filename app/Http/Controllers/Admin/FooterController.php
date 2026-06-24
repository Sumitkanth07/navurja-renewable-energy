<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\StoresUploads;
use App\Models\FooterSetting;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    use StoresUploads;

    public function edit()
    {
        return view('admin.footer.edit', [
            'footer' => FooterSetting::first() ?? new FooterSetting(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'required|max:150',
            'footer_description' => 'nullable|string|max:500',
            'copyright_text' => 'required|max:200',
            'phone' => 'nullable|string|max:50',
            'alternate_phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:150',
            'address' => 'nullable|string|max:500',
            'map_url' => 'nullable|string|max:2000',
            'whatsapp_number' => 'nullable|string|max:50',
            'whatsapp_message' => 'nullable|string|max:1000',
            'whatsapp_enabled' => 'nullable|boolean',
            'footer_logo_file' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
        ], [
            'company_name.required' => 'Please enter the company name.',
            'company_name.max' => 'The company name cannot exceed 150 characters.',
            'copyright_text.required' => 'Please enter the copyright text.',
            'copyright_text.max' => 'The copyright text cannot exceed 200 characters.',
            'email.email' => 'Please enter a valid email address.',
            'facebook_url.url' => 'Please enter a valid Facebook URL.',
            'instagram_url.url' => 'Please enter a valid Instagram URL.',
            'linkedin_url.url' => 'Please enter a valid LinkedIn URL.',
            'youtube_url.url' => 'Please enter a valid YouTube URL.',
            'twitter_url.url' => 'Please enter a valid Twitter/X URL.',
            'footer_logo_file.image' => 'The footer logo file must be a valid image.',
            'footer_logo_file.max' => 'The footer logo size must not exceed 2MB.',
        ]);

        $data['whatsapp_enabled'] = $request->has('whatsapp_enabled') ? 1 : 0;

        if ($request->hasFile('footer_logo_file')) {
            if ($path = $this->uploadImage($request->file('footer_logo_file'))) {
                $data['footer_logo'] = $path;
            }
        }
        unset($data['footer_logo_file']);

        FooterSetting::query()->updateOrCreate(['id' => 1], $data);

        return back()->with('success', 'Footer settings updated successfully.');
    }
}
