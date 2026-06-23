@extends('layouts.site')
@section('title','Premium Energy Savings Calculator - Navurja')
@section('content')
<style>
    .calculator-hero {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: #fff;
        padding: 80px 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .calculator-hero::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        top: -100px;
        left: -100px;
    }
    .calculator-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
        line-height: 1.2;
    }
    .calculator-hero p {
        font-size: 1.25rem;
        max-width: 700px;
        margin: 0 auto;
        opacity: 0.95;
        line-height: 1.6;
    }
    .calc-layout {
        max-width: 1200px;
        margin: -50px auto 60px;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
        position: relative;
        z-index: 2;
    }
    @media (min-width: 992px) {
        .calc-layout {
            grid-template-columns: 1.1fr 0.9fr;
        }
    }
    .card-premium {
        background: var(--surface);
        border-radius: 24px;
        padding: 40px;
        box-shadow: var(--shadow);
        border: 1px solid var(--line);
        position: relative;
        color: var(--ink);
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 25px;
        color: var(--ink);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .card-title svg {
        color: var(--primary);
        width: 24px;
        height: 24px;
    }
    .input-group {
        margin-bottom: 24px;
    }
    .input-group label {
        display: block;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--muted);
        margin-bottom: 8px;
    }
    .input-wrapper {
        position: relative;
    }
    .input-wrapper input, .input-wrapper select {
        width: 100%;
        padding: 16px 20px 16px 48px;
        border: 2px solid var(--line);
        border-radius: 12px;
        font-size: 1.05rem;
        color: var(--ink);
        background: var(--surface-soft);
        transition: all 0.3s ease;
        box-sizing: border-box;
    }
    .input-wrapper input:focus, .input-wrapper select:focus {
        border-color: var(--primary);
        background: var(--surface);
        box-shadow: 0 0 0 5px rgba(12, 107, 63, 0.15);
        outline: none;
    }
    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        display: flex;
        align-items: center;
        pointer-events: none;
    }
    .input-icon svg {
        width: 20px;
        height: 20px;
    }
    .btn-calculate {
        width: 100%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: #fff;
        border: none;
        padding: 18px;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(12, 107, 63, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }
    .btn-calculate:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(12, 107, 63, 0.3);
        filter: brightness(1.05);
    }
    .btn-calculate:active {
        transform: translateY(0);
    }
    .results-panel {
        display: flex;
        flex-direction: column;
        gap: 24px;
        position: relative;
    }
    .result-hero-card {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        color: #fff;
        border-radius: 24px;
        padding: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.15);
    }
    .result-hero-card::before {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, var(--secondary) 0%, transparent 70%);
        top: -50px;
        right: -50px;
        opacity: 0.3;
    }
    .result-hero-card small {
        display: block;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #94a3b8;
        margin-bottom: 8px;
        font-weight: 700;
    }
    .result-hero-card strong {
        font-size: 3rem;
        font-weight: 800;
        color: #fff;
        display: block;
        line-height: 1.1;
    }
    .result-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .result-subcard {
        background: var(--surface);
        border-radius: 20px;
        padding: 24px;
        border: 1px solid var(--line);
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .result-subcard:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow);
    }
    .result-subcard small {
        display: block;
        font-size: 0.8rem;
        text-transform: uppercase;
        color: var(--muted);
        letter-spacing: 1px;
        margin-bottom: 8px;
        font-weight: 600;
    }
    .result-subcard strong {
        font-size: 1.45rem;
        color: var(--ink);
        font-weight: 700;
        line-height: 1.2;
    }
    .result-subcard.savings strong {
        color: var(--primary);
    }
    .result-subcard.co2 strong {
        color: var(--secondary);
    }
    .results-overlay {
        position: absolute;
        inset: 0;
        background: var(--bg);
        opacity: 0.9;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 50;
        border-radius: 24px;
        transition: opacity 0.3s ease;
        opacity: 0;
    }
    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid rgba(12, 107, 63, 0.1);
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 0.8s infinite linear;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .related-section {
        max-width: 1200px;
        margin: 60px auto 80px;
        padding: 0 20px;
    }
    .related-section h2 {
        font-size: 2.25rem;
        margin-bottom: 12px;
        text-align: center;
        font-weight: 800;
        color: var(--ink);
    }
    .related-section p.subtitle {
        text-align: center;
        color: var(--muted);
        font-size: 1.1rem;
        margin-bottom: 40px;
    }
    .related-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 25px;
    }
    @media (min-width: 768px) {
        .related-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    .related-card {
        background: var(--surface);
        border-radius: 20px;
        padding: 30px;
        border: 1px solid var(--line);
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        text-decoration: none;
        color: var(--ink);
        display: flex;
        flex-direction: column;
    }
    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
        border-color: var(--primary);
    }
    .related-card .icon-badge {
        width: 48px;
        height: 48px;
        background: rgba(12, 107, 63, 0.08);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        color: var(--primary);
    }
    .related-card h3 {
        font-size: 1.25rem;
        margin-bottom: 12px;
        font-weight: 700;
        color: var(--ink);
    }
    .related-card p {
        font-size: 0.95rem;
        color: var(--muted);
        line-height: 1.5;
    }
    .faq-section {
        max-width: 850px;
        margin: 60px auto 100px;
        padding: 0 20px;
    }
    .faq-section h2 {
        font-size: 2.25rem;
        margin-bottom: 12px;
        text-align: center;
        font-weight: 800;
        color: var(--ink);
    }
    .faq-section p.subtitle {
        text-align: center;
        color: var(--muted);
        font-size: 1.1rem;
        margin-bottom: 45px;
    }
    .faq-item {
        background: var(--surface);
        border-radius: 16px;
        margin-bottom: 15px;
        box-shadow: var(--shadow);
        border: 1px solid var(--line);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .faq-item:hover {
        border-color: var(--primary);
    }
    .faq-item summary {
        padding: 24px;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        list-style: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--ink);
        user-select: none;
    }
    .faq-item summary::-webkit-details-marker {
        display: none;
    }
    .faq-item summary::after {
        content: '+';
        font-size: 1.5rem;
        color: var(--primary);
        font-weight: 400;
        transition: transform 0.3s ease;
    }
    .faq-item[open] summary::after {
        content: '−';
    }
    .faq-content {
        padding: 0 24px 24px;
        color: var(--muted);
        line-height: 1.6;
        font-size: 0.98rem;
        border-top: 1px solid var(--line);
        margin-top: -1px;
    }
</style>

<div class="calculator-hero">
    <h1>Energy Savings Calculator</h1>
    <p>Estimate your optimal solar system size, projected savings, and environmental footprint in seconds with our smart modeling tool.</p>
</div>

<div class="calc-layout">
    <!-- Input Panel -->
    <div class="card-premium">
        <h2 class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            Project Inputs
        </h2>
        <div class="input-group">
            <label for="bill">Average Monthly Electricity Bill (Rs.)</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M12 8v8M8 12h8"/></svg>
                </span>
                <input id="bill" type="number" value="5000" min="0">
            </div>
        </div>
        <div class="input-group">
            <label for="city">City & Sun Exposure Factor</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </span>
                <select id="city">
                    @foreach($cities as $city)
                        <option value="{{ $city->sun_factor }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="input-group">
            <label for="roof">Available Roof Size (sq. ft)</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </span>
                <input id="roof" type="number" value="600" min="0">
            </div>
        </div>
        <div class="input-group">
            <label for="usage">Average Monthly Usage (units/kWh)</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                </span>
                <input id="usage" type="number" value="350" min="0">
            </div>
        </div>
        
        <button id="calculate-btn" class="btn-calculate">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            Calculate Savings
        </button>
    </div>

    <!-- Results Panel -->
    <div class="results results-panel" id="results-section" data-rate="{{ $settings->monthly_savings_rate ?? 0.82 }}" data-co2="{{ $settings->co2_per_kw_year ?? 1.25 }}">
        <!-- Calculation Overlay Loader -->
        <div class="results-overlay" id="calc-loader" style="display: none;">
            <div class="spinner"></div>
        </div>

        <div class="result-hero-card">
            <small>Recommended System Size</small>
            <strong id="system">0 kW</strong>
        </div>
        <div class="result-grid">
            <div class="result-subcard savings">
                <small>Monthly Savings</small>
                <strong id="monthly">Rs. 0</strong>
            </div>
            <div class="result-subcard savings">
                <small>Annual Savings</small>
                <strong id="annual">Rs. 0</strong>
            </div>
            <div class="result-subcard savings">
                <small>25-Year Savings</small>
                <strong id="years">Rs. 0</strong>
            </div>
            <div class="result-subcard co2">
                <small>CO₂ Reduction</small>
                <strong id="co2">0 tons/year</strong>
            </div>
        </div>
    </div>
</div>

<!-- Related Calculators Section -->
<div class="related-section">
    <h2>Explore Other Planning Tools</h2>
    <p class="subtitle">Gain deeper insights into your renewable energy ROI with our additional tools</p>
    <div class="related-grid">
        <div class="related-card">
            <div class="icon-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="9" x2="15" y2="15"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
            </div>
            <h3>Solar Panel Count Calculator</h3>
            <p>Determine exactly how many solar panels are required to fit your roof configuration and fulfill your annual consumption goals.</p>
        </div>
        <div class="related-card">
            <div class="icon-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <h3>Payback Period Estimator</h3>
            <p>Calculate the timeline required to break even on your initial solar panel installation investment based on current utility pricing.</p>
        </div>
        <div class="related-card">
            <div class="icon-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24"><rect x="2" y="7" width="20" height="10" rx="2" ry="2"/><line x1="22" y1="11" x2="22" y2="13"/><line x1="6" y1="11" x2="10" y2="11"/><line x1="14" y1="11" x2="18" y2="11"/></svg>
            </div>
            <h3>Battery Storage Sizing</h3>
            <p>Size a backup battery system to keep your essential appliances running smoothly during overnight hours and power outages.</p>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="faq-section">
    <h2>Frequently Asked Questions</h2>
    <p class="subtitle">Got questions about our calculator or solar options? We have answers.</p>
    
    <div class="faq-item">
        <details>
            <summary>How is the recommended solar system size calculated?</summary>
            <div class="faq-content">
                Our calculator assesses your average monthly bill, energy usage in units, roof space constraints, and the geographical sun factor of your city. It balances your electrical demands against your available roof space to suggest the most optimal, cost-efficient system size.
            </div>
        </details>
    </div>

    <div class="faq-item">
        <details>
            <summary>What is the Sun Exposure Factor?</summary>
            <div class="faq-content">
                The Sun Exposure Factor represents the average peak sun hours your specific city receives. Cities with higher exposure (like Jaipur or Ahmedabad) generate more power per kilowatt of installed solar than regions with lower exposure.
            </div>
        </details>
    </div>

    <div class="faq-item">
        <details>
            <summary>How much roof space is needed per kW of solar?</summary>
            <div class="faq-content">
                Typically, 1 kW of solar requires approximately 80 to 100 square feet of shadow-free, south-facing roof space. Our calculator limits recommendations if your available roof space is insufficient to support your energy usage requirements.
            </div>
        </details>
    </div>

    <div class="faq-item">
        <details>
            <summary>What are the environmental benefits of switching to solar?</summary>
            <div class="faq-content">
                Solar power is clean and emission-free. Every kilowatt of installed solar reduces CO₂ emissions by roughly 1 to 1.3 tons annually, offsetting fossil fuel generation and directly mitigating climate change.
            </div>
        </details>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calculateBtn = document.getElementById('calculate-btn');
        const calcLoader = document.getElementById('calc-loader');
        
        if (calculateBtn && calcLoader) {
            calculateBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Show loader with transition
                calcLoader.style.display = 'flex';
                setTimeout(() => {
                    calcLoader.style.opacity = '1';
                }, 10);
                
                setTimeout(function() {
                    // site.js naturally recalculates on change or run(),
                    // here we just simulate the loading experience and smooth scroll
                    calcLoader.style.opacity = '0';
                    setTimeout(() => {
                        calcLoader.style.display = 'none';
                    }, 300);
                    
                    if (window.innerWidth < 992) {
                        document.getElementById('results-section').scrollIntoView({ behavior: 'smooth' });
                    }
                }, 600);
            });
        }
    });
</script>
@endsection
