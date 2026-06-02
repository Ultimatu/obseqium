<div
    class="bg-white rounded-2xl border {{ $featured ? 'border-accent-100 shadow-md' : 'border-brand-50 shadow-sm' }} overflow-hidden group flex flex-col card-lift transition-all duration-200">

    {{-- Image de couverture --}}
    @if ($reference->cover_image)
        <div class="aspect-video overflow-hidden relative">
            <img src="{{ Storage::url($reference->cover_image) }}" alt="{{ $reference->title }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            {{-- Overlay sombre --}}
            <div class="absolute inset-0 bg-linear-to-t from-black/70 via-black/20 to-transparent pointer-events-none">
            </div>
            {{-- Secteur overlay --}}
            @if ($reference->sector)
                <span
                    class="absolute top-3 left-3 bg-brand-600/90 backdrop-blur-sm text-white text-xs font-semibold px-2.5 py-1 rounded-lg">
                    {{ $reference->sector }}
                </span>
            @endif
            {{-- Badge vedette --}}
            @if ($featured)
                <span
                    class="absolute top-3 right-3 inline-flex items-center gap-1 bg-accent-600 text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    Vedette
                </span>
            @endif
        </div>
    @else
        {{-- Placeholder sans image --}}
        <div class="aspect-video bg-brand-50 flex items-center justify-center relative">
            <svg class="w-10 h-10 text-brand-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            @if ($reference->sector)
                <span
                    class="absolute top-3 left-3 bg-brand-600/90 text-white text-xs font-semibold px-2.5 py-1 rounded-lg">
                    {{ $reference->sector }}
                </span>
            @endif
        </div>
    @endif

    {{-- Contenu --}}
    <div class="p-6 flex flex-col flex-1">

        {{-- Logo + nom client --}}
        <div class="flex items-center gap-3 mb-4">
            @if ($reference->client_logo)
                <div
                    class="w-24 h-24 rounded-xl border border-brand-50 flex items-center justify-center bg-white overflow-hidden shrink-0">
                    <img src="{{ Storage::url($reference->client_logo) }}" alt="{{ $reference->client_name }}"
                        class="w-full h-full object-contain p-1 grayscale group-hover:grayscale-0 transition-all duration-300">
                </div>
            @endif
            <div class="min-w-0">
                @if ($reference->show_client_name)
                    <p class="font-semibold text-obq-anthracite text-sm truncate">{{ $reference->client_name }}</p>
                @endif
                @if ($reference->sector && !$reference->cover_image)
                    <p class="text-obq-muted text-xs truncate">{{ $reference->sector }}</p>
                @endif
            </div>
        </div>

        {{-- Titre --}}
        <h2
            class="font-bold text-obq-anthracite text-base leading-snug mb-3 group-hover:text-brand-600 transition-colors">
            {{ $reference->title }}
        </h2>

        {{-- Problématique --}}
        @if ($reference->challenge)
            <div class="mb-4 flex-1">
                <p class="text-xs font-semibold uppercase tracking-wider text-obq-muted mb-1">Problématique</p>
                <p class="text-obq-muted text-sm line-clamp-3 leading-relaxed">{{ strip_tags($reference->challenge) }}
                </p>
            </div>
        @else
            <div class="flex-1"></div>
        @endif

        {{-- Chiffres clés --}}
        @if ($reference->key_figures && count($reference->key_figures))
            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-brand-50 mb-5">
                @foreach (array_slice($reference->key_figures, 0, 4) as $label => $value)
                    <div class="text-center">
                        <p class="text-accent-600 font-bold text-lg leading-tight">{{ $value }}</p>
                        <p class="text-obq-muted text-xs mt-0.5">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
