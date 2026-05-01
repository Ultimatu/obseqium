<x-layouts.app :title="$service->title" :meta-description="$service->meta_description ?? $service->description">
    <div class="bg-gray-50 border-b border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-600">Accueil</a>
                <span class="mx-2">/</span>
                <a href="{{ route('services.index') }}" class="hover:text-brand-600">Services</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">{{ $service->title }}</span>
            </nav>
            <div class="flex items-start gap-4">
                @if($service->icon)
                <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <span class="text-3xl">{{ $service->icon }}</span>
                </div>
                @endif
                <div>
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider px-2.5 py-0.5 rounded-full mb-2
                        {{ match($service->type) { 'conseil' => 'bg-blue-50 text-blue-700', 'formation' => 'bg-purple-50 text-purple-700', 'accompagnement' => 'bg-amber-50 text-amber-700', default => 'bg-gray-100 text-gray-600' } }}">
                        {{ ucfirst($service->type ?? '') }}
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">{{ $service->title }}</h1>
                    <p class="text-gray-500 mt-2 max-w-2xl">{{ $service->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Content -->
            <div class="lg:col-span-2 space-y-10">
                @if($service->image)
                <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" class="w-full rounded-2xl object-cover max-h-80">
                @endif

                @if($service->content)
                <div class="prose prose-gray max-w-none prose-headings:font-semibold prose-a:text-brand-600">
                    {!! $service->content !!}
                </div>
                @endif

                @if($service->methodology && count($service->methodology))
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Notre méthodologie</h2>
                    <div class="space-y-3">
                        @foreach($service->methodology as $step => $detail)
                        <div class="flex items-start gap-3 bg-brand-50 rounded-xl p-4">
                            <div class="w-7 h-7 bg-brand-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-xs font-bold">{{ $loop->iteration }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-brand-900 text-sm">{{ is_string($step) ? $step : $detail }}</p>
                                @if(is_array($detail) || (is_string($step) && is_string($detail) && $step !== $detail))
                                <p class="text-brand-700 text-sm mt-0.5">{{ is_array($detail) ? implode(', ', $detail) : $detail }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($service->deliverables && count($service->deliverables))
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Livrables</h2>
                    <ul class="space-y-2">
                        @foreach($service->deliverables as $deliverable)
                        <li class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-brand-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ is_array($deliverable) ? implode(' — ', $deliverable) : $deliverable }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div class="bg-brand-600 text-white rounded-2xl p-6">
                    <h3 class="font-semibold mb-2">Intéressé par ce service ?</h3>
                    <p class="text-brand-100 text-sm mb-5">Obtenez une estimation gratuite pour votre projet.</p>
                    <a href="{{ route('quotes.request') }}" class="block text-center bg-white text-brand-700 hover:bg-brand-50 font-semibold px-4 py-3 rounded-xl transition-colors text-sm">
                        Demander un devis
                    </a>
                    <a href="{{ route('appointments.book') }}" class="block text-center mt-3 border border-white/30 text-white hover:bg-white/10 font-medium px-4 py-2.5 rounded-xl transition-colors text-sm">
                        Prendre rendez-vous
                    </a>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 space-y-3">
                    <h3 class="font-semibold text-gray-900 text-sm">Retour aux services</h3>
                    <a href="{{ route('services.index') }}" class="flex items-center gap-2 text-brand-600 hover:text-brand-700 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Tous les services
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
