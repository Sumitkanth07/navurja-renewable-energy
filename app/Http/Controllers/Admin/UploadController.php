<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\StoresUploads;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    use StoresUploads;

    public function store(Request $request)
    {
        $request->validate(['file' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096']);
        $path = $this->uploadImage($request->file('file'));
        return response()->json(['location' => asset('storage/'.$path), 'path' => $path]);
    }
}
