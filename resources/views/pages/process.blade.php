<x-layouts.app title="Notre processus d'accompagnement">

    <!-- Hero -->
    <div class="bg-gradient-to-br from-brand-950 to-brand-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-brand-300 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white">Accueil</a>
                <span class="mx-2">/</span>
                <span class="text-brand-100">Notre processus</span>
            </nav>
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm font-medium mb-6">
                    <span class="w-2 h-2 bg-brand-300 rounded-full animate-pulse"></span>
                    Méthodologie OBSEQUIUM — 9 phases progressives
                </div>
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">Notre processus d'accompagnement</h1>
                <p class="text-xl text-brand-100 leading-relaxed mb-2">
                    De l'évaluation initiale gratuite jusqu'à la préparation de l'audit de certification, nous structurons votre projet en 9 phases progressives.
                </p>
                <p class="text-brand-200">
                    <strong class="text-white">Durée estimée :</strong> 6 à 12 mois selon la taille, la complexité et l'urgence.
                </p>
            </div>
        </div>
    </div>

    <!-- Free diagnostic banner -->
    <section class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <p class="text-sm uppercase tracking-wider opacity-90">Phase 1</p>
                    <p class="text-2xl font-bold">Audit diagnostic 100% gratuit, sans engagement</p>
                </div>
            </div>
            <a href="{{ route('quotes.request') }}" class="inline-flex items-center gap-2 bg-white text-emerald-700 hover:bg-emerald-50 font-semibold px-6 py-3 rounded-xl transition-colors shadow-lg whitespace-nowrap">
                Demander mon diagnostic
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </section>

    <!-- Timeline -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative">
                {{-- Vertical line with draw animation --}}
                <div class="timeline-line absolute left-6 sm:left-8 top-0 bottom-0 w-0.5" aria-hidden="true"></div>

                @foreach($phases as $i => $phase)
                <div class="relative pl-16 sm:pl-24 pb-12 last:pb-0" data-animate="fade-up" data-delay="{{ $i * 60 }}">
                    {{-- Number bubble with pulse animation on first --}}
                    <div class="absolute left-0 top-0 w-12 h-12 sm:w-16 sm:h-16 rounded-full {{ $phase->order === 1 ? 'bg-emerald-500 timeline-bubble-pulse' : 'bg-brand-600' }} text-white flex items-center justify-center shadow-lg ring-4 ring-white z-10 transition-transform hover:scale-110">
                        <span class="text-xl sm:text-2xl font-bold">{{ $phase->order }}</span>
                    </div>

                    {{-- Card with lift effect --}}
                    <div class="card-lift bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 hover:border-brand-200">
                        <div class="flex flex-wrap items-center gap-3 mb-3">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $phase->title }}</h2>
                            @if(!empty($phase->badge))
                            <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full overflow-hidden relative">
                                <span class="badge-shimmer absolute inset-0"></span>
                                <svg class="w-3.5 h-3.5 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span class="relative z-10">{{ $phase->badge }}</span>
                            </span>
                            @endif
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-4">{{ $phase->description }}</p>
                        @if(!empty($phase->highlights))
                        <div class="flex flex-wrap gap-2">
                            @foreach($phase->highlights as $j => $hl)
                            <span class="highlight-float inline-flex items-center gap-1.5 bg-brand-50 text-brand-700 text-xs font-medium px-3 py-1.5 rounded-full" style="animation-delay: {{ $j * 0.2 }}s">
                                <span class="w-1.5 h-1.5 bg-brand-500 rounded-full"></span>
                                {{ is_array($hl) ? ($hl['highlight'] ?? '') : $hl }}
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

    <!-- CTA -->
    <section class="py-16 bg-brand-600 relative overflow-hidden">
        {{-- Animated background elements --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-48 h-48 bg-white rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10" data-animate="zoom-in">
            <h2 class="text-3xl font-bold text-white mb-4">Prêt à démarrer votre certification ISO ?</h2>
            <p class="text-brand-100 mb-8 text-lg">La première phase est gratuite. Vous repartez avec un rapport et un plan d'action — quelle que soit votre décision.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('diagnostic.request') }}" class="group inline-flex items-center gap-2 bg-white text-brand-700 hover:bg-brand-50 font-semibold px-8 py-3 rounded-xl transition-all shadow-lg hover:shadow-xl hover:scale-105">
                    Demander mon diagnostic gratuit
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 border border-white/40 text-white hover:bg-white/10 font-semibold px-8 py-3 rounded-xl transition-colors hover:border-white/60">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
