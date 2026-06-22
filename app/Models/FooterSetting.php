<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    protected $fillable = [

        'company_name',

        'email',

        'phone',

        'address',

        'copyright_text',

        'facebook',

        'instagram',

        'linkedin',

        'whatsapp',

        'map_iframe',

    ];
}