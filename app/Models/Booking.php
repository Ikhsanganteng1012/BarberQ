<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'service_id',
        'booking_date',
        'booking_time',
        'notes',
        'status',
        'queue_code',
        'payment_method',
        'payment_status',
        'amount',
        'payment_note',
        'payment_proof_path',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'amount' => 'decimal:2',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';

    const METHOD_QRIS = 'qris';
    const METHOD_BANK_TRANSFER = 'bank_transfer';

    public static function generateUniqueQueueCode(): string
    {
        do {
            $code = 'BRB-'.strtoupper(Str::random(8));
        } while (self::query()->where('queue_code', $code)->exists());

        return $code;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getCustomerNameAttribute(): string
    {
        return $this->user?->name ?? (string) ($this->guest_name ?? '—');
    }

    public function getCustomerEmailAttribute(): string
    {
        return $this->user?->email ?? (string) ($this->guest_email ?? '—');
    }
}