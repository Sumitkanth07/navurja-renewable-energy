<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Http\Request;

class FooterController extends Controller
{
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
            'copyright_text' => 'required|max:200',
        ], [
            'company_name.required' => 'Please enter the company name.',
            'company_name.max' => 'The company name cannot exceed 150 characters.',
            'copyright_text.required' => 'Please enter the copyright text.',
            'copyright_text.max' => 'The copyright text cannot exceed 200 characters.',
        ]);

        FooterSetting::query()->updateOrCreate(['id' => 1], $data);

        return back()->with('success', 'Footer settings updated successfully.');
    }
}
