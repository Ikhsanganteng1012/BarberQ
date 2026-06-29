<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Consultation;
use App\Models\Service;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class BookingController extends Controller
{
    private function bookingUrls(Booking $booking): array
    {
        return [
            'midtransPayAction' => URL::temporarySignedRoute(
                'booking.midtrans.pay',
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

    public function index(Request $request): View
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();

        $prefill = [
            'name' => old('name', auth()->user()?->name),
            'email' => old('email', auth()->user()?->email),
            'phone' => old('phone', ''),
            'service_id' => old('service_id'),
            'notes' => old('notes'),
        ];

        $consultationContext = null;

        if ($request->filled('consultation')) {
            $consultation = Consultation::query()
                ->with('recommendedHairStyle')
                ->where('id', $request->consultation)
                ->where('user_id', auth()->id())
                ->first();

            if ($consultation && $consultation->admin_message) {
                if (! old('notes')) {
                    $prefill['notes'] = $this->bookingNotesFromConsultation($consultation);
                }

                if (! old('service_id')) {
                    $prefill['service_id'] = $this->defaultHaircutServiceId($services);
                }

                $consultationContext = $consultation;
            }
        }

        return view('booking.index', compact('services', 'prefill', 'consultationContext'));
    }

    private function bookingNotesFromConsultation(Consultation $consultation): string
    {
        $lines = [];

        if ($consultation->recommendedHairStyle) {
            $style = $consultation->recommendedHairStyle;
            $lines[] = 'Model rambut rekomendasi: '.$style->name;

            if ($style->description) {
                $lines[] = $style->description;
            }
        }

        if ($consultation->admin_message) {
            $lines[] = 'Catatan admin: '.$consultation->admin_message;
        }

        $lines[] = 'Referensi konsultasi #'.$consultation->id;

        return implode("\n\n", $lines);
    }

    private function defaultHaircutServiceId($services): ?int
    {
        $haircut = $services->first(function ($service) {
            return stripos($service->name, 'potong') !== false
                || stripos($service->name, 'haircut') !== false;
        });

        return $haircut?->id ?? $services->first()?->id;
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

        return redirect()->to($url)->with('success', 'Booking berhasil dibuat! Silakan lanjutkan pembayaran.');
    }

    public function payWithMidtrans(Booking $booking, MidtransService $midtrans): RedirectResponse
    {
        if ($booking->payment_status === Booking::PAYMENT_PAID) {
            return redirect()->to(
                URL::temporarySignedRoute('booking.confirmation', now()->addDays(7), ['booking' => $booking])
            )->with('error', 'Pembayaran sudah lunas.');
        }

        try {
            $token = $midtrans->createSnapToken($booking);
        } catch (\Exception $e) {
            return redirect()->to(
                URL::temporarySignedRoute('booking.confirmation', now()->addDays(7), ['booking' => $booking])
            )->with('error', 'Gagal membuat pembayaran Midtrans: '.$e->getMessage());
        }

        return redirect()->to(
            URL::temporarySignedRoute('booking.confirmation', now()->addDays(7), ['booking' => $booking])
        )->with('snap_token', $token);
    }

    public function confirmation(Booking $booking, MidtransService $midtrans): View
    {
        $booking->load(['service', 'user']);

        if ($booking->payment_status !== Booking::PAYMENT_PAID && $booking->midtrans_order_id) {
            $midtrans->syncBookingStatus($booking);
            $booking->refresh();
        }

        return view('booking.confirmation', array_merge([
            'booking' => $booking,
            'midtransClientKey' => config('midtrans.client_key'),
            'snapScriptUrl' => config('midtrans.snap_url'),
        ], $this->bookingUrls($booking)));
    }

    public function myBookings(): View
    {
        $bookings = auth()->user()->bookings()->with('service')->latest()->paginate(10);

        return view('booking.my-bookings', ['bookings' => $bookings]);
    }

    public function show(Booking $booking, MidtransService $midtrans): View
    {
        $this->authorize('view', $booking);
        $booking->load(['service', 'user']);

        if ($booking->payment_status !== Booking::PAYMENT_PAID && $booking->midtrans_order_id) {
            $midtrans->syncBookingStatus($booking);
            $booking->refresh();
        }

        return view('booking.confirmation', array_merge([
            'booking' => $booking,
            'midtransClientKey' => config('midtrans.client_key'),
            'snapScriptUrl' => config('midtrans.snap_url'),
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

    public function cancel(Booking $booking): RedirectResponse
    {
        $this->authorize('delete', $booking);
        $booking->update(['status' => Booking::STATUS_CANCELLED]);

        return redirect()->route('bookings.my')->with('success', 'Booking dibatalkan!');
    }
}
