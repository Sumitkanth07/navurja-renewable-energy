<?php

namespace App\Http\Controllers;

use App\Models\CalculatorSetting;
use App\Models\City;

class CalculatorController extends Controller
{
    public function index()
    {
        return view('public.calculator', [
            'cities' => City::orderBy('name')->get(),
            'settings' => CalculatorSetting::first(),
        ]);
    }
}
