<x-layouts.app title="Nos références clients">
    <div class="bg-gray-50 border-b border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-600">Accueil</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">Références</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Nos références</h1>
            <p class="text-gray-500 mt-2 max-w-xl">Entreprises qui nous ont fait confiance pour leurs projets QHSE.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($references->isEmpty())
        <div class="text-center py-20 text-gray-400">Aucune référence publiée pour le moment.</div>
        @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($references as $reference)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group">
                @if($reference->cover_image)
                <div class="aspect-video overflow-hidden">
                    <img src="{{ Storage::url($reference->cover_image) }}" alt="{{ $reference->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        @if($reference->client_logo)
                        <img src="{{ Storage::url($reference->client_logo) }}" alt="{{ $reference->client_name }}" class="h-8 object-contain grayscale">
                        @endif
                        <div>
                            @if($reference->show_client_name)
                            <p class="font-semibold text-gray-900 text-sm">{{ $reference->client_name }}</p>
                            @endif
                            @if($reference->sector)
                            <p class="text-gray-400 text-xs">{{ $reference->sector }}</p>
                            @endif
                        </div>
                    </div>
                    <h2 class="font-semibold text-gray-900 mb-3">{{ $reference->title }}</h2>
                    @if($reference->challenge)
                    <div class="mb-3">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Problématique</p>
                        <p class="text-gray-600 text-sm line-clamp-3">{{ strip_tags($reference->challenge) }}</p>
                    </div>
                    @endif
                    @if($reference->key_figures && count($reference->key_figures))
                    <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-2 gap-3">
                        @foreach(array_slice($reference->key_figures, 0, 4) as $label => $value)
                        <div class="text-center">
                            <p class="text-brand-600 font-bold text-lg">{{ $value }}</p>
                            <p class="text-gray-400 text-xs">{{ $label }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- CTA -->
    <section class="py-16 bg-brand-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-4">Votre projet pourrait être notre prochaine référence</h2>
            <p class="text-brand-100 mb-8">Discutons de vos enjeux et construisons ensemble une solution adaptée.</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-white text-brand-700 hover:bg-brand-50 font-semibold px-8 py-3 rounded-xl transition-colors shadow">
                Nous contacter
            </a>
        </div>
    </section>
</x-layouts.app>
