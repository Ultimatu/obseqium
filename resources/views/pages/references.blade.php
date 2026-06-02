<x-layouts.app title="Nos références clients">

    {{-- HERO --}}
    <div class="relative overflow-hidden bg-brand-800 text-white py-8 sm:py-12">
        {{-- Grille de fond --}}
        <div class="absolute inset-0 opacity-[0.06] pointer-events-none" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="ref-grid" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40V0H40" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#ref-grid)" />
            </svg>
        </div>
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-white/5 pointer-events-none"
            aria-hidden="true"></div>
        <div class="absolute right-16 bottom-0 w-32 h-32 rounded-full bg-accent-600/20 pointer-events-none"
            aria-hidden="true"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-white/50 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white/80 transition-colors">Accueil</a>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-white/70">Références</span>
            </nav>

            {{-- Badge --}}
            <div
                class="inline-flex items-center gap-2 bg-accent-600/25 border border-accent-400/40 rounded-full px-4 py-1.5 text-sm text-accent-400 font-medium mb-2">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                Études de cas & Succès clients
            </div>

            <h1 class="text-xl sm:text-4xl font-bold leading-tight tracking-tight mb-1">
                Ils nous ont fait confiance
            </h1>
            <p class="text-white/70 leading-relaxed max-w-2xl text-base">
                Du secteur public aux grands groupes industriels, découvrez comment nous accompagnons des organisations
                exigeantes vers leurs certifications ISO.
            </p>

            {{-- Trust strip --}}
            <div class="flex flex-wrap gap-x-8 gap-y-2 mt-3 pt-4 border-t border-white/15">
                @php
                    $total = $references->count();
                    $sectors = $references->pluck('sector')->filter()->unique()->count();
                    $featured = $references->where('is_featured', true)->count();
                @endphp
                @foreach ([[$total . '+', 'Clients certifiés'], [$sectors . '+', 'Secteurs d\'activité'], ['100%', 'Taux de succès']] as [$stat, $label])
                    <span class="flex items-center gap-3 text-sm text-white/70">
                        <span class="text-white font-bold text-base">{{ $stat }}</span>
                        {{ $label }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- GRILLE DES RÉFÉRENCES --}}
    <div class="bg-obq-page min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

            @if ($references->isEmpty())
                {{-- État vide --}}
                <div class="bg-white rounded-2xl border border-brand-50 shadow-sm p-16 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-brand-50 mb-5">
                        <svg class="w-8 h-8 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-obq-anthracite mb-2">Aucune référence publiée</h2>
                    <p class="text-obq-muted">Nos études de cas seront bientôt disponibles.</p>
                </div>
            @else
                {{-- Références en vedette --}}
                @php
                    $featured = $references->where('is_featured', true);
                    $others = $references->where('is_featured', false);
                @endphp
                @if ($featured->count())
                    <div class="mb-8">
                        <div class="flex items-center gap-2 mb-6">
                            <span
                                class="inline-flex items-center gap-2 bg-accent-600/10 border border-accent-400/30 text-accent-700 font-semibold text-xs uppercase tracking-wider px-3 py-1.5 rounded-full">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                Études de cas à la une
                            </span>
                        </div>
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($featured as $reference)
                                @include('pages._reference-card', [
                                    'reference' => $reference,
                                    'featured' => true,
                                ])
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Autres références --}}
                @if ($others->count())
                    @if ($featured->count())
                        <div class="flex items-center gap-4 my-10">
                            <div class="flex-1 h-px bg-brand-100"></div>
                            <span class="text-xs font-semibold uppercase tracking-widest text-obq-muted">Toutes nos
                                références</span>
                            <div class="flex-1 h-px bg-brand-100"></div>
                        </div>
                    @endif
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($others as $reference)
                            @include('pages._reference-card', [
                                'reference' => $reference,
                                'featured' => false,
                            ])
                        @endforeach
                    </div>
                @endif

            @endif
        </div>
    </div>

    {{-- CTA --}}
    <x-cta-banner title="Votre projet pourrait être notre prochaine référence"
        description="Discutons de vos enjeux QHSE et construisons ensemble votre parcours vers la certification."
        primaryLabel="Nous contacter" primaryRoute="contact" secondaryLabel="Demander un diagnostic"
        secondaryRoute="diagnostic.request" badge="Accompagnement personnalisé" py="py-20" />

</x-layouts.app>
