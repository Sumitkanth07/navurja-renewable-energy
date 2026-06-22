<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function edit()
    {
        return view('admin.location.edit', [
            'location' => Location::first() ?? new Location(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'office_name' => 'required|max:150',
            'address' => 'required|max:255',
            'city' => 'nullable|max:100',
            'state' => 'nullable|max:100',
            'country' => 'nullable|max:100',
            'pincode' => 'nullable|max:20',
            'phone' => 'nullable|max:40',
            'alt_phone' => 'nullable|max:40',
            'email' => 'nullable|email|max:100',
            'map_url' => 'nullable|string|max:2000',
            'latitude' => 'nullable|max:30',
            'longitude' => 'nullable|max:30',
            'working_hours' => 'nullable|max:150',
        ], [
            'office_name.required' => 'Please enter the office name.',
            'office_name.max' => 'The office name cannot exceed 150 characters.',
            'address.required' => 'Please enter the office address.',
            'address.max' => 'The office address cannot exceed 255 characters.',
            'email.email' => 'Please enter a valid email address.',
            'map_url.max' => 'The Google Maps URL/Embed Code cannot exceed 2000 characters.',
        ]);

        Location::updateOrCreate(['id' => 1], $data);

        return back()->with('success', 'Location settings updated successfully.');
    }
}
