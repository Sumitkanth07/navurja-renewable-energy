<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class CookieController extends Controller
{
    public function edit()
    {
        return view('admin.cookies.edit', [
            'settings' => (object) [
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
            'cookie_popup_title' => 'nullable|string|max:150',
            'cookie_popup_content' => 'nullable|string|max:400',
            'cookie_accept_text' => 'nullable|string|max:50',
            'cookie_reject_text' => 'nullable|string|max:50',
            'cookie_consent_expiry' => 'nullable|integer|min:1',
        ], [
            'cookie_popup_title.max' => 'The popup title cannot exceed 150 characters.',
            'cookie_popup_content.max' => 'The popup description content cannot exceed 400 characters.',
            'cookie_accept_text.max' => 'The accept button text cannot exceed 50 characters.',
            'cookie_reject_text.max' => 'The reject button text cannot exceed 50 characters.',
            'cookie_consent_expiry.integer' => 'The expiry days must be a number.',
            'cookie_consent_expiry.min' => 'The expiry days must be at least 1 day.',
        ]);

        $data['cookie_consent_enabled'] = $request->has('cookie_consent_enabled') ? '1' : '0';

        foreach (['cookie_consent_enabled', 'cookie_popup_title', 'cookie_popup_content', 'cookie_accept_text', 'cookie_reject_text', 'cookie_consent_expiry'] as $key) {
            Setting::putValue($key, $data[$key] ?? '');
        }

        return back()->with('success', 'Cookie Consent settings updated successfully.');
    }
}
