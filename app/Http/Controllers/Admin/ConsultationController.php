<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\HairStyle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConsultationController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');
        $allowed = [Consultation::STATUS_PENDING, Consultation::STATUS_REPLIED, Consultation::STATUS_CLOSED];
        if (!in_array($status, $allowed, true)) {
            $status = Consultation::STATUS_PENDING;
        }

        $consultations = Consultation::query()
            ->with(['user', 'admin', 'recommendedHairStyle'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.consultations.index', [
            'consultations' => $consultations,
            'status' => $status,
        ]);
    }

    public function show(Consultation $consultation): View
    {
        $consultation->load(['user', 'admin', 'recommendedHairStyle']);
        $hairStyles = HairStyle::query()->where('is_active', true)->orderBy('name')->get();

        return view('admin.consultations.show', [
            'consultation' => $consultation,
            'hairStyles' => $hairStyles,
        ]);
    }

    public function reply(Request $request, Consultation $consultation): RedirectResponse
    {
        $validated = $request->validate([
            'admin_message' => ['required', 'string', 'max:2000'],
            'recommended_hair_style_id' => ['nullable', 'exists:hair_styles,id'],
            'status' => ['required', 'in:pending,replied,closed'],
        ]);

        $consultation->update([
            'admin_id' => auth()->id(),
            'admin_message' => $validated['admin_message'],
            'recommended_hair_style_id' => $validated['recommended_hair_style_id'] ?? null,
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Balasan tersimpan.');
    }
}

