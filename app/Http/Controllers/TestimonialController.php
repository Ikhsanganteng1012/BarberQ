<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::where('is_approved', true)->latest()->paginate(9);

        return view('testimonials.index', ['testimonials' => $testimonials]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'max:5120'],
        ], [
            'rating.required' => 'Pilih rating bintang.',
            'message.required' => 'Tulis pengalaman Anda.',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'rating' => $validated['rating'],
            'message' => $validated['message'],
            'image' => $path,
            'is_approved' => false,
        ]);

        return redirect()
            ->route('testimonials.index')
            ->with('success', 'Terima kasih! Testimoni Anda dikirim dan menunggu persetujuan admin sebelum ditampilkan.');
    }
}
