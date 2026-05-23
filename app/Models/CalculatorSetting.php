<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatorSetting extends Model
{
    protected $fillable = ['cost_per_kw', 'monthly_savings_rate', 'co2_per_kw_year'];
}
