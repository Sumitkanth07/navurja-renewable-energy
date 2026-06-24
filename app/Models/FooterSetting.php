<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'footer_logo',
        'footer_description',
        'email',
        'phone',
        'alternate_phone',
        'address',
        'copyright_text',
        'map_url',
        'whatsapp_number',
        'whatsapp_message',
        'whatsapp_enabled',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'twitter_url',
        // Retained old fields for safety/backwards compatibility
        'facebook',
        'instagram',
        'linkedin',
        'whatsapp',
        'map_iframe',
    ];
}