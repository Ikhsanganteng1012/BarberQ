<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $bookingTotal = Booking::query()->count();
        $bookingPaid = Booking::query()->where('payment_status', Booking::PAYMENT_PAID)->count();
        $revenue = (float) Booking::query()->where('payment_status', Booking::PAYMENT_PAID)->sum('amount');
        $usersCount = User::query()->where('is_admin', false)->count();
        $servicesCount = Service::query()->where('is_active', true)->count();
        $testimonialsPending = Testimonial::query()->where('is_approved', false)->count();

        return view('admin.reports.index', compact(
            'bookingTotal',
            'bookingPaid',
            'revenue',
            'usersCount',
            'servicesCount',
            'testimonialsPending'
        ));
    }
}
