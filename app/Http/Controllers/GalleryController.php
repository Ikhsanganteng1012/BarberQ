<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::where('is_active', true)->paginate(12);
        return view('gallery.index', ['galleries' => $galleries]);
    }
}