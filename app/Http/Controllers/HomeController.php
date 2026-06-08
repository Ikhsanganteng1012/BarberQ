<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Gallery;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $services = Service::where('is_active', true)->take(6)->get();
        $testimonials = Testimonial::where('is_approved', true)->latest()->take(3)->get();
        $galleries = Gallery::where('is_active', true)->take(8)->get();

        return view('home', [
            'services' => $services,
            'testimonials' => $testimonials,
            'galleries' => $galleries,
        ]);
    }
}