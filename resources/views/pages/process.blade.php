<x-layouts.app title="Notre processus d'accompagnement">

    {{-- ═══════════════════════════════════════════
         HERO — dégradé diagonal + motif de points
    ═══════════════════════════════════════════ --}}
    <div
        class="relative overflow-hidden bg-linear-to-br from-brand-950 via-brand-800 to-brand-600 text-white py-8 sm:py-12">
        <div class="absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="hero-dots" x="0" y="0" width="24" height="24" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1.5" fill="white" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hero-dots)" />
            </svg>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-1.5 text-xs text-brand-300 mb-4" aria-label="Fil d'Ariane">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Accueil</a>
                <svg class="w-3 h-3 text-brand-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-brand-100">Notre processus</span>
            </nav>
            <div class="max-w-3xl">
                <h1 class="text-2xl sm:text-4xl font-bold leading-tight tracking-tight mb-2">Notre processus
                    d'accompagnement</h1>
                <p class="text-base sm:text-lg text-brand-100 leading-relaxed mb-4">
                    De l'évaluation initiale gratuite jusqu'à la préparation de l'audit de certification, nous
                    structurons votre projet en 9 phases progressives.
                </p>
                <p class="text-sm text-brand-200">
                    <strong class="text-white font-semibold">Durée estimée :</strong> 6 à 12 mois selon la taille, la
                    complexité et l'urgence.
                </p>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         BANDEAU DIAGNOSTIC GRATUIT
    ═══════════════════════════════════════════ --}}
    <section class="bg-linear-to-r from-gray-900 to-gray-600 text-white py-8 shadow-md">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center shrink-0 border border-white/20">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-emerald-100 mb-0.5">Phase 1</p>
                    <p class="text-xl sm:text-2xl font-bold leading-snug">Audit diagnostic 100% gratuit, sans engagement
                    </p>
                </div>
            </div>
            <a href="{{ route('quotes.request') }}"
                class="inline-flex items-center gap-2 bg-white text-[#96B857] hover:bg-emerald-50 font-semibold px-6 py-3.5 rounded-xl transition-all duration-150 shadow-lg hover:scale-105 whitespace-nowrap shrink-0">
                Demander mon diagnostic
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         TIMELINE — ligne verticale Tailwind uniquement
    ═══════════════════════════════════════════ --}}
    <section class="py-24 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative">
                {{-- Ligne verticale --}}
                <div class="absolute left-6 sm:left-8 top-0 bottom-0 w-0.5 bg-linear-to-b from-brand-300 via-brand-200 to-transparent"
                    aria-hidden="true"></div>

                @foreach ($phases as $i => $phase)
                    <div class="relative pl-16 sm:pl-24 pb-12 last:pb-0" data-animate="fade-up"
                        data-delay="{{ $i * 60 }}">

                        {{-- Bulle numérotée --}}
                        <div
                            class="absolute left-0 top-0 w-12 h-12 sm:w-16 sm:h-16 rounded-full {{ $phase->order === 1 ? 'bg-[#96B857]' : 'bg-brand-600' }} text-white flex items-center justify-center shadow-lg ring-4 ring-white z-10 transition-transform duration-200 hover:scale-110">
                            @if ($phase->order === 1)
                                <span class="absolute inset-0 rounded-full bg-[#96B857] animate-ping opacity-30"></span>
                            @endif
                            <span class="relative text-xl sm:text-2xl font-bold">{{ $phase->order }}</span>
                        </div>

                        {{-- Card --}}
                        <div
                            class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 hover:border-brand-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                            <div class="flex flex-wrap items-center gap-3 mb-3">
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $phase->title }}</h2>
                                @if (!empty($phase->badge))
                                    <span
                                        class="inline-flex items-center gap-1 bg-[#F0F4E8] text-[#96B857] text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $phase->badge }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-gray-600 leading-relaxed mb-4">{{ $phase->description }}</p>
                            @if (!empty($phase->highlights))
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($phase->highlights as $j => $hl)
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-brand-50 text-brand-700 text-xs font-medium px-3 py-1.5 rounded-full"
                                            data-delay="{{ $j * 80 }}">
                                            <span class="w-1.5 h-1.5 bg-brand-400 rounded-full shrink-0"></span>
                                            {{ is_array($hl) ? $hl['highlight'] ?? '' : $hl }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA FINAL --}}
    <x-cta-banner title="Prêt à démarrer votre certification ISO ?"
        description="La première phase est gratuite. Vous repartez avec un rapport et un plan d'action — quelle que soit votre décision."
        primaryLabel="Demander mon diagnostic gratuit" primaryRoute="diagnostic.request" secondaryLabel="Nous contacter"
        secondaryRoute="contact" badge="Sans engagement • Réponse sous 24h" py="py-16" />
</x-layouts.app>
