<x-layouts.app title="Nos services QHSE">
    <div class="bg-gray-50 border-b border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-600">Accueil</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">Services</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Nos services</h1>
            <p class="text-gray-500 mt-2 max-w-xl">Une offre complète pour répondre à tous vos besoins en matière de QHSE.</p>
        </div>
    </div>

    <!-- Filter tabs -->
    @if(request('type'))
    <div class="bg-white border-b border-gray-100 sticky top-[73px] z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-1 py-3 overflow-x-auto">
                <a href="{{ route('services.index') }}" class="flex-shrink-0 text-sm px-4 py-2 rounded-lg font-medium transition-colors text-gray-500 hover:bg-gray-100">Tous</a>
                @foreach(['audit' => 'Audit & Conseil', 'training' => 'Formation', 'qhse' => 'QHSE', 'strategic' => 'Stratégique'] as $val => $label)
                <a href="{{ route('services.index', ['type' => $val]) }}" class="flex-shrink-0 text-sm px-4 py-2 rounded-lg font-medium transition-colors {{ request('type') === $val ? 'bg-brand-600 text-white' : 'text-gray-500 hover:bg-gray-100' }}">{{ $label }}</a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @php
        $typeBadge = [
            'audit'     => 'bg-blue-100 text-blue-700',
            'training'  => 'bg-purple-100 text-purple-700',
            'qhse'      => 'bg-amber-100 text-amber-700',
            'strategic' => 'bg-green-100 text-green-700',
        ];
        $typeLabel = [
            'audit'     => 'Audit & Conseil',
            'training'  => 'Formation',
            'qhse'      => 'QHSE',
            'strategic' => 'Stratégique',
        ];
    @endphp

    <div class="bg-gray-50 min-h-[40vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            @if($services->isEmpty())
            <div class="text-center py-20 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Aucun service disponible.
            </div>
            @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                <a href="{{ route('services.show', $service->slug) }}"
                   data-animate="fade-up" data-delay="{{ $loop->index * 70 }}"
                   class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-gray-200 hover:border-brand-300 transition-all flex flex-col">
                    @if($service->image)
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    @else
                    <div class="aspect-video bg-gradient-to-br from-brand-50 to-brand-100 flex items-center justify-center">
                        @if($service->icon)
                        <span class="text-5xl">{{ $service->icon }}</span>
                        @endif
                    </div>
                    @endif
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-3">
                            <span class="inline-block text-xs font-semibold uppercase tracking-wider px-2.5 py-1 rounded-full {{ $typeBadge[$service->type] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $typeLabel[$service->type] ?? ucfirst($service->type ?? '') }}
                            </span>
                        </div>
                        <h2 class="font-semibold text-gray-900 mb-2 group-hover:text-brand-600 transition-colors text-lg">{{ $service->title }}</h2>
                        <p class="text-gray-600 text-sm leading-relaxed flex-1 line-clamp-4">{{ $service->description }}</p>
                        <div class="mt-5 flex items-center gap-1 text-brand-600 text-sm font-medium">
                            En savoir plus
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- CTA -->
    <section class="py-16 bg-brand-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-4">Besoin d'une prestation sur mesure ?</h2>
            <p class="text-brand-100 mb-8">Nous étudions chaque demande pour vous proposer la solution la plus adaptée.</p>
            <a href="{{ route('quotes.request') }}" class="inline-flex items-center gap-2 bg-white text-brand-700 hover:bg-brand-50 font-semibold px-8 py-3 rounded-xl transition-colors shadow">
                Demander un devis gratuit
            </a>
        </div>
    </section>
</x-layouts.app>
