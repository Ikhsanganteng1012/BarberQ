<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class MidtransController extends Controller
{
    public function notification(Request $request, MidtransService $midtrans): JsonResponse
    {
        try {
            $midtrans->handleNotification();

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            Log::error('Midtrans notification error', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Error'], 500);
        }
    }

    public function finish(Booking $booking, MidtransService $midtrans): RedirectResponse
    {
        $midtrans->syncBookingStatus($booking);
        $booking->refresh();

        $url = URL::temporarySignedRoute(
            'booking.confirmation',
            now()->addDays(7),
            ['booking' => $booking]
        );

        if ($booking->payment_status === Booking::PAYMENT_PAID) {
            return redirect()->to($url)->with('success', 'Pembayaran berhasil! Barcode antrian Anda sudah tersedia.');
        }

        return redirect()->to($url)->with('error', 'Pembayaran belum selesai. Silakan coba lagi atau tunggu konfirmasi.');
    }

    public function unfinish(Booking $booking): RedirectResponse
    {
        $url = URL::temporarySignedRoute(
            'booking.confirmation',
            now()->addDays(7),
            ['booking' => $booking]
        );

        return redirect()->to($url)->with('error', 'Pembayaran belum selesai. Anda dapat melanjutkan pembayaran.');
    }

    public function error(Booking $booking): RedirectResponse
    {
        $url = URL::temporarySignedRoute(
            'booking.confirmation',
            now()->addDays(7),
            ['booking' => $booking]
        );

        return redirect()->to($url)->with('error', 'Terjadi kesalahan saat pembayaran. Silakan coba lagi.');
    }
}
