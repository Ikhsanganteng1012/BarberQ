<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::where('is_active', true)->paginate(12);
        return view('services.index', ['services' => $services]);
    }

    public function show(Service $service): View
    {
        $relatedServices = Service::where('is_active', true)
            ->where('id', '!=', $service->id)
            ->take(3)
            ->get();

        return view('services.show', [
            'service' => $service,
            'relatedServices' => $relatedServices,
        ]);
    }
}