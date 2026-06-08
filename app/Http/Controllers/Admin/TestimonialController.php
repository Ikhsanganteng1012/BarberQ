<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::query()->with('user')->orderByDesc('id')->get();
        $pendingCount = $testimonials->where('is_approved', false)->count();

        return view('admin.testimonials.index', compact('testimonials', 'pendingCount'));
    }

    public function approve(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update(['is_approved' => true]);

        return back()->with('success', 'Testimoni disetujui dan akan tampil di website.');
    }

    public function reject(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update(['is_approved' => false]);

        return back()->with('success', 'Testimoni ditolak / disembunyikan dari website.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni dihapus.');
    }
}
