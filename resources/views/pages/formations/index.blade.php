<x-layouts.app title="Catalogue formations QHSE">
    <div class="bg-gray-50 border-b border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-600">Accueil</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">Formations</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Catalogue des formations</h1>
            <p class="text-gray-500 mt-2 max-w-xl">Formations certifiantes et professionnelles en QHSE, dispensées par nos experts.</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white border-b border-gray-100 sticky top-[73px] z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <form method="GET" class="flex flex-wrap gap-3 items-center">
                <select name="thematic" onchange="this.form.submit()" class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <option value="">Toutes les thématiques</option>
                    <option value="qualite" {{ request('thematic') === 'qualite' ? 'selected' : '' }}>Qualité</option>
                    <option value="securite" {{ request('thematic') === 'securite' ? 'selected' : '' }}>Sécurité</option>
                    <option value="environnement" {{ request('thematic') === 'environnement' ? 'selected' : '' }}>Environnement</option>
                    <option value="hygiene" {{ request('thematic') === 'hygiene' ? 'selected' : '' }}>Hygiène</option>
                    <option value="management" {{ request('thematic') === 'management' ? 'selected' : '' }}>Management</option>
                    <option value="reglementation" {{ request('thematic') === 'reglementation' ? 'selected' : '' }}>Réglementation</option>
                </select>
                <select name="format" onchange="this.form.submit()" class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <option value="">Tous les formats</option>
                    <option value="presentiel" {{ request('format') === 'presentiel' ? 'selected' : '' }}>Présentiel</option>
                    <option value="distanciel" {{ request('format') === 'distanciel' ? 'selected' : '' }}>Distanciel</option>
                    <option value="mixte" {{ request('format') === 'mixte' ? 'selected' : '' }}>Mixte</option>
                </select>
                @if(request('thematic') || request('format'))
                <a href="{{ route('formations.index') }}" class="text-sm text-gray-400 hover:text-brand-600 underline">Réinitialiser</a>
                @endif
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($formations->isEmpty())
        <div class="text-center py-20 text-gray-400">
            Aucune formation disponible avec ces critères.
        </div>
        @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($formations as $formation)
            <a href="{{ route('formations.show', $formation->slug) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 hover:border-brand-200 transition-all flex flex-col">
                @if($formation->cover_image)
                <div class="aspect-video overflow-hidden">
                    <img src="{{ Storage::url($formation->cover_image) }}" alt="{{ $formation->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                @else
                <div class="aspect-video bg-gradient-to-br from-brand-50 to-brand-100 flex items-center justify-center">
                    <svg class="w-14 h-14 text-brand-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                @endif

                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex flex-wrap gap-2 mb-3">
                        @if($formation->thematic)
                        <span class="text-xs font-medium bg-brand-50 text-brand-700 px-2 py-0.5 rounded-full capitalize">{{ $formation->thematic }}</span>
                        @endif
                        @if($formation->format)
                        <span class="text-xs font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full capitalize">{{ $formation->format }}</span>
                        @endif
                        @if($formation->is_featured)
                        <span class="text-xs font-medium bg-amber-50 text-amber-700 px-2 py-0.5 rounded-full">⭐ À la une</span>
                        @endif
                    </div>
                    <h2 class="font-semibold text-gray-900 mb-2 group-hover:text-brand-600 transition-colors line-clamp-2">{{ $formation->title }}</h2>
                    <p class="text-gray-500 text-sm line-clamp-3 flex-1">{{ $formation->description }}</p>

                    <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between text-sm">
                        <div class="flex items-center gap-3 text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $formation->duration_hours }}h
                            </span>
                        </div>
                        <span class="font-semibold text-brand-600">
                            {{ $formation->price_on_request ? 'Sur devis' : number_format($formation->price, 0, ',', ' ').' €' }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</x-layouts.app>
