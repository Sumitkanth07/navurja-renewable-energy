@extends('layouts.site')
@section('title','Energy Savings Calculator - Navurja')
@section('content')
<main class="calculator-page">
    <section class="calc-hero">
        <div class="calc-intro">
            <span class="eyebrow">Calculator</span>
            <h1>Energy Savings Calculator</h1>
            <p>Estimate renewable energy system size, savings, and CO2 reduction with a practical planning snapshot.</p>
        </div>
        <div class="calc-shell">
            <div class="calc-panel">
                <h2>Project Inputs</h2>
                <div class="calc-form">
                    <label>Monthly electricity bill<input id="bill" type="number" value="5000" min="0"></label>
                    <label>City<select id="city">@foreach($cities as $city)<option value="{{ $city->sun_factor }}">{{ $city->name }}</option>@endforeach</select></label>
                    <label>Roof size (sq ft)<input id="roof" type="number" value="600" min="0"></label>
                    <label>Monthly usage (units)<input id="usage" type="number" value="350" min="0"></label>
                </div>
            </div>
            <div class="results" data-rate="{{ $settings->monthly_savings_rate ?? 0.82 }}" data-co2="{{ $settings->co2_per_kw_year ?? 1.25 }}">
                <div class="result-card featured"><small>Estimated system size</small><strong id="system">0 kW</strong></div>
                <div class="result-card"><small>Monthly savings</small><strong id="monthly">Rs. 0</strong></div>
                <div class="result-card"><small>Annual savings</small><strong id="annual">Rs. 0</strong></div>
                <div class="result-card"><small>25-year savings</small><strong id="years">Rs. 0</strong></div>
                <div class="result-card"><small>CO2 reduction</small><strong id="co2">0 tons/year</strong></div>
            </div>
        </div>
    </section>
</main>
@endsection
