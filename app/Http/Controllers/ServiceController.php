<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController
{
    public function index(Request $request)
    {
        $services = Service::active()
            ->when($request->type, fn ($q, $type) => $q->where('type', $type))
            ->get();

        return view('pages.services.index', compact('services'));
    }

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('pages.services.show', compact('service'));
    }
}
