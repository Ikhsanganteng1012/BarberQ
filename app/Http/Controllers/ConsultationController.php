<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConsultationController extends Controller
{
    public function index(): View
    {
        $consultations = Consultation::query()
            ->where('user_id', auth()->id())
            ->with(['admin'])
            ->latest()
            ->paginate(10);

        return view('consultations.index', [
            'consultations' => $consultations,
        ]);
    }

    public function create(): View
    {
        return view('consultations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'selfie' => ['required', 'image', 'max:5120'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $path = $request->file('selfie')->store('consultations', 'public');

        Consultation::create([
            'user_id' => auth()->id(),
            'status' => Consultation::STATUS_PENDING,
            'selfie_path' => $path,
            'user_message' => $validated['message'] ?? null,
        ]);

        return redirect()->route('consultations.index')->with('success', 'Konsultasi terkirim. Admin akan membalas secepatnya.');
    }

    public function show(Consultation $consultation): View
    {
        if ($consultation->user_id !== auth()->id()) {
            abort(403);
        }

        $consultation->load(['recommendedHairStyle', 'admin']);

        return view('consultations.show', [
            'consultation' => $consultation,
        ]);
    }
}

