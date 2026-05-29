<x-layouts.app :title="$pricing->hero_title">
    <!-- Hero -->
    <div class="bg-gradient-to-br from-brand-950 to-brand-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-brand-300 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white">Accueil</a>
                <span class="mx-2">/</span>
                <span class="text-brand-100">{{ $pricing->hero_title }}</span>
            </nav>
            <div class="max-w-3xl">
                <h1 class="text-4xl sm:text-5xl font-bold mb-6">{{ $pricing->hero_title }}</h1>
                @if($pricing->hero_description)
                <p class="text-xl text-brand-100 leading-relaxed">
                    {{ $pricing->hero_description }}
                </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Key principle -->
    <section class="py-16 bg-emerald-50 border-b border-emerald-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border-2 border-emerald-200 p-8 sm:p-10 shadow-sm">
                <div class="flex items-start gap-5">
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $pricing->pricing_principle_title }}</h2>
                        @if($pricing->pricing_principle_content)
                        <div class="prose prose-gray max-w-none">
                            {!! $pricing->pricing_principle_content !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Critères de tarification -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-animate="fade-up">
                <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Comment nous chiffrons</span>
                <h2 class="text-3xl font-bold text-gray-900 mt-2 mb-4">Critères de tarification</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">{{ count($pricing->criteria ?? []) }} paramètres pris en compte pour établir une cotation juste et précise.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pricing->criteria ?? [] as $idx => $criterion)
                <div data-animate="fade-up" data-delay="{{ $idx * 60 }}"
                     class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md hover:border-brand-200 transition-all">
                    <div class="w-10 h-10 bg-brand-50 rounded-xl flex items-center justify-center mb-4">
                        <span class="text-brand-600 font-bold">{{ $idx + 1 }}</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $criterion['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $criterion['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Modalités de paiement -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-start">
                <div data-animate="fade-right">
                    <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">Paiement</span>
                    <h2 class="text-3xl font-bold text-gray-900 mt-2 mb-6">Modalités de paiement flexibles</h2>
                    @if($pricing->payment_terms)
                    <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                        {!! $pricing->payment_terms !!}
                    </div>
                    @endif
                </div>
                <div data-animate="fade-left" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <p class="text-sm text-brand-600 font-semibold uppercase tracking-wider mb-3">Exemple chiffré</p>
                    <p class="text-gray-700 leading-relaxed mb-6">Pour une mission de <strong>{{ number_format($pricing->example_total_amount, 0, ',', ' ') }} FCFA sur {{ $pricing->example_duration_months }} mois</strong>, paiement mensuel de :</p>
                    <div class="bg-gradient-to-br from-brand-600 to-brand-800 rounded-xl p-6 text-white text-center">
                        <p class="text-4xl sm:text-5xl font-bold">{{ number_format($pricing->monthly_amount, 0, ',', ' ') }}</p>
                        <p class="text-brand-200 mt-1">FCFA / mois</p>
                    </div>
                    <p class="text-xs text-gray-400 mt-4">Exemple illustratif. Le montant final dépend de votre contexte et des résultats du diagnostic.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Inclus / Exclus -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8">
                <div class="bg-emerald-50 rounded-2xl p-8 border border-emerald-200" data-animate="fade-right">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Inclus dans l'offre</h2>
                    </div>
                    <ul class="space-y-3">
                        @foreach($pricing->includes ?? [] as $item => $detail)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <div>
                                <span class="text-gray-700">{{ $item }}</span>
                                @if($detail)
                                <p class="text-sm text-gray-500">{{ $detail }}</p>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-rose-50 rounded-2xl p-8 border border-rose-200" data-animate="fade-left">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Exclusions</h2>
                    </div>
                    <ul class="space-y-3">
                        @foreach($pricing->excludes ?? [] as $item => $detail)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            <div>
                                <span class="text-gray-700">{{ $item }}</span>
                                @if($detail)
                                <p class="text-sm text-gray-500">{{ $detail }}</p>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <p class="text-sm text-gray-500 mt-6 italic">Ces éléments restent à la charge du client et sont gérés en toute transparence dès la phase de cadrage.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Processus de commande -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-animate="fade-up">
                <span class="text-brand-600 font-semibold text-sm uppercase tracking-wider">De A à Z</span>
                <h2 class="text-3xl font-bold text-gray-900 mt-2 mb-4">Processus de passation de commande</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach($pricing->process_steps ?? [] as $idx => $step)
                <div data-animate="fade-up" data-delay="{{ $idx * 80 }}" class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                    <div class="w-10 h-10 bg-brand-600 text-white rounded-full flex items-center justify-center font-bold mx-auto mb-3">{{ $idx + 1 }}</div>
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $step['title'] }}</h3>
                    <p class="text-xs text-gray-500">{{ $step['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Remises de lancement -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-brand-600 to-brand-800 rounded-2xl p-8 sm:p-10 text-white text-center" data-animate="zoom-in">
                <div class="inline-flex items-center gap-2 bg-white/15 rounded-full px-4 py-1.5 text-sm font-medium mb-4">
                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                    {{ $pricing->offer_title }}
                </div>
                @if($pricing->offer_content)
                <div class="prose prose-invert max-w-2xl mx-auto text-brand-100">
                    {!! $pricing->offer_content !!}
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-brand-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate="zoom-in">
            <h2 class="text-3xl font-bold text-white mb-4">Obtenez votre cotation personnalisée</h2>
            <p class="text-brand-100 mb-8 text-lg">Le diagnostic est gratuit et sans engagement. Vous repartez avec un rapport et une estimation chiffrée.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('quotes.request') }}" class="inline-flex items-center gap-2 bg-white text-brand-700 hover:bg-brand-50 font-semibold px-8 py-3 rounded-xl transition-colors shadow">
                    Demander un diagnostic gratuit
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 border border-white/40 text-white hover:bg-white/10 font-semibold px-8 py-3 rounded-xl transition-colors">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
