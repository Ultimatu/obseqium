<?php

namespace App\Http\Controllers;

use App\Models\Pricing;

class PricingController extends Controller
{
    public function __invoke()
    {
        $pricing = Pricing::default()->active()->first();

        if (! $pricing) {
            $pricing = Pricing::factory()->default()->make();
        }

        return view('pages.pricing', compact('pricing'));
    }
}
