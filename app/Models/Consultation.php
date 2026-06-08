<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_REPLIED = 'replied';
    const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'user_id',
        'admin_id',
        'recommended_hair_style_id',
        'status',
        'selfie_path',
        'user_message',
        'admin_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function recommendedHairStyle()
    {
        return $this->belongsTo(HairStyle::class, 'recommended_hair_style_id');
    }
}

