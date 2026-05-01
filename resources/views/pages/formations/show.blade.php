<x-layouts.app :title="$formation->title" :meta-description="$formation->meta_description ?? $formation->description">
    <div class="bg-gray-50 border-b border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-600">Accueil</a>
                <span class="mx-2">/</span>
                <a href="{{ route('formations.index') }}" class="hover:text-brand-600">Formations</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">{{ $formation->title }}</span>
            </nav>
            <div class="flex flex-wrap gap-2 mb-3">
                @if($formation->thematic)
                <span class="text-xs font-medium bg-brand-50 text-brand-700 px-2 py-0.5 rounded-full capitalize">{{ $formation->thematic }}</span>
                @endif
                @if($formation->format)
                <span class="text-xs font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full capitalize">{{ $formation->format }}</span>
                @endif
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">{{ $formation->title }}</h1>
            <p class="text-gray-500 mt-2 max-w-2xl">{{ $formation->description }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Main content -->
            <div class="lg:col-span-2 space-y-10">
                @if($formation->cover_image)
                <img src="{{ Storage::url($formation->cover_image) }}" alt="{{ $formation->title }}" class="w-full rounded-2xl max-h-80 object-cover">
                @endif

                @if($formation->objectives)
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Objectifs pédagogiques</h2>
                    <div class="prose prose-gray max-w-none text-sm">{!! $formation->objectives !!}</div>
                </div>
                @endif

                @if($formation->program)
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Programme</h2>
                    <div class="prose prose-gray max-w-none text-sm">{!! $formation->program !!}</div>
                </div>
                @endif

                @if($formation->target_audience)
                <div class="bg-brand-50 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-brand-800 mb-2">Public cible</h2>
                    <div class="prose prose-sm text-brand-700">{!! $formation->target_audience !!}</div>
                </div>
                @endif

                @if($formation->prerequisites)
                <div class="bg-amber-50 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-amber-800 mb-2">Prérequis</h2>
                    <div class="prose prose-sm text-amber-700">{!! $formation->prerequisites !!}</div>
                </div>
                @endif

                <!-- Sessions -->
                @if($sessions->count())
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Sessions disponibles</h2>
                    <div class="space-y-3">
                        @foreach($sessions as $session)
                        <div class="bg-white rounded-xl border border-gray-200 p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="space-y-1 text-sm">
                                <div class="font-medium text-gray-900">
                                    {{ $session->start_date->format('d M Y') }}
                                    @if($session->end_date)
                                    — {{ $session->end_date->format('d M Y') }}
                                    @endif
                                </div>
                                @if($session->city)
                                <div class="text-gray-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    {{ $session->city }}
                                </div>
                                @endif
                                <div class="text-gray-400">{{ $session->current_participants ?? 0 }}/{{ $session->max_participants }} places</div>
                            </div>
                            <a href="{{ route('appointments.book') }}" class="flex-shrink-0 bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                                S'inscrire
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Recap card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="font-semibold text-gray-900">Résumé</h3>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Durée : <strong>{{ $formation->duration_hours }}h</strong></span>
                        </li>
                        @if($formation->format)
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/></svg>
                            <span>Format : <strong class="capitalize">{{ $formation->format }}</strong></span>
                        </li>
                        @endif
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Tarif : <strong class="text-brand-600">{{ $formation->price_on_request ? 'Sur devis' : number_format($formation->price, 0, ',', ' ').' €' }}</strong></span>
                        </li>
                    </ul>

                    <a href="{{ route('appointments.book') }}" class="block text-center bg-brand-600 hover:bg-brand-700 text-white font-semibold px-4 py-3 rounded-xl transition-colors text-sm mt-2">
                        S'inscrire ou demander des infos
                    </a>
                    <a href="{{ route('quotes.request') }}" class="block text-center border border-brand-600 text-brand-600 hover:bg-brand-50 font-medium px-4 py-2.5 rounded-xl transition-colors text-sm">
                        Demander un devis intra
                    </a>
                </div>

                <a href="{{ route('formations.index') }}" class="flex items-center gap-2 text-brand-600 hover:text-brand-700 text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                    Retour au catalogue
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
