<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Formation;
use App\Models\Reference;
use App\Models\Service;
use App\Models\Testimonial;

class HomeController
{
    public function __invoke()
    {
        $services = Service::active()->take(6)->get();
        $formations = Formation::where('is_active', true)->where('is_featured', true)->take(3)->get();
        $testimonials = Testimonial::where('is_active', true)->where('is_featured', true)->orderBy('order')->take(4)->get();
        $references = Reference::where('is_active', true)->where('is_featured', true)->orderBy('order')->take(6)->get();
        $latestPosts = BlogPost::published()->with(['author', 'category'])->latest('published_at')->take(3)->get();

        return view('pages.home', compact('services', 'formations', 'testimonials', 'references', 'latestPosts'));
    }
}
