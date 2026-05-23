<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index() { return view('admin.navigation.index', ['items' => NavigationItem::orderBy('sort_order')->get()]); }
    public function create() { return view('admin.navigation.form', ['item' => new NavigationItem()]); }
    public function edit(NavigationItem $navigation) { return view('admin.navigation.form', ['item' => $navigation]); }
    public function store(Request $request) { NavigationItem::create($this->data($request)); return redirect()->route('admin.navigation.index')->with('success', 'Navigation item saved.'); }
    public function update(Request $request, NavigationItem $navigation) { $navigation->update($this->data($request)); return redirect()->route('admin.navigation.index')->with('success', 'Navigation item updated.'); }
    public function destroy(NavigationItem $navigation) { $navigation->delete(); return back()->with('success', 'Navigation item deleted.'); }
    private function data(Request $request): array { $data = $request->validate(['label' => 'required|max:80', 'url' => 'required|max:255', 'sort_order' => 'nullable|integer']); $data['is_active'] = $request->boolean('is_active'); return $data; }
}
