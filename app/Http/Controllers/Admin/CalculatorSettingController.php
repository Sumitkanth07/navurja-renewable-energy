<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalculatorSetting;
use App\Models\City;
use Illuminate\Http\Request;

class CalculatorSettingController extends Controller
{
    public function edit()
    {
        return view('admin.calculator.edit', ['settings' => CalculatorSetting::first(), 'cities' => City::orderBy('name')->get()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'cost_per_kw' => 'required|numeric|min:1',
            'monthly_savings_rate' => 'required|numeric|min:0|max:5',
            'co2_per_kw_year' => 'required|numeric|min:0',
            'cities' => 'nullable|string',
        ]);

        CalculatorSetting::query()->updateOrCreate(['id' => 1], [
            'cost_per_kw' => $data['cost_per_kw'],
            'monthly_savings_rate' => $data['monthly_savings_rate'],
            'co2_per_kw_year' => $data['co2_per_kw_year'],
        ]);
        City::query()->delete();
        foreach (array_filter(array_map('trim', explode("\n", $data['cities'] ?? ''))) as $line) {
            [$name, $factor] = array_pad(array_map('trim', explode('|', $line)), 2, 1);
            City::create(['name' => $name, 'sun_factor' => is_numeric($factor) ? $factor : 1]);
        }

        return back()->with('success', 'Calculator settings saved.');
    }
}
