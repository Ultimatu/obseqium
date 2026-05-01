<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;

class AboutController
{
    public function __invoke()
    {
        $team = TeamMember::where('is_active', true)->orderBy('order')->get();

        return view('pages.about', compact('team'));
    }
}
