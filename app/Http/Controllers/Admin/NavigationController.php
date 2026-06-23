<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index() { return view('admin.navigation.index', ['items' => NavigationItem::orderBy('sort_order')->get()]); }
    public function create() { 
        return view('admin.navigation.form', [
            'item' => new NavigationItem(),
            'pages' => \App\Models\Page::where('is_published', true)->orderBy('title')->get()
        ]); 
    }
    public function edit(NavigationItem $navigation) { 
        return view('admin.navigation.form', [
            'item' => $navigation,
            'pages' => \App\Models\Page::where('is_published', true)->orderBy('title')->get()
        ]); 
    }
    public function store(Request $request) { NavigationItem::create($this->data($request)); return redirect()->route('admin.navigation.index')->with('success', 'Navigation item saved.'); }
    public function update(Request $request, NavigationItem $navigation) { $navigation->update($this->data($request)); return redirect()->route('admin.navigation.index')->with('success', 'Navigation item updated.'); }
    public function destroy(NavigationItem $navigation) { $navigation->delete(); return back()->with('success', 'Navigation item deleted.'); }
    private function data(Request $request): array { 
        $data = $request->validate([
            'label' => 'required|max:80', 
            'url' => 'required|max:255', 
            'sort_order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:navigation_items,id',
            'menu_position' => 'required|in:header,footer'
        ], [
            'label.required' => 'Please enter the navigation label/name.',
            'label.max' => 'The navigation label cannot exceed 80 characters.',
            'url.required' => 'Please select a page or enter a custom link.',
            'url.max' => 'The URL cannot exceed 255 characters.',
            'sort_order.integer' => 'Sort order must be a valid number.',
            'menu_position.required' => 'Please select a menu position (Header or Footer).',
            'menu_position.in' => 'Invalid menu position selected.',
        ]); 
        $data['is_active'] = $request->has('is_active'); 
        return $data; 
    }
}
