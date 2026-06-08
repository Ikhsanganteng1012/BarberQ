<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class BookingController extends Controller
{
    private function bookingUrls(Booking $booking): array
    {
        return [
            'paymentAction' => URL::temporarySignedRoute(
                'booking.payment',
                now()->addDays(7),
                ['booking' => $booking]
            ),
            'proofAction' => URL::temporarySignedRoute(
                'booking.proof',
                now()->addDays(7),
                ['booking' => $booking]
            ),
            'printUrl' => URL::temporarySignedRoute(
                'booking.print',
                now()->addDays(7),
                ['booking' => $booking]
            ),
        ];
    }

    public function index(): View
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('booking.index', [
            'services' => $services,
            'prefill' => [
                'name' => old('name', auth()->user()?->name),
                'email' => old('email', auth()->user()?->email),
                'phone' => old('phone', ''),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:30',
            'service_id' => 'required|exists:services,id',
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'notes' => 'nullable|string|max:500',
        ], [
            'booking_date.after_or_equal' => 'Tanggal booking minimal hari ini.',
        ]);

        $service = Service::query()->findOrFail($validated['service_id']);

        $booking = DB::transaction(function () use ($validated, $service) {
            return Booking::create([
                'user_id' => auth()->id(),
                'guest_name' => auth()->guest() ? $validated['name'] : null,
                'guest_email' => auth()->guest() ? $validated['email'] : null,
                'guest_phone' => $validated['phone'],
                'service_id' => $validated['service_id'],
                'booking_date' => $validated['booking_date'],
                'booking_time' => $validated['booking_time'],
                'notes' => $validated['notes'] ?? null,
                'status' => Booking::STATUS_PENDING,
                'queue_code' => null,
                'amount' => $service->price,
                'payment_status' => Booking::PAYMENT_PENDING,
            ]);
        });

        $url = URL::temporarySignedRoute(
            'booking.confirmation',
            now()->addDays(14),
            ['booking' => $booking]
        );

        return redirect()->to($url)->with('success', 'Booking berhasil dibuat!');
    }

    public function choosePayment(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'in:'.Booking::METHOD_QRIS.','.Booking::METHOD_BANK_TRANSFER],
        ]);

        $booking->update([
            'payment_method' => $validated['payment_method'],
        ]);

        return redirect()->to(
            URL::temporarySignedRoute('booking.confirmation', now()->addDays(7), ['booking' => $booking])
        )->with('success', 'Metode pembayaran dipilih. Silakan lakukan pembayaran sesuai petunjuk.');
    }

    public function confirmation(Booking $booking): View
    {
        $booking->load(['service', 'user']);

        return view('booking.confirmation', array_merge([
            'booking' => $booking,
            'barber' => config('barbershop'),
        ], $this->bookingUrls($booking)));
    }

    public function myBookings(): View
    {
        $bookings = auth()->user()->bookings()->with('service')->latest()->paginate(10);
        return view('booking.my-bookings', ['bookings' => $bookings]);
    }

    public function show(Booking $booking): View
    {
        $this->authorize('view', $booking);
        $booking->load(['service', 'user']);

        return view('booking.confirmation', array_merge([
            'booking' => $booking,
            'barber' => config('barbershop'),
        ], $this->bookingUrls($booking)));
    }

    public function printBarcode(Booking $booking): View
    {
        if ($booking->payment_status !== Booking::PAYMENT_PAID || ! $booking->queue_code) {
            abort(403, 'Barcode antrian tersedia setelah pembayaran lunas.');
        }

        $booking->load(['service', 'user']);

        return view('booking.print-barcode', ['booking' => $booking]);
    }

    public function uploadProof(Request $request, Booking $booking): RedirectResponse
    {
        $request->validate([
            'payment_proof' => ['required', 'image', 'max:6144'],
        ], [
            'payment_proof.required' => 'Pilih file gambar bukti transfer.',
        ]);

        if ($booking->payment_proof_path) {
            Storage::disk('public')->delete($booking->payment_proof_path);
        }

        $path = $request->file('payment_proof')->store('booking-payment-proofs', 'public');

        $updates = [
            'payment_proof_path' => $path,
            'payment_status' => Booking::PAYMENT_PAID,
            'payment_note' => 'Diverifikasi otomatis setelah unggah bukti pembayaran.',
        ];

        if (! $booking->queue_code) {
            $updates['queue_code'] = Booking::generateUniqueQueueCode();
        }

        $booking->update($updates);

        return redirect()->to(
            URL::temporarySignedRoute('booking.confirmation', now()->addDays(7), ['booking' => $booking])
        )->with('success', 'Pembayaran berhasil! Barcode antrian Anda sudah tersedia.');
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        $this->authorize('delete', $booking);
        $booking->update(['status' => Booking::STATUS_CANCELLED]);
        return redirect()->route('bookings.my')->with('success', 'Booking dibatalkan!');
    }
}