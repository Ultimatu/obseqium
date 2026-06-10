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

        $relatedServices = Service::active()
            ->where('id', '!=', $service->id)
            ->when($service->type, fn ($q, $type) => $q->where('type', $type))
            ->limit(3)
            ->get();

        return view('pages.services.show', [
            'service' => $service,
            'relatedServices' => $relatedServices,
            'title' => $service->meta_title ?: $service->title,
            'metaDescription' => $service->meta_description ?: $service->description,
            'ogType' => 'website',
            'ogImage' => $service->image ? asset('storage/'.$service->image) : null,
            'canonicalUrl' => route('services.show', $service->slug),
        ]);
    }
}
