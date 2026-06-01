@props([
    'title',
    'description'    => '',
    'primaryLabel'   => 'Demander mon diagnostic gratuit',
    'primaryRoute'   => 'diagnostic.request',
    'secondaryLabel' => 'Nous contacter',
    'secondaryRoute' => 'contact',
    'badge'          => 'Sans engagement • Réponse sous 24h',
    'py'             => 'py-16',
])

<section class="relative {{ $py }} bg-brand-700 overflow-hidden">

    {{-- Motif grille SVG décoratif --}}
    <div class="absolute inset-0 opacity-[0.07] pointer-events-none" aria-hidden="true">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="cta-grid-{{ md5($title) }}" x="0" y="0" width="32" height="32" patternUnits="userSpaceOnUse">
                    <path d="M0 32V0H32" fill="none" stroke="white" stroke-width="1" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#cta-grid-{{ md5($title) }})" />
        </svg>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10" data-animate="zoom-in">

        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-3">{{ $title }}</h2>

        @if($description)
            <p class="text-brand-100 mb-8 text-lg max-w-xl mx-auto leading-relaxed">{{ $description }}</p>
        @endif

        <div class="flex flex-wrap justify-center gap-4 @if($badge) mb-5 @endif">
            {{-- CTA principal --}}
            <a href="{{ route($primaryRoute) }}"
               class="group inline-flex items-center gap-2 bg-accent-600 hover:bg-accent-400 text-white font-semibold px-8 py-3.5 rounded-xl transition-all duration-150 shadow-lg hover:shadow-xl hover:scale-105">
                {{ $primaryLabel }}
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>

            {{-- CTA secondaire (optionnel) --}}
            @if($secondaryRoute)
                <a href="{{ route($secondaryRoute) }}"
                   class="inline-flex items-center gap-2 border border-white/40 text-white hover:bg-white/10 hover:border-white/60 font-semibold px-8 py-3.5 rounded-xl transition-all duration-150 hover:scale-105">
                    {{ $secondaryLabel }}
                </a>
            @endif
        </div>

        {{-- Badge discret --}}
        @if($badge)
            <p class="text-sm text-accent-400 tracking-wide">{{ $badge }}</p>
        @endif

        {{-- Slot optionnel pour contenu additionnel --}}
        {{ $slot }}

    </div>
</section>
