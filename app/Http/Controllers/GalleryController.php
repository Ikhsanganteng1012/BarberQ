<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::where('is_active', true)->paginate(12);

        $galleryItems = $galleries->map(function ($gallery) {
            return [
                'image' => $gallery->image_url,
                'title' => $gallery->title,
                'description' => $gallery->description ?? '',
            ];
        })->values();

        return view('gallery.index', compact('galleries', 'galleryItems'));
    }
}