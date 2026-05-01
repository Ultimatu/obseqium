<x-layouts.app title="Blog & Actualités QHSE">
    <div class="bg-gray-50 border-b border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-600">Accueil</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">Blog</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Blog & Actualités</h1>
            <p class="text-gray-500 mt-2">Expertises, guides pratiques et veille réglementaire QHSE.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-4 gap-10">
            <!-- Articles -->
            <div class="lg:col-span-3">
                <!-- Search -->
                <form method="GET" class="mb-8 flex gap-2">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un article..." class="flex-1 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-3 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>

                @if($posts->isEmpty())
                <div class="text-center py-20 text-gray-400">Aucun article trouvé.</div>
                @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 hover:border-brand-200 transition-all flex flex-col">
                        @if($post->cover_image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        @endif
                        <div class="p-5 flex-1 flex flex-col">
                            @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}" class="text-brand-600 text-xs font-semibold uppercase tracking-wider hover:text-brand-700" wire:navigate>{{ $post->category->name }}</a>
                            @endif
                            <h2 class="font-semibold text-gray-900 mt-1 mb-2 group-hover:text-brand-600 transition-colors line-clamp-2 flex-1">{{ $post->title }}</h2>
                            <p class="text-gray-500 text-sm line-clamp-2">{{ $post->excerpt }}</p>
                            <div class="mt-4 flex items-center gap-3 text-xs text-gray-400">
                                <span>{{ $post->published_at?->format('d M Y') }}</span>
                                @if($post->author)
                                <span>•</span>
                                <span>{{ $post->author->name }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4 text-sm uppercase tracking-wider">Catégories</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('blog.index') }}" class="flex items-center justify-between text-sm text-gray-600 hover:text-brand-600 py-1">
                                <span>Tous les articles</span>
                                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full">{{ $posts->total() }}</span>
                            </a>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('blog.category', $category->slug) }}" class="flex items-center justify-between text-sm text-gray-600 hover:text-brand-600 py-1">
                                <span>{{ $category->name }}</span>
                                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full">{{ $category->posts_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-brand-50 rounded-2xl p-5 border border-brand-100">
                    <h3 class="font-semibold text-brand-800 mb-2 text-sm">Newsletter QHSE</h3>
                    <p class="text-brand-700 text-xs mb-3">Recevez notre veille réglementaire chaque mois.</p>
                    <a href="#newsletter" class="block text-center bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                        S'inscrire
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
