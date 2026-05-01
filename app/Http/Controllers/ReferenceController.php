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
}
