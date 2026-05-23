<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Project;
use App\Models\Service;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'blogs' => Blog::count(),
            'projects' => Project::count(),
            'services' => Service::count(),
        ]);
    }
}
