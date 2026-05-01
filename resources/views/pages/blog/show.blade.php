<x-layouts.app :title="$post->meta_title ?? $post->title" :meta-description="$post->meta_description ?? $post->excerpt">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-brand-600">Accueil</a>
            <span class="mx-2">/</span>
            <a href="{{ route('blog.index') }}" class="hover:text-brand-600">Blog</a>
            @if($post->category)
            <span class="mx-2">/</span>
            <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-brand-600">{{ $post->category->name }}</a>
            @endif
            <span class="mx-2">/</span>
            <span class="text-gray-600">{{ Str::limit($post->title, 40) }}</span>
        </nav>

        <!-- Header -->
        <div class="mb-8">
            @if($post->category)
            <a href="{{ route('blog.category', $post->category->slug) }}" class="text-brand-600 text-sm font-semibold uppercase tracking-wider hover:text-brand-700 mb-3 inline-block">
                {{ $post->category->name }}
            </a>
            @endif
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                @if($post->author)
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-brand-100 rounded-full flex items-center justify-center">
                        <span class="text-brand-600 text-xs font-semibold">{{ substr($post->author->name, 0, 1) }}</span>
                    </div>
                    <span>{{ $post->author->name }}</span>
                </div>
                @endif
                @if($post->published_at)
                <span>{{ $post->published_at->format('d M Y') }}</span>
                @endif
                <span>{{ $post->views }} vues</span>
            </div>
        </div>

        @if($post->cover_image)
        <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}" class="w-full rounded-2xl max-h-96 object-cover mb-10">
        @endif

        <!-- Content -->
        <div class="prose prose-gray max-w-none prose-headings:font-semibold prose-a:text-brand-600 prose-img:rounded-xl prose-blockquote:border-brand-400 prose-blockquote:text-gray-600">
            {!! $post->content !!}
        </div>

        <!-- Tags -->
        @if($post->tags->count())
        <div class="mt-10 pt-6 border-t border-gray-100">
            <div class="flex flex-wrap gap-2">
                @foreach($post->tags as $tag)
                <span class="bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1 rounded-full">#{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Share / Nav -->
        <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-between">
            <a href="{{ route('blog.index') }}" class="flex items-center gap-2 text-brand-600 hover:text-brand-700 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                Retour au blog
            </a>
        </div>
    </div>

    <!-- Related articles -->
    @if($related->count())
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-8">Articles similaires</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($related as $article)
                <a href="{{ route('blog.show', $article->slug) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 hover:border-brand-200 transition-all">
                    @if($article->cover_image)
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ Storage::url($article->cover_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    @endif
                    <div class="p-5">
                        <h3 class="font-semibold text-gray-900 group-hover:text-brand-600 transition-colors line-clamp-2 mb-2">{{ $article->title }}</h3>
                        <p class="text-gray-500 text-sm line-clamp-2">{{ $article->excerpt }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-layouts.app>
