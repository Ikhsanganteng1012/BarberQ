<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::query()->orderByDesc('id')->get();

        return view('admin.galleries.index', compact('galleries'));
    }

    public function create(): View
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['required', 'image', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $path = $request->file('image')->store('galleries', 'public');

        Gallery::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image' => $path,
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Item galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $path = $gallery->image;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galleries', 'public');
        }

        $gallery->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image' => $path,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri diperbarui.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri dihapus.');
    }
}
