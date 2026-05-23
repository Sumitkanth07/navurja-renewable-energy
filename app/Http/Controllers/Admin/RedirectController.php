<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function index() { return view('admin.redirects.index', ['redirects' => Redirect::latest()->get()]); }
    public function create() { return view('admin.redirects.form', ['redirect' => new Redirect()]); }
    public function edit(Redirect $redirect) { return view('admin.redirects.form', compact('redirect')); }
    public function store(Request $request) { Redirect::create($this->data($request)); return redirect()->route('admin.redirects.index')->with('success', 'Redirect saved.'); }
    public function update(Request $request, Redirect $redirect) { $redirect->update($this->data($request)); return redirect()->route('admin.redirects.index')->with('success', 'Redirect updated.'); }
    public function destroy(Redirect $redirect) { $redirect->delete(); return back()->with('success', 'Redirect deleted.'); }
    private function data(Request $request): array { $data = $request->validate(['old_url' => 'required|max:255', 'new_url' => 'required|max:255', 'status_code' => 'required|in:301,302']); $data['old_url'] = '/'.ltrim($data['old_url'], '/'); $data['is_active'] = $request->boolean('is_active'); return $data; }
}
