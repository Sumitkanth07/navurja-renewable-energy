<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = ['key', 'title', 'subtitle', 'content', 'image', 'hero_image', 'extra'];
    protected $casts = ['extra' => 'array'];
}
