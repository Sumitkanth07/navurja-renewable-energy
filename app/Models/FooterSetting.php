<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = ['company_name', 'email', 'phone', 'address', 'copyright_text'];
}
