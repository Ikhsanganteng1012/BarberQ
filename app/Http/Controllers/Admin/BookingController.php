<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::query()
            ->with(['user', 'service'])
            ->orderByDesc('id')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking): View
    {
        $booking->load(['user', 'service']);

        return view('admin.bookings.show', [
            'booking' => $booking,
            'barber' => config('barbershop'),
        ]);
    }

    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled'],
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Status booking diperbarui.');
    }

    public function updatePayment(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'payment_status' => ['required', 'in:pending,paid'],
            'payment_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $booking->update([
            'payment_status' => $validated['payment_status'],
            'payment_note' => $validated['payment_note'] ?? $booking->payment_note,
        ]);

        return back()->with('success', 'Data pembayaran diperbarui.');
    }
}
