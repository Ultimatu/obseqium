<x-layouts.app :title="'Blog — '.$category->name">
    <div class="bg-gray-50 border-b border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-600">Accueil</a>
                <span class="mx-2">/</span>
                <a href="{{ route('blog.index') }}" class="hover:text-brand-600">Blog</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">{{ $category->name }}</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">{{ $category->name }}</h1>
            @if($category->description)
            <p class="text-gray-500 mt-2">{{ $category->description }}</p>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($posts->isEmpty())
        <div class="text-center py-20 text-gray-400">Aucun article dans cette catégorie.</div>
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
                    <h2 class="font-semibold text-gray-900 mb-2 group-hover:text-brand-600 transition-colors line-clamp-2 flex-1">{{ $post->title }}</h2>
                    <p class="text-gray-500 text-sm line-clamp-2">{{ $post->excerpt }}</p>
                    <div class="mt-4 flex items-center gap-3 text-xs text-gray-400">
                        <span>{{ $post->published_at?->format('d M Y') }}</span>
                        @if($post->author)<span>•</span><span>{{ $post->author->name }}</span>@endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $posts->links() }}</div>
        @endif
    </div>
</x-layouts.app>
