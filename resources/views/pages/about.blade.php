<x-layouts.app title="À propos — Cabinet QHSE">
    <!-- Hero -->
    <div class="bg-gradient-to-br from-brand-950 to-brand-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="hero-enter text-sm text-brand-300 mb-6" style="animation-delay:0.1s">
                <a href="{{ route('home') }}" class="hover:text-white">Accueil</a>
                <span class="mx-2">/</span>
                <span class="text-brand-100">À propos</span>
            </nav>
            <div class="max-w-3xl">
                <h1 class="hero-enter text-4xl sm:text-5xl font-bold mb-6" style="animation-delay:0.2s">
                    {{ $siteSettings->get('brand_name', 'Cabinet QHSE') }}
                </h1>
                <p class="hero-enter text-xl text-brand-100 leading-relaxed" style="animation-delay:0.35s">
                    {{ $siteSettings->get('about_intro', 'Depuis plus de 15 ans, nous accompagnons les entreprises dans leur démarche QHSE.') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Mission -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div data-animate="fade-right">
                    <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Notre mission</span>
                    <h2 class="text-3xl font-bold text-gray-900 mt-2 mb-6">Accompagner vos ambitions QHSE</h2>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        @if($siteSettings->get('about_description_1'))
                        <p>{{ $siteSettings->get('about_description_1') }}</p>
                        @endif
                        @if($siteSettings->get('about_description_2'))
                        <p>{{ $siteSettings->get('about_description_2') }}</p>
                        @endif
                        @if($siteSettings->get('about_description_3'))
                        <p>{{ $siteSettings->get('about_description_3') }}</p>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        [$siteSettings->get('stat_clients', '150+'), 'Entreprises accompagnées', 'bg-brand-50 text-brand-600'],
                        [$siteSettings->get('stat_satisfaction', '98%'), 'Taux de satisfaction', 'bg-green-50 text-green-600'],
                        [$siteSettings->get('stat_formations', '500+'), 'Formations dispensées', 'bg-blue-50 text-blue-600'],
                        [$siteSettings->get('stat_years', '15+'), "Années d'expertise", 'bg-purple-50 text-purple-600'],
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

    <!-- Values -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-animate="fade-up">
                <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Ce qui nous anime</span>
                <h2 class="text-3xl font-bold text-gray-900 mt-2">Nos valeurs</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                    ['target', 'Engagement', "Nous nous investissons pleinement dans chaque mission avec rigueur et passion.", 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                    ['handshake', 'Proximité', "Une relation de confiance, directe et durable avec chacun de nos clients.", 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                    ['bulb', 'Innovation', "Des approches pédagogiques et méthodologiques en constante évolution.", 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
                    ['star', 'Excellence', "Des standards élevés de qualité à chaque étape de notre intervention.", 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                ] as $idx => [$icon, $title, $desc, $path])
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
