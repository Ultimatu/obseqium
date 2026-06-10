<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController
{
    public function index(Request $request)
    {
        $formations = Formation::where('is_active', true)
            ->when($request->thematic, fn ($q, $t) => $q->where('thematic', $t))
            ->when($request->format, fn ($q, $f) => $q->where('format', $f))
            ->orderBy('is_featured', 'desc')
            ->orderBy('title')
            ->get();

        return view('pages.formations.index', compact('formations'));
    }

    public function show(string $slug)
    {
        $formation = Formation::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $sessions = $formation->sessions()->published()->orderBy('start_date')->get();

        return view('pages.formations.show', [
            'formation' => $formation,
            'sessions' => $sessions,
            'title' => $formation->meta_title ?: $formation->title,
            'metaDescription' => $formation->meta_description ?: $formation->description,
            'ogType' => 'website',
            'ogImage' => $formation->cover_image ? asset('storage/'.$formation->cover_image) : null,
            'canonicalUrl' => route('formations.show', $formation->slug),
        ]);
    }
}
