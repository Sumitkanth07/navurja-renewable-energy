<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'office_name', 'address', 'city', 'state', 'country', 'pincode',
        'phone', 'alt_phone', 'email', 'map_url', 'latitude', 'longitude', 'working_hours'
    ];
}
