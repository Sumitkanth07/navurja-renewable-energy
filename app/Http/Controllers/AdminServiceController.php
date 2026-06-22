<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $service = new Service();

        return view('admin.services.form', compact('service'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {

            $data['image'] = $request
                ->file('image')
                ->store('uploads', 'public');

        }

        Service::create($data);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service created successfully');
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {

            $data['image'] = $request
                ->file('image')
                ->store('uploads', 'public');

        }

        $service->update($data);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return back()->with('success', 'Service deleted successfully');
    }
}