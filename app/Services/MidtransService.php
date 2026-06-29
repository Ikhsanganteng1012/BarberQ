<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function configure(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = (bool) config('midtrans.is_production');
        Config::$isSanitized = (bool) config('midtrans.is_sanitized');
        Config::$is3ds = (bool) config('midtrans.is_3ds');
    }

    public function generateOrderId(Booking $booking): string
    {
        return 'BOOKING-'.$booking->id.'-'.time();
    }

    public function createSnapToken(Booking $booking): string
    {
        $this->configure();
        $booking->load('service');

        $orderId = $this->generateOrderId($booking);
        $amount = (int) round((float) $booking->amount);

        if ($amount < 1) {
            throw new \RuntimeException('Nominal pembayaran tidak valid.');
        }

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $booking->customer_name,
                'email' => $booking->customer_email,
                'phone' => $booking->guest_phone ?: '08123456789',
            ],
            'item_details' => [
                [
                    'id' => (string) $booking->service_id,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => substr($booking->service->name, 0, 50),
                ],
            ],
            'callbacks' => [
                'finish' => route('midtrans.finish', $booking),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $booking->update([
            'midtrans_order_id' => $orderId,
            'snap_token' => $snapToken,
            'payment_method' => Booking::METHOD_MIDTRANS,
        ]);

        return $snapToken;
    }

    public function isPaymentSuccess(?string $transactionStatus, ?string $fraudStatus = null): bool
    {
        if (! in_array($transactionStatus, ['capture', 'settlement'], true)) {
            return false;
        }

        if ($transactionStatus === 'capture' && $fraudStatus === 'challenge') {
            return false;
        }

        return true;
    }

    public function handleNotification(): void
    {
        $this->configure();

        $notification = new Notification();
        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status ?? null;
        $transactionId = $notification->transaction_id ?? null;
        $paymentType = $notification->payment_type ?? null;

        $booking = Booking::query()->where('midtrans_order_id', $orderId)->first();

        if (! $booking) {
            Log::warning('Midtrans notification: booking not found', ['order_id' => $orderId]);

            return;
        }

        $this->applyTransactionUpdate($booking, $transactionId, $transactionStatus, $paymentType, $fraudStatus);
    }

    public function syncBookingStatus(Booking $booking): Booking
    {
        if (! $booking->midtrans_order_id || $booking->payment_status === Booking::PAYMENT_PAID) {
            return $booking;
        }

        $this->configure();

        try {
            $status = Transaction::status($booking->midtrans_order_id);

            $this->applyTransactionUpdate(
                $booking,
                $status->transaction_id ?? null,
                $status->transaction_status ?? null,
                $status->payment_type ?? null,
                $status->fraud_status ?? null
            );
        } catch (\Exception $e) {
            Log::error('Midtrans status check failed', [
                'booking_id' => $booking->id,
                'order_id' => $booking->midtrans_order_id,
                'error' => $e->getMessage(),
            ]);
        }

        return $booking->fresh();
    }

    private function applyTransactionUpdate(
        Booking $booking,
        ?string $transactionId,
        ?string $transactionStatus,
        ?string $paymentType,
        ?string $fraudStatus
    ): void {
        $booking->update([
            'transaction_id' => $transactionId ?? $booking->transaction_id,
            'transaction_status' => $transactionStatus ?? $booking->transaction_status,
            'payment_type' => $paymentType ?? $booking->payment_type,
        ]);

        if ($this->isPaymentSuccess($transactionStatus, $fraudStatus)) {
            $booking->markAsPaidFromMidtrans([
                'transaction_id' => $transactionId,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
            ]);
        }
    }
}
