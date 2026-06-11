<div>
    <!-- Page header -->
    <div class="bg-gray-50 border-b border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-600">Accueil</a>
                <span class="mx-2">/</span>
                <a href="{{ route('formations.index') }}" class="hover:text-brand-600">Formations</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">Calendrier</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Calendrier des formations</h1>
            <p class="mt-2 text-gray-500">Consultez les prochaines sessions disponibles.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Month navigation -->
        <div class="flex items-center justify-between mb-8">
            <button wire:click="previousMonth"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-colors text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Mois précédent
            </button>

            <h2 class="text-xl font-bold text-gray-900 capitalize">
                {{ $monthStart->translatedFormat('F Y') }}
            </h2>

            <button wire:click="nextMonth"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-colors text-sm font-medium">
                Mois suivant
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Calendar grid -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <!-- Day headers -->
            <div class="grid grid-cols-7 bg-brand-600 text-white text-xs font-semibold uppercase tracking-wide">
                @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $dayName)
                    <div class="py-3 text-center">{{ $dayName }}</div>
                @endforeach
            </div>

            <!-- Weeks -->
            @foreach($weeks as $week)
                <div class="grid grid-cols-7 border-t border-gray-100">
                    @foreach($week as $cell)
                        <div class="min-h-[90px] p-2 border-r border-gray-100 last:border-r-0
                                    {{ ! $cell['isCurrentMonth'] ? 'bg-gray-50' : '' }}
                                    {{ $cell['date']->isToday() ? 'bg-brand-50' : '' }}">

                            <div class="text-xs font-semibold mb-1
                                        {{ ! $cell['isCurrentMonth'] ? 'text-gray-300' : ($cell['date']->isToday() ? 'text-brand-600' : 'text-gray-500') }}">
                                {{ $cell['date']->day }}
                            </div>

                            @foreach($cell['sessions'] as $session)
                                <a href="{{ route('formations.show', $session->formation->slug) }}"
                                   class="block text-[10px] leading-tight bg-brand-600 text-white rounded px-1.5 py-1 mb-1 hover:bg-brand-700 transition-colors truncate"
                                   title="{{ $session->formation->title }}{{ $session->city ? ' - '.$session->city : '' }}">
                                    {{ $session->formation->title }}
                                    @if($session->city)
                                        <span class="opacity-75">({{ $session->city }})</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <!-- Session list for the month -->
        @if($sessions->isNotEmpty())
            <div class="mt-10">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    Sessions ce mois-ci
                    <span class="text-base font-normal text-gray-400">({{ $sessions->count() }})</span>
                </h3>
                <div class="space-y-3">
                    @foreach($sessions as $session)
                        <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 w-12 text-center">
                                    <div class="text-xl font-bold text-brand-600">{{ $session->start_date->day }}</div>
                                    <div class="text-xs text-gray-400 uppercase">{{ $session->start_date->translatedFormat('M') }}</div>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $session->formation->title }}</div>
                                    <div class="text-sm text-gray-500 mt-0.5 flex items-center gap-3">
                                        @if($session->city)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                {{ $session->city }}
                                            </span>
                                        @endif
                                        @if($session->end_date && ! $session->start_date->isSameDay($session->end_date))
                                            <span>Au {{ $session->end_date->translatedFormat('d M') }}</span>
                                        @endif
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $session->available_spots }} place{{ $session->available_spots > 1 ? 's' : '' }} dispo
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('formations.show', $session->formation->slug) }}"
                               class="flex-shrink-0 inline-flex items-center gap-1.5 bg-brand-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-brand-700 transition-colors">
                                S'inscrire
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="mt-10 text-center py-16 bg-white rounded-2xl border border-gray-200">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-500 font-medium">Aucune session ce mois-ci.</p>
                <p class="text-gray-400 text-sm mt-1">Naviguez vers un autre mois ou contactez-nous.</p>
            </div>
        @endif
    </div>
</div>
