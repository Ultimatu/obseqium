<x-layouts.app>
    {{-- Hero référence --}}
    <section class="relative py-20 bg-linear-to-br from-brand-600 to-brand-800 overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(#fff 1px, transparent 1px); background-size:20px 20px;"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-500/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-brand-400/20 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('references') }}" class="inline-flex items-center gap-2 text-brand-100 hover:text-white text-sm mb-6 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Retour aux références
            </a>

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div class="lg:max-w-2xl">
                    @if($reference->sector)
                    <span class="inline-block bg-white/10 backdrop-blur-sm text-white text-xs font-semibold uppercase tracking-wider px-3 py-1 rounded-full mb-4">
                        {{ $reference->sector }}
                    </span>
                    @endif
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">{{ $reference->title }}</h1>
                    @if($reference->show_client_name)
                    <p class="text-brand-100 text-lg mt-3">{{ $reference->client_name }}</p>
                    @endif
                </div>

                @if($reference->cover_image)
                <div class="lg:shrink-0">
                    <img src="{{ Storage::url($reference->cover_image) }}" alt="{{ $reference->title }}" class="w-full lg:w-80 h-48 lg:h-56 object-cover rounded-2xl shadow-2xl">
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Contenu détaillé --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-12">

                {{-- Colonne principale --}}
                <div class="lg:col-span-2 space-y-12">

                    @if($reference->challenge)
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </span>
                            Le défi
                        </h2>
                        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                            {{ $reference->challenge }}
                        </div>
                    </div>
                    @endif

                    @if($reference->solution)
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </span>
                            Notre solution
                        </h2>
                        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                            {{ $reference->solution }}
                        </div>
                    </div>
                    @endif

                    @if($reference->results)
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            Résultats
                        </h2>
                        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed bg-green-50/50 rounded-xl p-6 border border-green-100">
                            {{ $reference->results }}
                        </div>
                    </div>

                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 rounded-2xl p-6 sticky top-24">
                        <h3 class="font-bold text-gray-900 mb-6">Informations clés</h3>

                        @if($reference->key_figures)
                        <div class="space-y-4">
                            @foreach($reference->key_figures as $key => $value)
                            <div class="flex justify-between items-center pb-3 border-b border-gray-200 last:border-0">
                                <span class="text-gray-500 text-sm">{{ $key }}</span>
                                <span class="font-semibold text-gray-900">{{ $value }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('quotes.request') }}" class="w-full inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors">
                                Discuter de votre projet
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                            <p class="text-center text-gray-400 text-xs mt-3">Diagnostic gratuit inclus</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Navigation inter-références --}}
    <section class="py-12 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                @php
                $prevRef = \App\Models\Reference::where('order', '<', $reference->order)->where('is_active', true)->orderBy('order', 'desc')->first();
                $nextRef = \App\Models\Reference::where('order', '>', $reference->order)->where('is_active', true)->orderBy('order', 'asc')->first();
                @endphp

                @if($prevRef)
                <a href="{{ route('references.show', $prevRef->slug) }}" class="group flex items-center gap-4 text-left">
                    <span class="w-10 h-10 rounded-full bg-gray-100 group-hover:bg-brand-100 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                    <div>
                        <span class="text-gray-400 text-xs uppercase tracking-wider">Précédent</span>
                        <p class="font-semibold text-gray-900 group-hover:text-brand-600 transition-colors line-clamp-1">{{ $prevRef->client_name }}</p>
                    </div>
                </a>
                @else
                <div></div>
                @endif

                @if($nextRef)
                <a href="{{ route('references.show', $nextRef->slug) }}" class="group flex items-center gap-4 text-right">
                    <div>
                        <span class="text-gray-400 text-xs uppercase tracking-wider">Suivant</span>
                        <p class="font-semibold text-gray-900 group-hover:text-brand-600 transition-colors line-clamp-1">{{ $nextRef->client_name }}</p>
                    </div>
                    <span class="w-10 h-10 rounded-full bg-gray-100 group-hover:bg-brand-100 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </a>
                @endif
            </div>
        </div>
    </section>

</x-layouts.app>
