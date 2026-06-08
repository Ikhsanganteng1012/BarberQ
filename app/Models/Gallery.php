<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasPublicImage;

class Gallery extends Model
{
    use HasFactory, HasPublicImage;

    protected $fillable = ['title', 'description', 'image', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}