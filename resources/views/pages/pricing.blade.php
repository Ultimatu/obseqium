<x-layouts.app :title="$pricing->hero_title">

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
            <nav class="flex items-center gap-1.5 text-xs text-brand-300 mb-8" aria-label="Fil d'Ariane">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Accueil</a>
                <svg class="w-3 h-3 text-brand-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-brand-100">{{ $pricing->hero_title }}</span>
            </nav>
            <div class="max-w-3xl">
                <h1 class="text-xl sm:text-4xl font-bold leading-tight tracking-tight">{{ $pricing->hero_title }}
                </h1>
                @if ($pricing->hero_description)
                    <p class="text-lg sm:text-lg text-brand-100 leading-relaxed max-w-2xl">
                        {{ $pricing->hero_description }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         PRINCIPE CLÉ — bandeau accent full-width
    ═══════════════════════════════════════════ --}}
    <section class="bg-brand-50 border-y border-brand-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">

                {{-- Icône --}}
                <div class="w-14 h-14 bg-accent-600 rounded-2xl flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>

                {{-- Séparateur vertical (desktop) --}}
                <div class="hidden sm:block w-px self-stretch bg-brand-200"></div>

                {{-- Contenu --}}
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-1">Principe clé</p>
                    <h2 class="text-xl sm:text-2xl font-bold text-brand-600 mb-2">
                        {{ $pricing->pricing_principle_title }}</h2>
                    @if ($pricing->pricing_principle_content)
                        <div class="prose prose-sm max-w-none text-obq-muted leading-relaxed">
                            {!! $pricing->pricing_principle_content !!}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         CRITÈRES DE TARIFICATION — grille de cards
    ═══════════════════════════════════════════ --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-animate="fade-up">
                <span class="text-xs font-semibold uppercase tracking-widest text-brand-500">Comment nous
                    chiffrons</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-3 mb-4">Critères de tarification</h2>
                <p class="text-gray-500 text-sm max-w-2xl mx-auto">{{ count($pricing->criteria ?? []) }} paramètres pris
                    en compte pour établir une cotation juste et précise.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($pricing->criteria ?? [] as $idx => $criterion)
                    <div data-animate="fade-up" data-delay="{{ $idx * 60 }}"
                        class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-1 hover:border-brand-200 transition-all duration-200">
                        <div
                            class="w-10 h-10 bg-linear-to-br from-brand-600 to-brand-800 rounded-full flex items-center justify-center mb-4 shadow-sm">
                            <span class="text-white font-bold text-sm">{{ $idx + 1 }}</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">{{ $criterion['title'] }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $criterion['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         MODALITÉS DE PAIEMENT — 2 colonnes
    ═══════════════════════════════════════════ --}}
    <section class="py-24 bg-gray-50 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <div data-animate="fade-right">
                    <span class="text-xs font-semibold uppercase tracking-widest text-brand-500">Paiement</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-3 mb-6">Modalités de paiement flexibles
                    </h2>
                    @if ($pricing->payment_terms)
                        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                            {!! $pricing->payment_terms !!}
                        </div>
                    @endif
                </div>
                <div data-animate="fade-left" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <p class="text-xs font-semibold uppercase tracking-widest text-brand-500 mb-3">Exemple chiffré</p>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">
                        Pour une mission de <strong
                            class="text-gray-900">{{ number_format($pricing->example_total_amount, 0, ',', ' ') }}
                            FCFA</strong>
                        sur <strong class="text-gray-900">{{ $pricing->example_duration_months }} mois</strong>,
                        paiement mensuel de :
                    </p>
                    <div
                        class="bg-linear-to-br from-brand-600 to-brand-800 rounded-xl p-8 text-white text-center shadow-lg">
                        <p class="text-5xl sm:text-6xl font-bold tracking-tight">
                            {{ number_format($pricing->monthly_amount, 0, ',', ' ') }}</p>
                        <p class="text-brand-200 mt-2 font-medium">FCFA / mois</p>
                        <div class="mt-4 pt-4 border-t border-white/20">
                            <span class="text-sm text-brand-200">Durée : {{ $pricing->example_duration_months }}
                                mois</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-4 italic">Exemple illustratif. Le montant final dépend de votre
                        contexte et des résultats du diagnostic.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         INCLUS / EXCLUS — cartes avec en-tête coloré
    ═══════════════════════════════════════════ --}}
    <section class="py-24 bg-obq-page">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-12" data-animate="fade-up">
                <span class="text-xs font-semibold uppercase tracking-widest text-accent-600">Transparence totale</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-brand-600 mt-3 mb-3">Ce que comprend votre devis</h2>
                <p class="text-obq-muted max-w-xl mx-auto text-sm">Un cadrage clair dès le départ pour éviter toute
                    surprise en cours de mission.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- INCLUS --}}
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-brand-50 card-lift"
                    data-animate="fade-right">
                    <div class="bg-accent-600 px-8 py-5 flex items-center gap-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Inclus dans l'offre</h3>
                    </div>
                    <ul class="divide-y divide-brand-50 px-8 py-2">
                        @foreach ($pricing->includes ?? [] as $item => $detail)
                            <li class="flex items-start gap-3 py-4">
                                <span
                                    class="mt-0.5 w-5 h-5 rounded-full bg-accent-50 flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-accent-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <div>
                                    <span class="text-obq-anthracite font-medium text-sm">{{ $item }}</span>
                                    @if ($detail)
                                        <p class="text-xs text-obq-muted mt-0.5 leading-relaxed">{{ $detail }}
                                        </p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- EXCLUSIONS --}}
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-brand-50 card-lift"
                    data-animate="fade-left">
                    <div class="bg-brand-600 px-8 py-5 flex items-center gap-3">
                        <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Exclusions</h3>
                    </div>
                    <ul class="divide-y divide-brand-50 px-8 py-2">
                        @foreach ($pricing->excludes ?? [] as $item => $detail)
                            <li class="flex items-start gap-3 py-4">
                                <span
                                    class="mt-0.5 w-5 h-5 rounded-full bg-brand-50 flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-brand-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <div>
                                    <span class="text-obq-anthracite font-medium text-sm">{{ $item }}</span>
                                    @if ($detail)
                                        <p class="text-xs text-obq-muted mt-0.5 leading-relaxed">{{ $detail }}
                                        </p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="px-8 pb-6">
                        <p class="text-xs text-obq-muted italic border-t border-brand-50 pt-4">Ces éléments restent à
                            la charge du client et sont gérés en toute transparence dès la phase de cadrage.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         PROCESSUS DE COMMANDE — stepper connecté
    ═══════════════════════════════════════════ --}}
    <section class="py-24 bg-gray-50 border-y border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-animate="fade-up">
                <span class="text-xs font-semibold uppercase tracking-widest text-brand-500">De A à Z</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-3 mb-4">Processus de passation de commande
                </h2>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-start">
                @foreach ($pricing->process_steps ?? [] as $idx => $step)
                    @if (!$loop->first)
                        {{-- Connecteur vertical (mobile) --}}
                        <div class="sm:hidden ml-5 h-8 border-l-2 border-dashed border-brand-200"></div>
                        {{-- Connecteur horizontal (desktop) --}}
                        <div class="hidden sm:flex items-center self-start mt-5 w-10 shrink-0">
                            <div class="w-full border-t-2 border-dashed border-brand-200"></div>
                        </div>
                    @endif
                    <div data-animate="fade-up" data-delay="{{ $idx * 80 }}"
                        class="flex sm:flex-col items-start sm:items-center sm:flex-1 gap-4 sm:gap-3 sm:text-center">
                        <div
                            class="w-10 h-10 bg-brand-600 text-white rounded-full flex items-center justify-center font-bold shrink-0 shadow-sm z-10">
                            {{ $idx + 1 }}</div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-sm mb-1">{{ $step['title'] }}</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">{{ $step['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         REMISES DE LANCEMENT — card dégradé + badge pulsant
    ═══════════════════════════════════════════ --}}
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-linear-to-br from-brand-600 to-brand-800 rounded-2xl p-8 sm:p-12 text-white text-center shadow-xl"
                data-animate="zoom-in">
                <div
                    class="inline-flex items-center gap-2 bg-white/15 rounded-full px-4 py-1.5 text-sm font-medium mb-6 border border-white/20">
                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                    {{ $pricing->offer_title }}
                </div>
                @if ($pricing->offer_content)
                    <div class="prose prose-invert max-w-2xl mx-auto text-lg text-brand-100 leading-relaxed">
                        {!! $pricing->offer_content !!}
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- CTA FINAL --}}
    <x-cta-banner title="Obtenez votre cotation personnalisée"
        description="Le diagnostic est gratuit et sans engagement. Vous repartez avec un rapport et une estimation chiffrée."
        primaryLabel="Demander un diagnostic gratuit" primaryRoute="quotes.request" secondaryLabel="Nous contacter"
        secondaryRoute="contact" badge="Sans engagement • Réponse sous 24h" py="py-20" />

</x-layouts.app>
