<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Formation;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $staticRoutes = collect([
            ['url' => route('home'),             'priority' => '1.0',  'changefreq' => 'weekly'],
            ['url' => route('services.index'),   'priority' => '0.9',  'changefreq' => 'weekly'],
            ['url' => route('formations.index'), 'priority' => '0.9',  'changefreq' => 'weekly'],
            ['url' => route('formations.calendar'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('about'),            'priority' => '0.8',  'changefreq' => 'monthly'],
            ['url' => route('references'),       'priority' => '0.7',  'changefreq' => 'monthly'],
            ['url' => route('blog.index'),       'priority' => '0.8',  'changefreq' => 'daily'],
            ['url' => route('contact'),          'priority' => '0.7',  'changefreq' => 'yearly'],
            ['url' => route('quotes.request'),   'priority' => '0.7',  'changefreq' => 'yearly'],
            ['url' => route('appointments.book'), 'priority' => '0.7',  'changefreq' => 'yearly'],
        ]);

        $services = Service::active()->get()->map(fn ($s) => [
            'url' => route('services.show', $s->slug),
            'priority' => '0.8',
            'changefreq' => 'monthly',
            'lastmod' => $s->updated_at->toAtomString(),
        ]);

        $formations = Formation::active()->get()->map(fn ($f) => [
            'url' => route('formations.show', $f->slug),
            'priority' => '0.8',
            'changefreq' => 'weekly',
            'lastmod' => $f->updated_at->toAtomString(),
        ]);

        $posts = BlogPost::published()->latest('published_at')->get()->map(fn ($p) => [
            'url' => route('blog.show', $p->slug),
            'priority' => '0.7',
            'changefreq' => 'monthly',
            'lastmod' => ($p->updated_at ?? $p->published_at)->toAtomString(),
        ]);

        $urls = $staticRoutes->merge($services)->merge($formations)->merge($posts);

        $content = view('sitemap', compact('urls'))->render();

        return response($content, 200, ['Content-Type' => 'application/xml']);
    }
}
