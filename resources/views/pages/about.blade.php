<x-layouts.app title="À propos">
    <!-- Hero -->
    <div class="bg-gradient-to-br from-brand-950 to-brand-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="hero-enter text-sm text-brand-300 mb-6" style="animation-delay:0.1s">
                <a href="{{ route('home') }}" class="hover:text-white">Accueil</a>
                <span class="mx-2">/</span>
                <span class="text-brand-100">À propos</span>
            </nav>
            <div class="max-w-3xl">
                <div class="hero-enter inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm font-medium mb-6" style="animation-delay:0.15s">
                    <span class="w-2 h-2 bg-brand-300 rounded-full animate-pulse"></span>
                    {{ $siteSettings->get('brand_tagline', 'Cabinet de Conseil en Management Qualité et Conformité') }}
                </div>
                <h1 class="hero-enter text-4xl sm:text-5xl font-bold mb-6" style="animation-delay:0.2s">
                    {{ $siteSettings->get('brand_name', 'OBSEQUIUM') }}
                </h1>
                <p class="hero-enter text-xl text-brand-100 leading-relaxed" style="animation-delay:0.35s">
                    {{ $siteSettings->get('about_intro') }}
                </p>
                @if($siteSettings->get('brand_slogan'))
                <p class="hero-enter text-brand-200 italic mt-4" style="animation-delay:0.5s">« {{ $siteSettings->get('brand_slogan') }} »</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Mot du gérant -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-start">
                <div data-animate="fade-right">
                    <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Mot du gérant</span>
                    <h2 class="text-3xl font-bold text-gray-900 mt-2 mb-6">La conformité comme levier de performance</h2>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        @foreach(['about_description_1','about_description_2','about_description_3','about_description_4'] as $key)
                            @if($siteSettings->get($key))
                                <p>{{ $siteSettings->get($key) }}</p>
                            @endif
                        @endforeach
                        <p class="text-brand-700 font-semibold pt-2">Parce que la performance durable commence toujours par une organisation maîtrisée.</p>
                    </div>
                    @if($siteSettings->get('manager_name'))
                    <div class="mt-8 flex items-center gap-3 text-sm text-gray-500">
                        <div class="w-12 h-12 bg-brand-100 rounded-full flex items-center justify-center text-brand-700 font-bold">
                            {{ collect(explode(' ', $siteSettings->get('manager_name')))->map(fn($p) => mb_substr($p, 0, 1))->implode('') }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $siteSettings->get('manager_name') }}</p>
                            <p class="text-xs text-gray-400">{{ $siteSettings->get('manager_role') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        [$siteSettings->get('stat_clients', '5'),      $siteSettings->get('stat_clients_label', 'Organisations accompagnées'), 'bg-brand-50 text-brand-600'],
                        [$siteSettings->get('stat_formations', '3'),   $siteSettings->get('stat_formations_label', 'Normes ISO maîtrisées'),    'bg-blue-50 text-blue-600'],
                        [$siteSettings->get('stat_years', '6-12'),     $siteSettings->get('stat_years_label', "Mois d'accompagnement"),         'bg-purple-50 text-purple-600'],
                        [$siteSettings->get('stat_satisfaction', '100%'), $siteSettings->get('stat_satisfaction_label', 'Audit diagnostic offert'), 'bg-green-50 text-green-600'],
                    ] as $idx => [$num, $label, $cls])
                    <div data-animate="zoom-in" data-delay="{{ $idx * 80 }}"
                         class="rounded-2xl p-6 text-center {{ $cls }}">
                        <div class="text-3xl font-bold mb-1">{{ $num }}</div>
                        <div class="text-sm font-medium opacity-80">{{ $label }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Domaines de compétences -->
    <section class="py-20 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-animate="fade-up">
                <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Notre spécialité</span>
                <h2 class="text-3xl font-bold text-gray-900 mt-2 mb-4">Accompagnement intégral à la certification ISO</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Nous guidons vos équipes de la phase de diagnostic jusqu'à la préparation de l'audit de certification, avec une approche pragmatique, progressive et adaptée à chaque contexte organisationnel.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach([
                    ['ISO 9001',  'Management de la Qualité',                'bg-brand-50 text-brand-700 border-brand-200'],
                    ['ISO 14001', 'Management Environnemental',              'bg-green-50 text-green-700 border-green-200'],
                    ['ISO 45001', 'Sécurité et Santé au Travail',            'bg-amber-50 text-amber-700 border-amber-200'],
                    ['ISO 22000', 'Sécurité des Denrées Alimentaires',       'bg-rose-50 text-rose-700 border-rose-200'],
                    ['ISO 27001', "Sécurité des Systèmes d'Information",     'bg-slate-50 text-slate-700 border-slate-200'],
                    ['Autres',    'Normes sectorielles selon vos besoins',   'bg-gray-50 text-gray-700 border-gray-200'],
                ] as $idx => [$norm, $desc, $cls])
                <div data-animate="fade-up" data-delay="{{ $idx * 60 }}"
                     class="rounded-2xl p-6 border-2 {{ $cls }}">
                    <div class="text-xl font-bold mb-2">{{ $norm }}</div>
                    <p class="text-sm opacity-90">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-animate="fade-up">
                <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Ce qui nous anime</span>
                <h2 class="text-3xl font-bold text-gray-900 mt-2">Nos valeurs</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                    ['Rigueur',    "Respect des normes ISO et des meilleures pratiques.",                          'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                    ['Adaptation', "Solutions personnalisées selon votre contexte et vos réalités opérationnelles.", 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                    ['Proximité',  "Une équipe disponible, accessible et présente sur le terrain à vos côtés.",     'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    ['Résultats',  "Accompagnement structuré jusqu'à la certification, mesurable et durable.",      'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                ] as $idx => [$title, $desc, $path])
                <div data-animate="fade-up" data-delay="{{ $idx * 80 }}"
                     class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/></svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $title }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
            @if($siteSettings->get('brand_slogan'))
            <div class="mt-12 text-center" data-animate="fade-up">
                <p class="text-brand-700 italic text-lg">« {{ $siteSettings->get('brand_slogan') }} »</p>
            </div>
            @endif
        </div>
    </section>

    <!-- Team -->
    @if($team->count())
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-animate="fade-up">
                <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Ceux qui font le cabinet</span>
                <h2 class="text-3xl font-bold text-gray-900 mt-2">Notre équipe</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($team as $member)
                <div data-animate="fade-up" data-delay="{{ $loop->index * 80 }}"
                     class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-center">
                    @if($member->photo)
                    <div class="aspect-square overflow-hidden">
                        <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover object-top">
                    </div>
                    @else
                    <div class="aspect-square bg-gradient-to-br from-brand-100 to-brand-200 flex items-center justify-center">
                        <span class="text-brand-600 text-4xl font-bold">{{ substr($member->name, 0, 1) }}</span>
                    </div>
                    @endif
                    <div class="p-5">
                        <h3 class="font-semibold text-gray-900">{{ $member->name }}</h3>
                        <p class="text-brand-600 text-sm mb-3">{{ $member->role }}</p>
                        @if($member->bio)
                        <p class="text-gray-500 text-xs leading-relaxed line-clamp-3">{{ $member->bio }}</p>
                        @endif
                        @if($member->linkedin_url)
                        <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-brand-600 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            LinkedIn
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA -->
    <section class="py-16 bg-brand-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate="zoom-in">
            <h2 class="text-3xl font-bold text-white mb-4">Travaillons ensemble</h2>
            <p class="text-brand-100 mb-8 text-lg">Prenez contact pour discuter de vos enjeux QHSE et découvrir comment nous pouvons vous accompagner.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-white text-brand-700 hover:bg-brand-50 font-semibold px-8 py-3 rounded-xl transition-colors shadow">
                    Nous contacter
                </a>
                <a href="{{ route('appointments.book') }}" class="inline-flex items-center gap-2 border border-white/40 text-white hover:bg-white/10 font-semibold px-8 py-3 rounded-xl transition-colors">
                    Prendre rendez-vous
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
