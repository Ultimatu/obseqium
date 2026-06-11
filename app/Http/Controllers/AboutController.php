<?php

namespace App\Http\Controllers;

use App\Models\User;

class AboutController
{
    public function __invoke()
    {
        $team = User::where('is_active', true)->whereNotNull('bio')->orderBy('order')->get();

        return view('pages.about', compact('team'));
    }
}
