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
        'midtrans_order_id',
        'snap_token',
        'transaction_id',
        'transaction_status',
        'payment_type',
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
    const METHOD_MIDTRANS = 'midtrans';

    public static function generateUniqueQueueCode(): string
    {
        do {
            $code = 'BRB-'.strtoupper(Str::random(8));
        } while (self::query()->where('queue_code', $code)->exists());

        return $code;
    }

    public function markAsPaidFromMidtrans(array $data = []): void
    {
        $updates = [
            'payment_status' => self::PAYMENT_PAID,
            'payment_method' => self::METHOD_MIDTRANS,
            'transaction_id' => $data['transaction_id'] ?? $this->transaction_id,
            'transaction_status' => $data['transaction_status'] ?? $this->transaction_status,
            'payment_type' => $data['payment_type'] ?? $this->payment_type,
            'payment_note' => 'Pembayaran Midtrans ('.($data['transaction_status'] ?? 'success').')',
        ];

        if (! $this->queue_code) {
            $updates['queue_code'] = self::generateUniqueQueueCode();
        }

        $this->update($updates);
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