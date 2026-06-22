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
        ], [
            'cost_per_kw.required' => 'Please enter the cost per kW.',
            'cost_per_kw.numeric' => 'The cost per kW must be a valid number.',
            'cost_per_kw.min' => 'The cost per kW must be at least 1.',
            'monthly_savings_rate.required' => 'Please enter the monthly savings rate.',
            'monthly_savings_rate.numeric' => 'The savings rate must be a valid number.',
            'monthly_savings_rate.min' => 'The savings rate cannot be negative.',
            'monthly_savings_rate.max' => 'The savings rate cannot exceed 5.',
            'co2_per_kw_year.required' => 'Please enter the CO2 reduction factor.',
            'co2_per_kw_year.numeric' => 'The CO2 reduction factor must be a valid number.',
            'co2_per_kw_year.min' => 'The CO2 factor cannot be negative.',
        ]);

        CalculatorSetting::query()->updateOrCreate(['id' => 1], [
            'cost_per_kw' => $data['cost_per_kw'],
            'monthly_savings_rate' => $data['monthly_savings_rate'],
            'co2_per_kw_year' => $data['co2_per_kw_year'],
        ]);

        City::query()->delete();
        $processed = [];
        foreach (array_filter(array_map('trim', explode("\n", $data['cities'] ?? ''))) as $line) {
            [$name, $factor] = array_pad(array_map('trim', explode('|', $line)), 2, 1);
            if (empty($name)) continue;
            
            $key = strtolower($name);
            if (isset($processed[$key])) continue;
            $processed[$key] = true;

            City::create(['name' => $name, 'sun_factor' => is_numeric($factor) ? $factor : 1]);
        }

        return back()->with('success', 'Calculator settings saved.');
    }
}
