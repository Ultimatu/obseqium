<?php

namespace App\Http\Controllers;

use App\Models\Reference;

class ReferenceController
{
    public function __invoke()
    {
        $references = Reference::where('is_active', true)->orderBy('order')->get();

        return view('pages.references', compact('references'));
    }

    public function show(string $slug)
    {
        $reference = Reference::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('pages.reference-show', compact('reference'));
    }
}
