<x-layouts.app title="Accueil">

    <!-- Hero Carousel -->
    <section class="relative text-white overflow-hidden min-h-150" x-data="{
        current: 0,
        total: {{ $heroSlides->count() }},
        timer: null,
        init() {
            this.startTimer();
        },
        startTimer() {
            clearInterval(this.timer);
            this.timer = setInterval(() => this.next(), 6000);
        },
        next() {
            this.current = (this.current + 1) % this.total;
            this.startTimer();
        },
        prev() {
            this.current = (this.current - 1 + this.total) % this.total;
            this.startTimer();
        },
        goTo(i) {
            this.current = i;
            this.startTimer();
        }
    }">
        {{-- ── Background slides ─────────────────────────────────── --}}
        @foreach ($heroSlides as $i => $slide)
            <div class="absolute inset-0 bg-linear-to-br {{ $slide->gradient }} transition-opacity duration-1000"
                x-bind:style="{
                    opacity: current === {{ $i }} ? '1' : '0',
                    'z-index': current === {{ $i }} ?
                        '1' : '0'
                }">
                @if ($slide->image)
                    <div class="absolute inset-0 bg-cover bg-center"
                        style="background-image:url('{{ Storage::url($slide->image) }}')"></div>
                    <div class="absolute inset-0 bg-linear-to-r from-black/85 via-black/65 to-black/35"></div>
                @endif
                {{-- Bottom fade for nav readability --}}
                <div class="absolute inset-x-0 bottom-0 h-40 bg-linear-to-t from-black/60 to-transparent"></div>
                {{-- SVG dot pattern --}}
                <div
                    class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.04\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]">
                </div>
            </div>
        @endforeach

        {{-- ── Slide content ─────────────────────────────────────── --}}
        <div class="relative py-20 sm:py-28 lg:py-20 pb-24 sm:pb-28 lg:pb-32" style="z-index:2">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">

                    {{-- Left: text (changes per slide) --}}
                    <div>
                        @foreach ($heroSlides as $i => $slide)
                            <div class="transition-all duration-700"
                                x-bind:style="{
                                    opacity: current === {{ $i }} ? '1' : '0',
                                    transform: current ===
                                        {{ $i }} ? 'translateY(0)' : 'translateY(20px)',
                                    position: current === {{ $i }} ? 'relative' : 'absolute',
                                    'pointer-events': current === {{ $i }} ? 'auto' : 'none'
                                }"
                                @if ($i > 0) style="position:absolute;opacity:0;pointer-events:none" @endif>
                                <div
                                    class="hero-enter inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/25 rounded-full px-4 py-2 text-xs font-semibold tracking-wider uppercase mb-8 shadow-sm">
                                    <span class="w-2 h-2 bg-brand-300 rounded-full animate-pulse"></span>
                                    {{ $slide->badge }}
                                </div>
                                <h1
                                    class="hero-enter text-4xl sm:text-3xl lg:text-2xl xl:text-5xl font-extrabold leading-[1.1] tracking-tight mb-6">
                                    {{ $slide->title }}
                                </h1>
                                <p class="hero-enter text-base sm:text-lg text-white/80 leading-relaxed mb-10 max-w-lg">
                                    {{ $slide->description }}
                                </p>
                                <div class="hero-enter flex flex-wrap gap-3 sm:gap-4">
                                    <a href="{{ $slide->cta_primary_href }}"
                                        class="inline-flex items-center gap-2 bg-white text-brand-700 hover:bg-brand-50 font-bold px-7 py-3.5 rounded-xl transition-all shadow-xl hover:shadow-2xl hover:-translate-y-0.5">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ $slide->cta_primary_label }}
                                    </a>
                                    <a href="{{ $slide->cta_secondary_href }}"
                                        class="inline-flex items-center gap-2 border border-white/40 bg-white/5 backdrop-blur-sm hover:bg-white/15 font-semibold px-7 py-3.5 rounded-xl transition-all">
                                        {{ $slide->cta_secondary_label }}
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Right: stats (static) --}}
                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                        @foreach ([[$siteSettings->get('stat_clients', '5'), $siteSettings->get('stat_clients_label', 'Organisations accompagnées')], [$siteSettings->get('stat_formations', '3'), $siteSettings->get('stat_formations_label', 'Normes ISO maîtrisées')], [$siteSettings->get('stat_years', '6-12'), $siteSettings->get('stat_years_label', "Mois d'accompagnement")], [$siteSettings->get('stat_satisfaction', '100%'), $siteSettings->get('stat_satisfaction_label', 'Audit diagnostic offert')]] as $idx => [$stat, $label])
                            <div class="hero-enter group bg-white/10 backdrop-blur-md rounded-2xl p-5 sm:p-6 text-center border border-white/20 hover:bg-white/15 hover:border-white/35 hover:scale-[1.03] transition-all duration-300 cursor-default"
                                style="animation-delay:{{ 0.6 + $idx * 0.1 }}s">
                                <div class="text-3xl sm:text-4xl font-extrabold text-white mb-1.5 tracking-tight">
                                    {{ $stat }}</div>
                                <div class="text-white/70 text-xs sm:text-sm font-medium leading-tight">
                                    {{ $label }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── Navigation ─────────────────────────────────────── --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-4" style="z-index:3">

                {{-- Prev --}}
                <button @click="prev()"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-white/20 backdrop-blur-sm border border-white/25 hover:bg-white/35 hover:scale-110 transition-all duration-200 shadow-lg"
                    aria-label="Précédent">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                {{-- Dots --}}
                <div class="flex items-center gap-2">
                    @foreach ($heroSlides as $i => $slide)
                        <button @click="goTo({{ $i }})" class="rounded-full transition-all duration-300"
                            x-bind:class="current === {{ $i }} ?
                                'w-8 h-2.5 bg-white shadow-[0_0_10px_rgba(255,255,255,0.6)]' :
                                'w-2.5 h-2.5 bg-white/30 hover:bg-white/60'"
                            aria-label="Slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>

                {{-- Next --}}
                <button @click="next()"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-white/20 backdrop-blur-sm border border-white/25 hover:bg-white/35 hover:scale-110 transition-all duration-200 shadow-lg"
                    aria-label="Suivant">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            {{-- Progress bar --}}
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-white/10" style="z-index:3">
                @foreach ($heroSlides as $i => $slide)
                    <div class="absolute top-0 left-0 h-full bg-white/70 transition-none"
                        x-bind:class="current === {{ $i }} ? 'hero-progress' : ''"
                        x-bind:style="current === {{ $i }} ? '' : 'width:0'"></div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        .hero-progress {
            width: 0;
            animation: heroProgress 6s linear forwards;
        }

        @keyframes heroProgress {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }
    </style>

    <!-- ═══ SERVICES ══════════════════════════════════════════════════ -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-14" data-animate="fade-up">
                <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Ce que nous faisons</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2 mb-4">Nos services QHSE</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Une offre complète pour répondre à tous vos besoins en
                    matière de qualité, hygiène, sécurité et environnement.</p>
            </div>

            <!-- 3 grandes catégories (toujours visibles) -->
            <div class="grid md:grid-cols-3 gap-6 mb-10">

                <a href="{{ route('services.index', ['type' => 'audit']) }}" data-animate="fade-up" data-delay="0"
                    style="background-color: var(--color-brand-600);"
                    class="group relative overflow-hidden rounded-2xl p-8 text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:brightness-110">
                    <div class="w-12 h-12 bg-white/15 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Conseil & Audit</h3>
                    <p class="text-white/80 text-sm leading-relaxed mb-6">Analyse de vos pratiques, identification des
                        écarts réglementaires et rédaction de plans d'action concrets pour mettre votre organisation en
                        conformité.</p>
                    <div class="flex items-center gap-2 text-white/90 font-semibold text-sm">
                        En savoir plus
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 rounded-full bg-white/5"></div>
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-white/5"></div>
                </a>

                <a href="{{ route('services.index', ['type' => 'training']) }}" data-animate="fade-up"
                    data-delay="100" style="background-color: var(--color-brand-700);"
                    class="group relative overflow-hidden rounded-2xl p-8 text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:brightness-110">
                    <div class="w-12 h-12 bg-white/15 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Formation & Sensibilisation</h3>
                    <p class="text-white/80 text-sm leading-relaxed mb-6">Programmes de formation sur mesure dispensés
                        par des experts certifiés — présentiel, distanciel ou blended — pour tous les niveaux de votre
                        organisation.</p>
                    <div class="flex items-center gap-2 text-white/90 font-semibold text-sm">
                        En savoir plus
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 rounded-full bg-white/5"></div>
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-white/5"></div>
                </a>

                <a href="{{ route('services.index', ['type' => 'qhse']) }}" data-animate="fade-up" data-delay="200"
                    style="background-color: var(--color-brand-800);"
                    class="group relative overflow-hidden rounded-2xl p-8 text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:brightness-110">
                    <div class="w-12 h-12 bg-white/15 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Accompagnement & Certification</h3>
                    <p class="text-white/80 text-sm leading-relaxed mb-6">Suivi opérationnel de A à Z pour l'obtention
                        et le maintien de vos certifications ISO 9001, ISO 14001, ISO 45001 et référentiels sectoriels.
                    </p>
                    <div class="flex items-center gap-2 text-white/90 font-semibold text-sm">
                        En savoir plus
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 rounded-full bg-white/5"></div>
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-white/5"></div>
                </a>

            </div>

            @if ($services->count())
                <!-- Services phares dynamiques -->
                <div class="border-t border-gray-200 pt-10">
                    <h3 class="text-lg font-semibold text-gray-700 mb-6" data-animate="fade-up">Nos prestations phares
                    </h3>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach ($services as $service)
                            <a href="{{ route('services.show', $service->slug) }}" data-animate="fade-up"
                                data-delay="{{ $loop->index * 70 }}"
                                class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-md border border-gray-100 hover:border-brand-200 transition-all">
                                @if ($service->icon)
                                    <div
                                        class="w-11 h-11 bg-brand-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                                        <span class="text-xl">{{ $service->icon }}</span>
                                    </div>
                                @endif
                                <h4
                                    class="font-semibold text-gray-900 mb-2 group-hover:text-brand-600 transition-colors">
                                    {{ $service->title }}</h4>
                                <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">
                                    {{ $service->description }}</p>
                                <div class="mt-4 flex items-center gap-1 text-brand-600 text-sm font-medium">
                                    Détails <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="text-center mt-10" data-animate="fade-up">
                <a href="{{ route('services.index') }}"
                    class="inline-flex items-center gap-2 text-brand-600 hover:text-brand-700 font-semibold">
                    Voir tous nos services
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA devis -->
    <section class="py-16 bg-brand-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate="zoom-in">
            <h2 class="text-3xl font-bold text-white mb-4">Prêt à lancer votre certification ISO ?</h2>
            <p class="text-brand-100 mb-8 text-lg">L'audit diagnostic est <strong class="text-white">100% gratuit et
                    sans engagement</strong>. Vous repartez avec un rapport et un plan d'action priorisé.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('quotes.request') }}"
                    class="inline-flex items-center gap-2 bg-white text-brand-700 hover:bg-brand-50 font-semibold px-8 py-3 rounded-xl transition-colors shadow">
                    Demander mon diagnostic gratuit
                </a>
                <a href="{{ route('process') }}"
                    class="inline-flex items-center gap-2 text-white bg-[#769044] hover:bg-[#96B857] font-semibold px-8 py-3 rounded-xl transition-colors">
                    Voir notre processus
                </a>
            </div>
        </div>
    </section>

    <!-- ═══ FORMATIONS ════════════════════════════════════════════════ -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12" data-animate="fade-up">
                <div>
                    <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Montez en
                        compétences</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2">Catalogue de formations</h2>
                    <p class="text-gray-500 mt-2 max-w-xl">Des parcours certifiants et des formations courtes pour tous
                        les niveaux, en présentiel ou à distance.</p>
                </div>
                <a href="{{ route('formations.index') }}"
                    class="shrink-0 text-brand-600 hover:text-brand-700 font-medium text-sm flex items-center gap-1">
                    Voir tout le catalogue
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            @if ($formations->count())
                <!-- Formations dynamiques -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($formations as $formation)
                        <a href="{{ route('formations.show', $formation->slug) }}" data-animate="fade-up"
                            data-delay="{{ $loop->index * 100 }}"
                            class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 hover:border-brand-200 transition-all">
                            @if ($formation->cover_image)
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ Storage::url($formation->cover_image) }}"
                                        alt="{{ $formation->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            @else
                                <div
                                    class="aspect-video bg-linear-to-br from-brand-50 to-brand-100 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-brand-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            @endif
                            <div class="p-5">
                                <div class="flex items-center gap-2 mb-3">
                                    <span
                                        class="bg-brand-50 text-brand-700 text-xs font-medium px-2 py-0.5 rounded-full">{{ $formation->duration_hours }}h</span>
                                    @if ($formation->format)
                                        <span
                                            class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-0.5 rounded-full capitalize">{{ $formation->format }}</span>
                                    @endif
                                </div>
                                <h3
                                    class="font-semibold text-gray-900 mb-2 group-hover:text-brand-600 transition-colors line-clamp-2">
                                    {{ $formation->title }}</h3>
                                <p class="text-gray-500 text-sm line-clamp-2">{{ $formation->description }}</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-brand-600 font-semibold text-sm">
                                        {{ $formation->price_on_request ? 'Sur devis' : number_format($formation->price, 0, ',', ' ') . ' FCFA' }}
                                    </span>
                                    <span class="text-brand-600 text-sm font-medium flex items-center gap-1">
                                        Détails <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Teaser statique formations -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach ([['shield', 'Sécurité au travail', 'Prévention des risques, document unique, DUERP', '7h – 14h'], ['leaf', 'Management environnemental', 'ISO 14001, bilan carbone, éco-conception', '14h – 21h'], ['badge-check', 'Systèmes qualité', 'ISO 9001, audits internes, revues de processus', '14h – 35h'], ['beaker', 'Hygiène & alimentaire', 'HACCP, BPH, traçabilité, IFS/BRC', '7h – 21h']] as $idx => [$icon, $title, $desc, $duration])
                        <div data-animate="fade-up" data-delay="{{ $idx * 80 }}"
                            class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-brand-200 hover:shadow-md transition-all cursor-default">
                            <div class="w-11 h-11 bg-brand-50 rounded-xl flex items-center justify-center mb-4">
                                @if ($icon === 'shield')
                                    <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                @elseif($icon === 'leaf')
                                    <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                @elseif($icon === 'badge-check')
                                    <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                    </svg>
                                @endif
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">{{ $title }}</h3>
                            <p class="text-gray-500 text-sm leading-relaxed mb-4">{{ $desc }}</p>
                            <span
                                class="inline-flex items-center gap-1 bg-brand-50 text-brand-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $duration }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-10 text-center" data-animate="fade-up">
                    <a href="{{ route('formations.index') }}"
                        class="inline-flex items-center gap-2 bg-[#769044] hover:bg-[#96B857] text-white font-semibold px-6 py-3 rounded-xl transition-colors shadow-sm">
                        Consulter le catalogue complet
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Témoignages -->
    @if ($testimonials->count())
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14" data-animate="fade-up">
                    <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Ce que disent nos
                        clients</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2">Témoignages</h2>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($testimonials as $testimonial)
                        <div data-animate="fade-up" data-delay="{{ $loop->index * 80 }}"
                            class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <div class="flex gap-0.5 mb-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-gray-200' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed mb-5 italic">"{{ $testimonial->content }}"
                            </p>
                            <div class="flex items-center gap-3">
                                @if ($testimonial->avatar)
                                    <img src="{{ Storage::url($testimonial->avatar) }}"
                                        alt="{{ $testimonial->author_name }}"
                                        class="w-9 h-9 rounded-full object-cover">
                                @else
                                    <div class="w-9 h-9 rounded-full bg-brand-100 flex items-center justify-center">
                                        <span
                                            class="text-brand-600 text-sm font-semibold">{{ substr($testimonial->author_name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $testimonial->author_name }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $testimonial->author_role }}{{ $testimonial->author_company ? ', ' . $testimonial->author_company : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Références -->
    @if ($references->count())
        <section class="py-4 bg-obq-page">
            {{-- En-tête --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-10" data-animate="fade-up">
                <span
                    class="inline-flex items-center gap-2 bg-brand-50 border border-brand-100 text-brand-600 font-semibold text-xs uppercase tracking-wider px-4 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 bg-brand-500 rounded-full animate-pulse"></span>
                    Ils nous font confiance
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold text-brand-600 mt-4">Des organisations de référence</h2>
                <p class="text-obq-muted mt-3 max-w-2xl mx-auto">Du secteur public aux grands groupes industriels, nous
                    accompagnons des structures exigeantes vers leurs certifications ISO.</p>
            </div>

            {{-- Bande marquee --}}
            <div class="relative overflow-hidden">
                {{-- Fondu gauche / droite --}}
                <div class="pointer-events-none absolute left-0 top-0 bottom-0 w-32 z-10"
                    style="background: linear-gradient(to right, #ffffff, transparent);"></div>
                <div class="pointer-events-none absolute right-0 top-0 bottom-0 w-32 z-10"
                    style="background: linear-gradient(to left, #ffffff, transparent);"></div>

                <div class="flex animate-marquee">
                    {{-- Dupliquer 2x pour boucle sans couture --}}
                    @foreach ([0, 1] as $_)
                        @foreach ($references as $ref)
                            <div class="shrink-0 mx-10 flex flex-col items-center justify-center gap-2 group">
                                @if ($ref->client_logo)
                                    <img src="{{ Storage::url($ref->client_logo) }}"
                                        alt="{{ $ref->show_client_name ? $ref->client_name : 'Partenaire' }}"
                                        class="h-36 max-w-36 object-contain opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                                @else
                                    <div
                                        class="w-12 h-12 rounded-xl bg-brand-600 flex items-center justify-center shadow-sm group-hover:bg-accent-600 transition-colors">
                                        <span class="text-white font-bold text-base">
                                            {{ collect(explode(' ', $ref->client_name))->take(2)->map(fn($w) => mb_substr($w, 0, 1))->implode('') }}
                                        </span>
                                    </div>
                                    @if ($ref->show_client_name)
                                        <span
                                            class="text-xs font-semibold text-obq-muted group-hover:text-brand-600 transition-colors whitespace-nowrap">{{ $ref->client_name }}</span>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>

            {{-- CTA --}}
            <div class="mt-8 text-center" data-animate="fade-up">
                <a href="{{ route('references') }}"
                    class="inline-flex items-center gap-2 text-brand-600 hover:text-brand-500 font-semibold text-sm group">
                    Découvrir toutes nos références
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </section>
    @endif

    <!-- ═══ BLOG / DERNIERS ARTICLES ══════════════════════════════════ -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12" data-animate="fade-up">
                <div>
                    <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Actualités &
                        Expertises</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2">Derniers articles</h2>
                    <p class="text-gray-500 mt-2 max-w-xl">Analyses réglementaires, guides pratiques et retours
                        d'expérience de nos experts QHSE.</p>
                </div>
                <a href="{{ route('blog.index') }}"
                    class="shrink-0 text-brand-600 hover:text-brand-700 font-medium text-sm flex items-center gap-1">
                    Voir tous les articles
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            @if ($latestPosts->count())
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($latestPosts as $post)
                        <a href="{{ route('blog.show', $post->slug) }}" data-animate="fade-up"
                            data-delay="{{ $loop->index * 100 }}"
                            class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 hover:border-brand-200 transition-all">
                            @if ($post->cover_image)
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            @else
                                <div
                                    class="aspect-video bg-linear-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="p-5">
                                @if ($post->category)
                                    <span
                                        class="text-brand-600 text-xs font-semibold uppercase tracking-wider">{{ $post->category->name }}</span>
                                @endif
                                <h3
                                    class="font-semibold text-gray-900 mt-1 mb-2 group-hover:text-brand-600 transition-colors line-clamp-2">
                                    {{ $post->title }}</h3>
                                <p class="text-gray-500 text-sm line-clamp-3">{{ $post->excerpt }}</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3 text-xs text-gray-400">
                                        <span>{{ $post->published_at?->format('d M Y') }}</span>
                                        @if ($post->author)
                                            <span>•</span><span>{{ $post->author->name }}</span>
                                        @endif
                                    </div>
                                    <span class="text-brand-600 text-xs font-medium flex items-center gap-1">
                                        Lire <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Teaser statique blog -->
                <div class="grid sm:grid-cols-3 gap-6">
                    @foreach ([['Réglementation', 'Les nouvelles obligations DUERP en 2024 : ce qui change pour votre entreprise', 'Depuis le décret du 18 avril 2022, la mise à jour annuelle du document unique est obligatoire pour les entreprises de plus de 11 salariés.'], ['Qualité', 'ISO 9001 v2015 : les 7 points clés pour réussir votre audit de renouvellement', 'Préparez efficacement votre audit de certification avec notre guide complet des exigences actualisées.'], ['Sécurité', 'Risques psychosociaux : obligations légales et bonnes pratiques pour les employeurs', 'Les RPS sont désormais intégrés dans les critères d\'évaluation des inspecteurs du travail. Découvrez comment les prévenir.']] as $idx => [$cat, $title, $excerpt])
                        <div data-animate="fade-up" data-delay="{{ $idx * 100 }}"
                            class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                            <div
                                class="aspect-video bg-linear-to-br from-brand-50 to-brand-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-brand-300" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                            <div class="p-5">
                                <span
                                    class="text-brand-600 text-xs font-semibold uppercase tracking-wider">{{ $cat }}</span>
                                <h3 class="font-semibold text-gray-900 mt-1 mb-2 line-clamp-2">{{ $title }}
                                </h3>
                                <p class="text-gray-500 text-sm line-clamp-3">{{ $excerpt }}</p>
                                <div class="mt-4">
                                    <a href="{{ route('blog.index') }}"
                                        class="text-brand-600 text-xs font-medium flex items-center gap-1 hover:gap-2 transition-all">
                                        Lire l'article <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="relative py-20 bg-brand-900 text-white">
        <div class="absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="cta-grid" x="0" y="0" width="32" height="32" patternUnits="userSpaceOnUse">
                        <path d="M0 32V0H32" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#cta-grid)" />
            </svg>
        </div>
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate="zoom-in">
            <h2 class="text-3xl font-bold mb-4">Restez informé des actualités QHSE</h2>
            <p class="text-brand-200 mb-8">Recevez nos analyses, guides pratiques et actualités réglementaires
                directement dans votre boîte mail.</p>
            <livewire:newsletter-form />
        </div>
    </section>

</x-layouts.app>
