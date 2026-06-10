@if (config('services.recaptcha.site_key'))
    @assets
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
        <style>
            .grecaptcha-badge {
                visibility: hidden !important;
            }
        </style>
    @endassets
@endif

<div x-data x-init="Alpine.store('quoteNav', { dir: 1 })">

    {{-- HERO --}}
    <div class="relative overflow-hidden bg-brand-800 text-white py-4 sm:py-8">
        <div class="absolute inset-0 opacity-[0.06] pointer-events-none" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="quote-grid" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40V0H40" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#quote-grid)" />
            </svg>
        </div>
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-white/5 pointer-events-none"
            aria-hidden="true"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-1.5 text-xs text-white/50 mb-4" aria-label="Fil d'Ariane">
                <a href="{{ route('home') }}" class="hover:text-white/80 transition-colors">Accueil</a>
                <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-white/80">Demande de devis</span>
            </nav>
            <div class="max-w-2xl">
                <div
                    class="inline-flex items-center gap-2 bg-accent-600/25 border border-accent-400/40 rounded-full px-4 py-1.5 text-sm text-accent-400 font-medium mb-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Devis gratuit et sans engagement
                </div>
                <h1 class="text-xl sm:text-3xl font-bold leading-tight tracking-tight mb-2">Demande de devis</h1>
                <p class="text-white/70 text-base leading-relaxed">Décrivez votre projet en 3 étapes. Nous vous répondons
                    sous 24h avec une proposition personnalisée.</p>
                <div class="flex flex-wrap gap-x-8 gap-y-2 mt-4 pt-3 border-t border-white/15">
                    @foreach (['Réponse sous 24h', 'Étude personnalisée', 'Sans engagement'] as $trust)
                        <span class="flex items-center gap-2 text-sm text-white/70">
                            <svg class="w-4 h-4 text-accent-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $trust }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if ($submitted)
            {{-- Success state --}}
            <div class="bg-brand-50 border border-brand-200 rounded-2xl p-10 text-center overflow-hidden" x-data
                x-init="$el.animate([{ opacity: 0, transform: 'scale(0.92) translateY(12px)' }, { opacity: 1, transform: 'scale(1) translateY(0)' }], { duration: 400, easing: 'cubic-bezier(0.16,1,0.3,1)' })">

                {{-- Animated check circle --}}
                <div class="flex justify-center mb-6">
                    <div class="relative w-20 h-20">
                        <svg class="w-20 h-20 text-brand-100" viewBox="0 0 80 80" fill="currentColor">
                            <circle cx="40" cy="40" r="40" />
                        </svg>
                        <svg class="absolute inset-0 w-20 h-20 text-brand-600" viewBox="0 0 80 80" fill="none"
                            stroke="currentColor" stroke-width="4">
                            <circle cx="40" cy="40" r="36" stroke="currentColor" stroke-opacity="0.2" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M24 40l12 12 20-20"
                                style="stroke-dasharray:48;stroke-dashoffset:48;animation:drawCheck .55s cubic-bezier(.16,1,.3,1) .25s forwards" />
                        </svg>
                    </div>
                </div>

                <h2 class="text-xl font-semibold text-brand-800 mb-2"
                    style="opacity:0;animation:fadeUp .4s ease .5s forwards">Demande reçue !</h2>
                <p class="text-brand-700 max-w-sm mx-auto" style="opacity:0;animation:fadeUp .4s ease .65s forwards">
                    Votre demande de devis a bien été enregistrée. Notre équipe vous contactera sous 24 heures ouvrées
                    avec une proposition personnalisée.
                </p>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 mt-6 text-brand-600 hover:text-brand-700 font-medium text-sm transition-colors"
                    style="opacity:0;animation:fadeUp .4s ease .8s forwards">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Retour à l'accueil
                </a>
            </div>
        @else
            {{-- Diagnostic gratuit obligatoire --}}
            <div class="mb-8 rounded-2xl border border-amber-200 bg-amber-50 p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="shrink-0 w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-amber-900 text-sm sm:text-base mb-1">Diagnostic gratuit
                        obligatoire avant tout devis</h3>
                    <p class="text-amber-800 text-sm leading-relaxed">
                        Chez OBSEQUIUM, toute demande de devis est précédée d'un <strong>audit diagnostic
                            gratuit</strong>. Si vous n'avez pas encore bénéficié de ce diagnostic, merci de le
                        demander d'abord — c'est l'étape qui nous permet de vous proposer une offre adaptée et
                        chiffrée.
                    </p>
                </div>
                <a href="{{ route('diagnostic.request') }}"
                    class="shrink-0 inline-flex items-center justify-center gap-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold text-sm px-5 py-3 rounded-xl transition-colors whitespace-nowrap">
                    Demander mon diagnostic
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            {{-- Stepper --}}
            <div class="flex items-start w-full mb-10">
                @php $steps = ['Vos informations', 'Votre projet', 'Récapitulatif']; @endphp
                @foreach ($steps as $i => $label)
                    @php $stepNum = $i + 1; @endphp
                    <div class="flex flex-col items-center shrink-0">
                        <div
                            class="relative w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300
                        {{ $step > $stepNum
                            ? 'bg-accent-600 text-white shadow-sm'
                            : ($step === $stepNum
                                ? 'bg-brand-600 text-white'
                                : 'bg-white border-2 border-brand-100 text-brand-300') }}">
                            @if ($step === $stepNum)
                                <span
                                    class="absolute inset-0 rounded-full ring-4 ring-brand-100 transition-all duration-300"></span>
                            @endif
                            @if ($step > $stepNum)
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                {{ $stepNum }}
                            @endif
                        </div>
                        <span
                            class="text-xs font-semibold mt-2 text-center hidden sm:block transition-colors duration-300
                        {{ $step === $stepNum ? 'text-brand-600' : ($step > $stepNum ? 'text-accent-600' : 'text-brand-200') }}">
                            {{ $label }}
                        </span>
                    </div>
                    @if ($i < count($steps) - 1)
                        <div class="relative flex-1 h-0.5 mt-5 mx-2 bg-brand-100 overflow-hidden rounded-full">
                            <div class="absolute inset-y-0 left-0 bg-accent-600 transition-all duration-500 ease-out rounded-full"
                                style="width: {{ $step > $stepNum ? '100%' : '0%' }}"></div>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Step card with directional transition + staggered fields --}}
            <div wire:key="step-{{ $step }}" x-data x-init="$nextTick(() => {
                let d = Alpine.store('quoteNav')?.dir ?? 1;
                $el.animate(
                    [{ opacity: 0, transform: d > 0 ? 'translateX(20px)' : 'translateX(-20px)' },
                        { opacity: 1, transform: 'translateX(0)' }
                    ], { duration: 280, easing: 'cubic-bezier(0.16,1,0.3,1)' }
                );
                $el.querySelectorAll('[data-field]').forEach((el, i) => {
                    el.animate(
                        [{ opacity: 0, transform: 'translateY(10px)' }, { opacity: 1, transform: 'translateY(0)' }], { duration: 300, easing: 'cubic-bezier(0.16,1,0.3,1)', delay: 80 + i * 60, fill: 'backwards' }
                    );
                });
            });"
                class="bg-white rounded-2xl shadow-sm border border-brand-50 p-8">

                @if ($step === 1)
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="w-7 h-7 bg-brand-600 text-white rounded-lg flex items-center justify-center text-xs font-bold shrink-0">1</span>
                        <h2 class="text-lg font-semibold text-obq-anthracite">Vos informations</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div data-field>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet <span
                                        class="text-red-500">*</span></label>
                                <input wire:model="client_name" type="text"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200">
                                @error('client_name')
                                    <p class="text-red-500 text-xs mt-1 animate-[fadeUp_.2s_ease_forwards]">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                            <div data-field>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email professionnel <span
                                        class="text-red-500">*</span></label>
                                <input wire:model="client_email" type="email"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200">
                                @error('client_email')
                                    <p class="text-red-500 text-xs mt-1 animate-[fadeUp_.2s_ease_forwards]">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                            <div data-field>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                <input wire:model="client_phone" type="tel"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200">
                            </div>
                            <div data-field>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Société</label>
                                <input wire:model="client_company" type="text"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200">
                            </div>
                            <div class="sm:col-span-2" data-field>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fonction / Poste</label>
                                <input wire:model="client_job_title" type="text"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200">
                            </div>
                        </div>
                        <div class="flex justify-end pt-2" data-field>
                            <button wire:loading.attr="disabled"
                                @click="Alpine.store('quoteNav').dir = 1; $wire.nextStep()"
                                class="bg-accent-600 hover:bg-accent-400 disabled:opacity-60 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 active:scale-95 flex items-center gap-2 shadow-sm">
                                <span wire:loading.remove wire:target="nextStep">Suivant</span>
                                <svg wire:loading wire:target="nextStep" class="w-4 h-4 animate-spin" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                </svg>
                                <svg wire:loading.remove wire:target="nextStep" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if ($step === 2)
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="w-7 h-7 bg-brand-600 text-white rounded-lg flex items-center justify-center text-xs font-bold shrink-0">2</span>
                        <h2 class="text-lg font-semibold text-obq-anthracite">Votre projet</h2>
                    </div>
                    <div class="space-y-4">
                        <div data-field>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type de prestation <span
                                    class="text-red-500">*</span></label>
                            <select wire:model="service_type"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 bg-white transition-all duration-200">
                                <option value="">Sélectionnez...</option>
                                @foreach ($this->services as $service)
                                    <option value="{{ $service->type }}">{{ $service->title }}</option>
                                @endforeach
                                <option value="autre">Autre</option>
                            </select>
                            @error('service_type')
                                <p class="text-red-500 text-xs mt-1 animate-[fadeUp_.2s_ease_forwards]">
                                    {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div data-field>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Secteur d'activité</label>
                                <input wire:model="sector" type="text" placeholder="ex: Industrie, BTP, Santé…"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200">
                            </div>
                            <div data-field>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Taille de
                                    l'entreprise</label>
                                <select wire:model="company_size"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 bg-white transition-all duration-200">
                                    <option value="">Sélectionnez...</option>
                                    <option value="1-10">1 – 10 salariés</option>
                                    <option value="11-50">11 – 50 salariés</option>
                                    <option value="51-250">51 – 250 salariés</option>
                                    <option value="250+">250+ salariés</option>
                                </select>
                            </div>
                        </div>
                        <div data-field>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description du projet <span
                                    class="text-red-500">*</span></label>
                            <textarea wire:model="description" rows="6" placeholder="Décrivez vos besoins, vos objectifs, le contexte…"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200 resize-none"></textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1 animate-[fadeUp_.2s_ease_forwards]">
                                    {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-between pt-2" data-field>
                            <button wire:loading.attr="disabled"
                                @click="Alpine.store('quoteNav').dir = -1; $wire.prevStep()"
                                class="text-gray-500 hover:text-gray-700 disabled:opacity-60 font-medium px-4 py-3 rounded-xl transition-all duration-200 active:scale-95 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                                </svg>
                                Retour
                            </button>
                            <button wire:loading.attr="disabled"
                                @click="Alpine.store('quoteNav').dir = 1; $wire.nextStep()"
                                class="bg-accent-600 hover:bg-accent-400 disabled:opacity-60 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 active:scale-95 flex items-center gap-2 shadow-sm">
                                <span wire:loading.remove wire:target="nextStep">Récapitulatif</span>
                                <svg wire:loading wire:target="nextStep" class="w-4 h-4 animate-spin" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                </svg>
                                <svg wire:loading.remove wire:target="nextStep" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if ($step === 3)
                    <div class="flex items-center gap-3 mb-6">
                        <span
                            class="w-7 h-7 bg-brand-600 text-white rounded-lg flex items-center justify-center text-xs font-bold shrink-0">3</span>
                        <h2 class="text-lg font-semibold text-obq-anthracite">Récapitulatif</h2>
                    </div>
                    <div class="space-y-4 text-sm">
                        <div class="bg-brand-50 rounded-xl p-5 border border-brand-100" data-field>
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-4 h-4 text-brand-500 shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <h3 class="font-semibold text-brand-600 text-xs uppercase tracking-wider">Vos
                                    informations</h3>
                            </div>
                            <dl class="grid grid-cols-2 gap-x-4 gap-y-2 text-obq-anthracite">
                                <dt class="font-medium text-obq-muted">Nom</dt>
                                <dd class="font-medium">{{ $client_name }}</dd>
                                <dt class="font-medium text-obq-muted">Email</dt>
                                <dd class="truncate">{{ $client_email }}</dd>
                                @if ($client_phone)
                                    <dt class="font-medium text-obq-muted">Téléphone</dt>
                                    <dd>{{ $client_phone }}</dd>
                                @endif
                                @if ($client_company)
                                    <dt class="font-medium text-obq-muted">Société</dt>
                                    <dd>{{ $client_company }}</dd>
                                @endif
                                @if ($client_job_title)
                                    <dt class="font-medium text-obq-muted">Fonction</dt>
                                    <dd>{{ $client_job_title }}</dd>
                                @endif
                            </dl>
                        </div>
                        <div class="bg-accent-50 rounded-xl p-5 border border-accent-50" data-field>
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-4 h-4 text-accent-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <h3 class="font-semibold text-accent-600 text-xs uppercase tracking-wider">Votre projet
                                </h3>
                            </div>
                            <dl class="grid grid-cols-2 gap-x-4 gap-y-2 text-obq-anthracite">
                                @if ($service_type)
                                    <dt class="font-medium text-obq-muted">Prestation</dt>
                                    <dd>{{ $service_type }}</dd>
                                @endif
                                @if ($sector)
                                    <dt class="font-medium text-obq-muted">Secteur</dt>
                                    <dd>{{ $sector }}</dd>
                                @endif
                                @if ($company_size)
                                    <dt class="font-medium text-obq-muted">Taille</dt>
                                    <dd>{{ $company_size }}</dd>
                                @endif
                            </dl>
                            @if ($description)
                                <div class="mt-3 pt-3 border-t border-accent-100">
                                    <p class="font-medium text-obq-muted mb-1">Description</p>
                                    <p class="text-obq-anthracite whitespace-pre-wrap leading-relaxed">
                                        {{ $description }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="flex justify-between pt-2" data-field>
                            <button wire:loading.attr="disabled"
                                @click="Alpine.store('quoteNav').dir = -1; $wire.prevStep()"
                                class="text-gray-500 hover:text-gray-700 disabled:opacity-60 font-medium px-4 py-3 rounded-xl transition-all duration-200 active:scale-95 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                                </svg>
                                Modifier
                            </button>
                            <button wire:loading.attr="disabled"
                                @click="
                                @if (config('services.recaptcha.site_key')) grecaptcha.ready(async () => {
                                    try {
                                        const token = await grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'quote_submit' });
                                        await $wire.set('recaptchaToken', token);
                                    } catch(e) {}
                                    $wire.submit();
                                });
                                @else
                                $wire.submit(); @endif
                            "
                                class="bg-accent-600 hover:bg-accent-400 disabled:opacity-60 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 active:scale-95 flex items-center gap-2 shadow-sm">
                                <span wire:loading.remove wire:target="submit">Envoyer ma demande</span>
                                <svg wire:loading wire:target="submit" class="w-4 h-4 animate-spin" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                </svg>
                                <span wire:loading.remove wire:target="submit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        @endif
    </div>

    <style>
        @keyframes drawCheck {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(8px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }
    </style>
</div>
