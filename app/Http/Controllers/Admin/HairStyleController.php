<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HairStyle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HairStyleController extends Controller
{
    public function index(): View
    {
        $hairStyles = HairStyle::query()->orderByDesc('id')->paginate(15);

        return view('admin.hair-styles.index', [
            'hairStyles' => $hairStyles,
        ]);
    }

    public function create(): View
    {
        return view('admin.hair-styles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hair-styles', 'public');
        }

        HairStyle::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'image_path' => $path,
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('admin.hair-styles.index')->with('success', 'Model rambut berhasil dibuat.');
    }

    public function edit(HairStyle $hairStyle): View
    {
        return view('admin.hair-styles.edit', [
            'hairStyle' => $hairStyle,
        ]);
    }

    public function update(Request $request, HairStyle $hairStyle): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $path = $hairStyle->image_path;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hair-styles', 'public');
        }

        $hairStyle->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'image_path' => $path,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return back()->with('success', 'Model rambut berhasil diperbarui.');
    }
}

