<x-layouts.app title="Accueil">

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-brand-950 via-brand-800 to-brand-600 text-white overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.04\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-36">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="hero-enter inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm font-medium mb-6" style="animation-delay:0.1s">
                        <span class="w-2 h-2 bg-brand-300 rounded-full animate-pulse"></span>
                        {{ $siteSettings->get('hero_badge', 'Cabinet expert en QHSE') }}
                    </div>
                    <h1 class="hero-enter text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6" style="animation-delay:0.25s">
                        {{ $siteSettings->get('hero_title', 'Votre partenaire QHSE de confiance') }}
                    </h1>
                    <p class="hero-enter text-lg text-brand-100 leading-relaxed mb-8 max-w-xl" style="animation-delay:0.4s">
                        {{ $siteSettings->get('hero_description', 'Conseil, formation et accompagnement sur mesure pour répondre à tous vos enjeux qualité, hygiène, sécurité et environnement.') }}
                    </p>
                    <div class="hero-enter flex flex-wrap gap-4" style="animation-delay:0.55s">
                        <a href="{{ route('quotes.request') }}" class="inline-flex items-center gap-2 bg-white text-brand-700 hover:bg-brand-50 font-semibold px-6 py-3 rounded-xl transition-colors shadow-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Demander un devis gratuit
                        </a>
                        <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 border border-white/30 hover:bg-white/10 font-semibold px-6 py-3 rounded-xl transition-colors">
                            Découvrir nos services
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        [$siteSettings->get('stat_clients', '150+'), 'Clients accompagnés'],
                        [$siteSettings->get('stat_formations', '500+'), 'Formations dispensées'],
                        [$siteSettings->get('stat_years', '15+'), "Années d'expérience"],
                        [$siteSettings->get('stat_satisfaction', '98%'), 'Taux de satisfaction'],
                    ] as $idx => [$stat, $label])
                    <div class="hero-enter bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center border border-white/20" style="animation-delay:{{ 0.6 + $idx * 0.1 }}s">
                        <div class="text-3xl font-bold text-white mb-1">{{ $stat }}</div>
                        <div class="text-brand-200 text-sm">{{ $label }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ SERVICES ══════════════════════════════════════════════════ -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-14" data-animate="fade-up">
                <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Ce que nous faisons</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2 mb-4">Nos services QHSE</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Une offre complète pour répondre à tous vos besoins en matière de qualité, hygiène, sécurité et environnement.</p>
            </div>

            <!-- 3 grandes catégories (toujours visibles) -->
            <div class="grid md:grid-cols-3 gap-6 mb-10">

                <a href="{{ route('services.index', ['type' => 'audit']) }}"
                   data-animate="fade-up" data-delay="0"
                   style="background-color: var(--color-brand-600);"
                   class="group relative overflow-hidden rounded-2xl p-8 text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:brightness-110">
                    <div class="text-4xl mb-5">🔍</div>
                    <h3 class="text-xl font-bold text-white mb-3">Conseil & Audit</h3>
                    <p class="text-white/80 text-sm leading-relaxed mb-6">Analyse de vos pratiques, identification des écarts réglementaires et rédaction de plans d'action concrets pour mettre votre organisation en conformité.</p>
                    <div class="flex items-center gap-2 text-white/90 font-semibold text-sm">
                        En savoir plus
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 rounded-full bg-white/5"></div>
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-white/5"></div>
                </a>

                <a href="{{ route('services.index', ['type' => 'training']) }}"
                   data-animate="fade-up" data-delay="100"
                   style="background-color: var(--color-brand-700);"
                   class="group relative overflow-hidden rounded-2xl p-8 text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:brightness-110">
                    <div class="text-4xl mb-5">🎓</div>
                    <h3 class="text-xl font-bold text-white mb-3">Formation & Sensibilisation</h3>
                    <p class="text-white/80 text-sm leading-relaxed mb-6">Programmes de formation sur mesure dispensés par des experts certifiés — présentiel, distanciel ou blended — pour tous les niveaux de votre organisation.</p>
                    <div class="flex items-center gap-2 text-white/90 font-semibold text-sm">
                        En savoir plus
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 rounded-full bg-white/5"></div>
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-white/5"></div>
                </a>

                <a href="{{ route('services.index', ['type' => 'qhse']) }}"
                   data-animate="fade-up" data-delay="200"
                   style="background-color: var(--color-brand-800);"
                   class="group relative overflow-hidden rounded-2xl p-8 text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:brightness-110">
                    <div class="text-4xl mb-5">🤝</div>
                    <h3 class="text-xl font-bold text-white mb-3">Accompagnement & Certification</h3>
                    <p class="text-white/80 text-sm leading-relaxed mb-6">Suivi opérationnel de A à Z pour l'obtention et le maintien de vos certifications ISO 9001, ISO 14001, ISO 45001 et référentiels sectoriels.</p>
                    <div class="flex items-center gap-2 text-white/90 font-semibold text-sm">
                        En savoir plus
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 rounded-full bg-white/5"></div>
                    <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-white/5"></div>
                </a>

            </div>

            @if($services->count())
            <!-- Services phares dynamiques -->
            <div class="border-t border-gray-200 pt-10">
                <h3 class="text-lg font-semibold text-gray-700 mb-6" data-animate="fade-up">Nos prestations phares</h3>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($services as $service)
                    <a href="{{ route('services.show', $service->slug) }}"
                       data-animate="fade-up" data-delay="{{ $loop->index * 70 }}"
                       class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-md border border-gray-100 hover:border-brand-200 transition-all">
                        @if($service->icon)
                        <div class="w-11 h-11 bg-brand-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-brand-100 transition-colors">
                            <span class="text-xl">{{ $service->icon }}</span>
                        </div>
                        @endif
                        <h4 class="font-semibold text-gray-900 mb-2 group-hover:text-brand-600 transition-colors">{{ $service->title }}</h4>
                        <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">{{ $service->description }}</p>
                        <div class="mt-4 flex items-center gap-1 text-brand-600 text-sm font-medium">
                            Détails <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="text-center mt-10" data-animate="fade-up">
                <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 text-brand-600 hover:text-brand-700 font-semibold">
                    Voir tous nos services
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA devis -->
    <section class="py-16 bg-brand-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate="zoom-in">
            <h2 class="text-3xl font-bold text-white mb-4">Un projet QHSE en tête ?</h2>
            <p class="text-brand-100 mb-8 text-lg">Obtenez un devis personnalisé en quelques minutes. Notre équipe vous répond sous 24h.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('quotes.request') }}" class="inline-flex items-center gap-2 bg-white text-brand-700 hover:bg-brand-50 font-semibold px-8 py-3 rounded-xl transition-colors shadow">
                    Demander un devis gratuit
                </a>
                <a href="{{ route('appointments.book') }}" class="inline-flex items-center gap-2 border border-white/40 text-white hover:bg-white/10 font-semibold px-8 py-3 rounded-xl transition-colors">
                    Prendre rendez-vous
                </a>
            </div>
        </div>
    </section>

    <!-- ═══ FORMATIONS ════════════════════════════════════════════════ -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12" data-animate="fade-up">
                <div>
                    <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Montez en compétences</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2">Catalogue de formations</h2>
                    <p class="text-gray-500 mt-2 max-w-xl">Des parcours certifiants et des formations courtes pour tous les niveaux, en présentiel ou à distance.</p>
                </div>
                <a href="{{ route('formations.index') }}" class="shrink-0 text-brand-600 hover:text-brand-700 font-medium text-sm flex items-center gap-1">
                    Voir tout le catalogue
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            @if($formations->count())
            <!-- Formations dynamiques -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($formations as $formation)
                <a href="{{ route('formations.show', $formation->slug) }}"
                   data-animate="fade-up" data-delay="{{ $loop->index * 100 }}"
                   class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 hover:border-brand-200 transition-all">
                    @if($formation->cover_image)
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ Storage::url($formation->cover_image) }}" alt="{{ $formation->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    @else
                    <div class="aspect-video bg-gradient-to-br from-brand-50 to-brand-100 flex items-center justify-center">
                        <svg class="w-12 h-12 text-brand-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    @endif
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-brand-50 text-brand-700 text-xs font-medium px-2 py-0.5 rounded-full">{{ $formation->duration_hours }}h</span>
                            @if($formation->format)
                            <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-0.5 rounded-full capitalize">{{ $formation->format }}</span>
                            @endif
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-brand-600 transition-colors line-clamp-2">{{ $formation->title }}</h3>
                        <p class="text-gray-500 text-sm line-clamp-2">{{ $formation->description }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-brand-600 font-semibold text-sm">
                                {{ $formation->price_on_request ? 'Sur devis' : number_format($formation->price, 0, ',', ' ').' €' }}
                            </span>
                            <span class="text-brand-600 text-sm font-medium flex items-center gap-1">
                                Détails <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <!-- Teaser statique formations -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach([
                    ['🛡️', 'Sécurité au travail', 'Prévention des risques, document unique, DUERP', '7h – 14h'],
                    ['🌿', 'Management environnemental', 'ISO 14001, bilan carbone, éco-conception', '14h – 21h'],
                    ['✅', 'Systèmes qualité', 'ISO 9001, audits internes, revues de processus', '14h – 35h'],
                    ['🔬', 'Hygiène & alimentaire', 'HACCP, BPH, traçabilité, IFS/BRC', '7h – 21h'],
                ] as $idx => [$icon, $title, $desc, $duration])
                <div data-animate="fade-up" data-delay="{{ $idx * 80 }}"
                     class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-brand-200 hover:shadow-md transition-all cursor-default">
                    <div class="text-3xl mb-4">{{ $icon }}</div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $title }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">{{ $desc }}</p>
                    <span class="inline-flex items-center gap-1 bg-brand-50 text-brand-700 text-xs font-medium px-2.5 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $duration }}
                    </span>
                </div>
                @endforeach
            </div>
            <div class="mt-10 text-center" data-animate="fade-up">
                <a href="{{ route('formations.index') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors shadow-sm">
                    Consulter le catalogue complet
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- Témoignages -->
    @if($testimonials->count())
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-animate="fade-up">
                <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Ce que disent nos clients</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2">Témoignages</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($testimonials as $testimonial)
                <div data-animate="fade-up" data-delay="{{ $loop->index * 80 }}"
                     class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex gap-0.5 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-5 italic">"{{ $testimonial->content }}"</p>
                    <div class="flex items-center gap-3">
                        @if($testimonial->avatar)
                        <img src="{{ Storage::url($testimonial->avatar) }}" alt="{{ $testimonial->author_name }}" class="w-9 h-9 rounded-full object-cover">
                        @else
                        <div class="w-9 h-9 rounded-full bg-brand-100 flex items-center justify-center">
                            <span class="text-brand-600 text-sm font-semibold">{{ substr($testimonial->author_name, 0, 1) }}</span>
                        </div>
                        @endif
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $testimonial->author_name }}</div>
                            <div class="text-xs text-gray-400">{{ $testimonial->author_role }}{{ $testimonial->author_company ? ', '.$testimonial->author_company : '' }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Références -->
    @if($references->count())
    <section class="py-16 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-semibold text-gray-400 uppercase tracking-widest mb-10" data-animate="fade-up">Ils nous font confiance</p>
            <div class="flex flex-wrap justify-center items-center gap-10" data-animate="fade-up" data-delay="100">
                @foreach($references as $ref)
                @if($ref->client_logo)
                <img src="{{ Storage::url($ref->client_logo) }}" alt="{{ $ref->show_client_name ? $ref->client_name : 'Client' }}" class="h-10 object-contain grayscale hover:grayscale-0 opacity-50 hover:opacity-100 transition-all">
                @elseif($ref->show_client_name)
                <span class="text-gray-400 font-semibold text-sm hover:text-gray-700 transition-colors">{{ $ref->client_name }}</span>
                @endif
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ═══ BLOG / DERNIERS ARTICLES ══════════════════════════════════ -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12" data-animate="fade-up">
                <div>
                    <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Actualités & Expertises</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mt-2">Derniers articles</h2>
                    <p class="text-gray-500 mt-2 max-w-xl">Analyses réglementaires, guides pratiques et retours d'expérience de nos experts QHSE.</p>
                </div>
                <a href="{{ route('blog.index') }}" class="shrink-0 text-brand-600 hover:text-brand-700 font-medium text-sm flex items-center gap-1">
                    Voir tous les articles
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            @if($latestPosts->count())
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($latestPosts as $post)
                <a href="{{ route('blog.show', $post->slug) }}"
                   data-animate="fade-up" data-delay="{{ $loop->index * 100 }}"
                   class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 hover:border-brand-200 transition-all">
                    @if($post->cover_image)
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    @else
                    <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    @endif
                    <div class="p-5">
                        @if($post->category)
                        <span class="text-brand-600 text-xs font-semibold uppercase tracking-wider">{{ $post->category->name }}</span>
                        @endif
                        <h3 class="font-semibold text-gray-900 mt-1 mb-2 group-hover:text-brand-600 transition-colors line-clamp-2">{{ $post->title }}</h3>
                        <p class="text-gray-500 text-sm line-clamp-3">{{ $post->excerpt }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center gap-3 text-xs text-gray-400">
                                <span>{{ $post->published_at?->format('d M Y') }}</span>
                                @if($post->author)<span>•</span><span>{{ $post->author->name }}</span>@endif
                            </div>
                            <span class="text-brand-600 text-xs font-medium flex items-center gap-1">
                                Lire <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <!-- Teaser statique blog -->
            <div class="grid sm:grid-cols-3 gap-6">
                @foreach([
                    ['Réglementation', 'Les nouvelles obligations DUERP en 2024 : ce qui change pour votre entreprise', 'Depuis le décret du 18 avril 2022, la mise à jour annuelle du document unique est obligatoire pour les entreprises de plus de 11 salariés.'],
                    ['Qualité', 'ISO 9001 v2015 : les 7 points clés pour réussir votre audit de renouvellement', 'Préparez efficacement votre audit de certification avec notre guide complet des exigences actualisées.'],
                    ['Sécurité', 'Risques psychosociaux : obligations légales et bonnes pratiques pour les employeurs', 'Les RPS sont désormais intégrés dans les critères d\'évaluation des inspecteurs du travail. Découvrez comment les prévenir.'],
                ] as $idx => [$cat, $title, $excerpt])
                <div data-animate="fade-up" data-delay="{{ $idx * 100 }}"
                     class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    <div class="aspect-video bg-gradient-to-br from-brand-50 to-brand-100 flex items-center justify-center">
                        <svg class="w-10 h-10 text-brand-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <div class="p-5">
                        <span class="text-brand-600 text-xs font-semibold uppercase tracking-wider">{{ $cat }}</span>
                        <h3 class="font-semibold text-gray-900 mt-1 mb-2 line-clamp-2">{{ $title }}</h3>
                        <p class="text-gray-500 text-sm line-clamp-3">{{ $excerpt }}</p>
                        <div class="mt-4">
                            <a href="{{ route('blog.index') }}" class="text-brand-600 text-xs font-medium flex items-center gap-1 hover:gap-2 transition-all">
                                Lire l'article <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
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
    <section class="py-20 bg-brand-900 text-white">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate="zoom-in">
            <h2 class="text-3xl font-bold mb-4">Restez informé des actualités QHSE</h2>
            <p class="text-brand-200 mb-8">Recevez nos analyses, guides pratiques et actualités réglementaires directement dans votre boîte mail.</p>
            <livewire:newsletter-form />
        </div>
    </section>

</x-layouts.app>
