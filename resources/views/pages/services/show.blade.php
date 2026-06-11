<x-layouts.app :title="$service->title" :meta-description="$service->meta_description ?? $service->description">

    @php
    $typeConfig = match($service->type) {
        'audit'     => ['label' => 'Audit & Contrôle',    'bg' => 'bg-blue-50',   'text' => 'text-blue-700',   'badge' => 'bg-blue-100 text-blue-800',   'hero' => 'from-blue-900 via-blue-800 to-brand-700'],
        'training'  => ['label' => 'Formation',            'bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'badge' => 'bg-purple-100 text-purple-800', 'hero' => 'from-purple-900 via-purple-800 to-brand-700'],
        'qhse'      => ['label' => 'Accompagnement QHSE', 'bg' => 'bg-amber-50',  'text' => 'text-amber-700',  'badge' => 'bg-amber-100 text-amber-800',   'hero' => 'from-amber-900 via-brand-900 to-brand-700'],
        'strategic' => ['label' => 'Conseil stratégique', 'bg' => 'bg-teal-50',   'text' => 'text-teal-700',   'badge' => 'bg-teal-100 text-teal-800',     'hero' => 'from-teal-900 via-teal-800 to-brand-700'],
        default     => ['label' => ucfirst($service->type ?? ''), 'bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'badge' => 'bg-gray-100 text-gray-700', 'hero' => 'from-brand-950 via-brand-800 to-brand-600'],
    };
    @endphp

    {{-- ── Hero ──────────────────────────────────────────────────────── --}}
    <section class="relative text-white overflow-hidden">
        @if($service->image)
        <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('{{ Storage::url($service->image) }}')"></div>
        <div class="absolute inset-0 bg-linear-to-r from-black/80 via-black/60 to-black/30"></div>
        @else
        <div class="absolute inset-0 bg-linear-to-br {{ $typeConfig['hero'] }}"></div>
        @endif
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.04\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>

        <div class="relative py-20 lg:py-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="text-sm text-white/60 mb-6 flex items-center gap-2">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Accueil</a>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <a href="{{ route('services.index') }}" class="hover:text-white transition-colors">Services</a>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-white/80">{{ $service->title }}</span>
                </nav>

                <div class="max-w-3xl">
                    <div class="flex items-center gap-3 mb-5">
                        @if($service->icon)
                        <div class="w-14 h-14 bg-white/15 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/20">
                            <span class="text-3xl">{{ $service->icon }}</span>
                        </div>
                        @endif
                        <span class="inline-block text-xs font-semibold uppercase tracking-wider px-3 py-1 rounded-full bg-white/15 border border-white/20">
                            {{ $typeConfig['label'] }}
                        </span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-4">{{ $service->title }}</h1>
                    <p class="text-lg text-white/80 leading-relaxed max-w-2xl">{{ $service->description }}</p>

                    <div class="flex flex-wrap gap-3 mt-8">
                        <a href="{{ route('quotes.request') }}" class="inline-flex items-center gap-2 bg-white text-brand-700 hover:bg-brand-50 font-semibold px-5 py-3 rounded-xl transition-colors shadow-lg text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Demander un devis gratuit
                        </a>
                        <a href="{{ route('appointments.book') }}" class="inline-flex items-center gap-2 border border-white/30 hover:bg-white/10 font-medium px-5 py-3 rounded-xl transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Prendre rendez-vous
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Body ───────────────────────────────────────────────────────── --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-3 gap-12 items-start">

            {{-- Main column --}}
            <div class="lg:col-span-2 space-y-12">

                @if($service->content)
                <div class="prose prose-gray prose-lg max-w-none prose-headings:font-semibold prose-headings:text-gray-900 prose-a:text-brand-600 prose-strong:text-gray-900">
                    {!! $service->content !!}
                </div>
                @endif

                @if($service->methodology && count($service->methodology))
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-brand-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Notre méthodologie</h2>
                    </div>
                    <div class="space-y-4">
                        @foreach($service->methodology as $step)
                        <div class="flex gap-4 p-5 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-brand-100 transition-all">
                            <div class="w-9 h-9 bg-brand-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-white text-sm font-bold">{{ $loop->iteration }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ is_string($step) ? $step : (is_array($step) ? ($step['title'] ?? implode(' ', $step)) : $step) }}</p>
                                @if(is_array($step) && isset($step['description']))
                                <p class="text-gray-500 text-sm mt-1">{{ $step['description'] }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($service->deliverables && count($service->deliverables))
                <div class="bg-brand-50 rounded-2xl p-8 border border-brand-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-brand-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Livrables</h2>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($service->deliverables as $deliverable)
                        <div class="flex items-start gap-3 bg-white rounded-xl p-4 border border-brand-100">
                            <div class="w-6 h-6 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-sm font-medium text-gray-800">{{ is_array($deliverable) ? implode(' - ', $deliverable) : $deliverable }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            {{-- Sidebar --}}
            <div class="space-y-6 lg:sticky lg:top-8">

                <div class="bg-linear-to-br from-brand-600 to-brand-800 text-white rounded-2xl p-6 shadow-lg shadow-brand-900/20">
                    <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <h3 class="font-bold text-lg mb-1">Intéressé par ce service ?</h3>
                    <p class="text-brand-100 text-sm mb-5 leading-relaxed">Obtenez une estimation gratuite et personnalisée pour votre projet.</p>
                    <a href="{{ route('quotes.request') }}" class="block text-center bg-white text-brand-700 hover:bg-brand-50 font-semibold px-4 py-3 rounded-xl transition-colors text-sm mb-3">
                        Demander un devis gratuit
                    </a>
                    <a href="{{ route('appointments.book') }}" class="block text-center border border-white/30 text-white hover:bg-white/10 font-medium px-4 py-2.5 rounded-xl transition-colors text-sm">
                        Prendre rendez-vous
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
                    <h3 class="font-bold text-gray-900">Ce service inclut</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-brand-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Expertise certifiée QHSE
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-brand-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Accompagnement personnalisé
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-brand-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Rapports & livrables détaillés
                        </li>
                        <li class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-brand-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            Suivi post-mission
                        </li>
                    </ul>
                </div>

                @if($relatedServices->count())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Services similaires</h3>
                    <div class="space-y-3">
                        @foreach($relatedServices as $related)
                        <a href="{{ route('services.show', $related->slug) }}" class="flex items-center gap-3 group">
                            @if($related->icon)
                            <div class="w-9 h-9 bg-brand-50 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-brand-100 transition-colors">
                                <span class="text-lg">{{ $related->icon }}</span>
                            </div>
                            @endif
                            <span class="text-sm font-medium text-gray-700 group-hover:text-brand-600 transition-colors leading-tight">{{ $related->title }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <a href="{{ route('services.index') }}" class="flex items-center gap-2 text-brand-600 hover:text-brand-700 text-sm font-medium px-4 py-3 rounded-xl border border-brand-100 bg-brand-50 hover:bg-brand-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                    Voir tous les services
                </a>
            </div>
        </div>
    </div>

</x-layouts.app>
