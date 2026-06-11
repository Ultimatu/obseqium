<div class="min-h-screen bg-obq-page">

    {{-- HERO --}}
    <div class="relative overflow-hidden bg-brand-800 text-white py-4 sm:py-8">
        <div class="absolute inset-0 opacity-[0.06] pointer-events-none" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="diag-grid" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40V0H40" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#diag-grid)" />
            </svg>
        </div>
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-white/5 pointer-events-none"
            aria-hidden="true"></div>
        <div class="absolute right-16 bottom-0 w-32 h-32 rounded-full bg-accent-600/20 pointer-events-none"
            aria-hidden="true"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="inline-flex items-center gap-2 bg-accent-600/25 border border-accent-400/40 rounded-full px-4 py-1.5 text-sm text-accent-400 font-medium mb-5">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Diagnostic 100% gratuit
            </div>
            <h1 class="text-xl sm:text-3xl font-bold leading-tight tracking-tight mb-1">Diagnostic ISO gratuit</h1>
            <p class="text-white/70 leading-relaxed max-w-2xl">Évaluez votre niveau de conformité sans
                engagement. Notre équipe d'experts analyse votre organisation et vous remet un rapport détaillé avec
                recommandations.</p>
            <div class="flex flex-wrap gap-x-8 gap-y-2 mt-8 pt-7 border-t border-white/15">
                @foreach (['Sans engagement', 'Rapport détaillé', 'Réponse sous 24-48h'] as $trust)
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

    <div class="max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8">

        @if ($submitted)
            {{-- Success Message --}}
            <div class="bg-white rounded-2xl shadow-sm border border-brand-50 p-10 text-center" x-data
                x-init="$el.animate([{ opacity: 0, transform: 'scale(0.92) translateY(12px)' }, { opacity: 1, transform: 'scale(1) translateY(0)' }], { duration: 400, easing: 'cubic-bezier(0.16,1,0.3,1)' })">
                <div class="flex justify-center mb-6">
                    <div class="relative w-20 h-20">
                        <svg class="w-20 h-20 text-brand-100" viewBox="0 0 80 80" fill="currentColor">
                            <circle cx="40" cy="40" r="40" />
                        </svg>
                        <svg class="absolute inset-0 w-20 h-20 text-accent-600" viewBox="0 0 80 80" fill="none"
                            stroke="currentColor" stroke-width="4">
                            <circle cx="40" cy="40" r="36" stroke="currentColor" stroke-opacity="0.2" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M24 40l12 12 20-20"
                                style="stroke-dasharray:48;stroke-dashoffset:48;animation:drawCheck .55s cubic-bezier(.16,1,.3,1) .25s forwards" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-obq-anthracite mb-3"
                    style="opacity:0;animation:fadeUp .4s ease .5s forwards">Votre demande a bien été envoyée !</h2>
                <div class="inline-block bg-brand-50 border border-brand-100 rounded-xl px-6 py-3 mb-5"
                    style="opacity:0;animation:fadeUp .4s ease .6s forwards">
                    <p class="text-xs font-semibold uppercase tracking-widest text-obq-muted mb-1">Votre référence</p>
                    <p class="text-2xl font-bold text-brand-600">{{ $reference }}</p>
                </div>
                <p class="text-obq-muted max-w-lg mx-auto mb-6"
                    style="opacity:0;animation:fadeUp .4s ease .7s forwards">
                    Notre équipe vous contactera sous 24 à 48 heures pour planifier votre diagnostic. Un email de
                    confirmation vous a été envoyé.
                </p>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 mt-2 bg-accent-600 hover:bg-accent-400 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-150 shadow-sm"
                    style="opacity:0;animation:fadeUp .4s ease .85s forwards">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3v-5h4v5h3a1 1 0 001-1V10" />
                    </svg>
                    Retour à l'accueil
                </a>
            </div>
        @else
            {{-- Form --}}
            <div class="bg-white rounded-2xl shadow-sm border border-brand-50 overflow-hidden">

                {{-- Progress Bar --}}
                <div class="bg-brand-600 px-8 py-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-semibold text-white/90">Étape {{ $step }} sur 3</span>
                        <span
                            class="text-xs font-medium text-white/60 uppercase tracking-widest">{{ match ($step) {1 => 'Planification',2 => 'Votre entreprise',3 => 'Vos coordonnées'} }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        @for ($i = 1; $i <= 3; $i++)
                            <div
                                class="flex-1 h-1.5 rounded-full {{ $i <= $step ? 'bg-accent-400' : 'bg-white/20' }} transition-all duration-500">
                            </div>
                        @endfor
                    </div>
                </div>

                <form wire:submit="{{ $step === 3 ? 'submit' : 'nextStep' }}" class="p-8">
                    {{-- Step 1: Scheduling --}}
                    @if ($step === 1)
                        <div class="space-y-5">
                            <div class="flex items-center gap-3 mb-6">
                                <span
                                    class="w-7 h-7 bg-brand-600 text-white rounded-lg flex items-center justify-center text-xs font-bold shrink-0">1</span>
                                <h3 class="text-lg font-semibold text-obq-anthracite">Planification souhaitée</h3>
                            </div>

                            <div class="flex items-start gap-3 bg-brand-50 border border-brand-100 rounded-xl p-4">
                                <svg class="w-5 h-5 text-brand-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm text-brand-700">
                                    <strong>Information :</strong> Cette date est indicative. Notre équipe vous
                                    contactera pour confirmer la disponibilité.
                                </p>
                            </div>

                            {{-- Calendly-like Date & Time Picker --}}
                            <div class="border border-brand-50 rounded-xl overflow-hidden">
                                <div class="flex flex-col sm:flex-row">

                                    {{-- Calendar panel --}}
                                    <div
                                        class="p-5 sm:w-72 shrink-0 border-b sm:border-b-0 sm:border-r border-brand-50">
                                        {{-- Month navigation --}}
                                        <div class="flex items-center justify-between mb-4">
                                            <button type="button" wire:click="prevMonth"
                                                class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-brand-50 text-obq-muted hover:text-brand-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 19l-7-7 7-7" />
                                                </svg>
                                            </button>
                                            <span
                                                class="text-sm font-semibold text-obq-anthracite capitalize">{{ $monthLabel }}</span>
                                            <button type="button" wire:click="nextMonth"
                                                class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-brand-50 text-obq-muted hover:text-brand-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </button>
                                        </div>

                                        {{-- Day headers (Mon → Sun) --}}
                                        <div class="grid grid-cols-7 mb-1">
                                            @foreach (['L', 'M', 'M', 'J', 'V', 'S', 'D'] as $dow)
                                                <span
                                                    class="text-center text-xs font-medium text-obq-muted py-1">{{ $dow }}</span>
                                            @endforeach
                                        </div>

                                        {{-- Days grid --}}
                                        <div class="grid grid-cols-7 gap-y-0.5">
                                            @foreach ($calendarDays as $dayData)
                                                @if ($dayData === null)
                                                    <span></span>
                                                @elseif ($dayData['available'])
                                                    <button type="button"
                                                        wire:click="selectCalendarDate('{{ $dayData['date'] }}')"
                                                        class="w-8 h-8 mx-auto flex items-center justify-center text-sm rounded-full transition-all duration-150 {{ $dayData['selected'] ? 'bg-brand-600 text-white font-bold' : 'text-brand-600 font-semibold hover:bg-brand-600 hover:text-white' }}">
                                                        {{ $dayData['day'] }}
                                                    </button>
                                                @elseif ($dayData['booked'])
                                                    {{-- Déjà réservé : grisé avec point indicateur --}}
                                                    <span title="Date déjà réservée"
                                                        class="relative w-8 h-8 mx-auto flex items-center justify-center text-sm text-gray-300 cursor-not-allowed select-none">
                                                        {{ $dayData['day'] }}
                                                        <span
                                                            class="absolute bottom-0.5 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-gray-300"></span>
                                                    </span>
                                                @else
                                                    <span
                                                        class="w-8 h-8 mx-auto flex items-center justify-center text-sm text-gray-300 cursor-not-allowed select-none">
                                                        {{ $dayData['day'] }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>

                                        {{-- Timezone indicator --}}
                                        <div class="flex items-center gap-1.5 mt-4 pt-3 border-t border-brand-50">
                                            <svg class="w-3.5 h-3.5 text-obq-muted shrink-0" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                                            </svg>
                                            <span class="text-xs text-obq-muted">Heure d'Abidjan (GMT+0)</span>
                                        </div>
                                    </div>

                                    {{-- Time slots panel --}}
                                    @if ($requested_date)
                                        <div class="p-5 flex-1">
                                            <h5 class="font-semibold text-obq-anthracite capitalize mb-4">
                                                {{ $selectedDateLabel }}</h5>
                                            <div class="space-y-2">
                                                @foreach ($timeSlots as $slot)
                                                    @if ($pendingTime === $slot && $selectedTime !== $slot)
                                                        {{-- En attente de confirmation --}}
                                                        <div class="flex gap-2">
                                                            <span
                                                                class="flex-1 flex items-center justify-center px-3 py-2.5 rounded-xl bg-slate-700 text-white text-sm font-semibold">
                                                                {{ $slot }}
                                                            </span>
                                                            <button type="button" wire:click="confirmTime"
                                                                class="flex-1 px-3 py-2.5 rounded-xl bg-accent-600 hover:bg-accent-400 text-white text-sm font-semibold transition-all duration-150 active:scale-95">
                                                                Confirmer
                                                            </button>
                                                        </div>
                                                    @elseif ($selectedTime === $slot)
                                                        {{-- Créneau confirmé --}}
                                                        <div
                                                            class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-accent-50 border border-accent-400">
                                                            <svg class="w-4 h-4 text-accent-600 shrink-0"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            <span
                                                                class="text-sm font-semibold text-accent-700 flex-1">{{ $slot }}</span>
                                                            <button type="button"
                                                                wire:click="pickTime('{{ $slot }}')"
                                                                class="text-xs text-obq-muted hover:text-obq-anthracite transition-colors">Modifier</button>
                                                        </div>
                                                    @else
                                                        {{-- Créneau disponible --}}
                                                        <button type="button"
                                                            wire:click="pickTime('{{ $slot }}')"
                                                            class="w-full px-4 py-2.5 rounded-xl border border-brand-600 text-brand-600 text-sm font-semibold hover:bg-brand-600 hover:text-white transition-all duration-150">
                                                            {{ $slot }}
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @if ($selectedTime)
                                                <p class="mt-3 flex items-center gap-1.5 text-xs text-obq-muted">
                                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Créneau souhaité sélectionné
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        {{-- Placeholder --}}
                                        <div class="p-5 flex-1 flex items-center justify-center">
                                            <p class="text-sm text-obq-muted text-center leading-relaxed">
                                                Sélectionnez une date<br>pour voir les créneaux disponibles
                                            </p>
                                        </div>
                                    @endif

                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-obq-anthracite mb-1.5">Informations
                                    complémentaires</label>
                                <textarea wire:model="notes" rows="4"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200 resize-none"
                                    placeholder="Décrivez vos besoins spécifiques, contexte particulier, délais..."></textarea>
                            </div>
                        </div>
                    @endif

                    {{-- Step 2: Company Profile --}}
                    @if ($step === 2)
                        <div class="space-y-5">
                            <div class="flex items-center gap-3 mb-6">
                                <span
                                    class="w-7 h-7 bg-brand-600 text-white rounded-lg flex items-center justify-center text-xs font-bold shrink-0">2</span>
                                <h3 class="text-lg font-semibold text-obq-anthracite">Votre entreprise</h3>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-obq-anthracite mb-1.5">Secteur
                                        d'activité <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="sector"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200"
                                        placeholder="Industrie, Santé, BTP...">
                                    @error('sector')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-obq-anthracite mb-1.5">Taille de
                                        l'entreprise <span class="text-red-500">*</span></label>
                                    <select wire:model="company_size"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 bg-white transition-all duration-200">
                                        <option value="">Sélectionnez...</option>
                                        <option value="micro">Micro-entreprise (&lt; 10 pers.)</option>
                                        <option value="small">Petite entreprise (10-49 pers.)</option>
                                        <option value="medium">Moyenne entreprise (50-249 pers.)</option>
                                        <option value="large">Grande entreprise (≥ 250 pers.)</option>
                                    </select>
                                    @error('company_size')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-obq-anthracite mb-3">Normes ISO concernées
                                    <span class="text-red-500">*</span></label>
                                <div class="grid sm:grid-cols-2 gap-3">
                                    @foreach (['ISO 9001' => 'ISO 9001 - Management de la Qualité', 'ISO 14001' => 'ISO 14001 - Management Environnemental', 'ISO 45001' => 'ISO 45001 - Santé et Sécurité au Travail', 'ISO 22000' => 'ISO 22000 - Sécurité des Denrées Alimentaires', 'ISO 27001' => 'ISO 27001 - Sécurité de l\'Information'] as $code => $label)
                                        <label
                                            class="flex items-start gap-3 p-3.5 border rounded-xl cursor-pointer transition-all duration-150
                                            {{ in_array($code, $requested_standards) ? 'border-accent-400 bg-accent-50 shadow-sm' : 'border-gray-200 hover:border-brand-200 hover:bg-brand-50' }}">
                                            <input type="checkbox" wire:model="requested_standards"
                                                value="{{ $code }}"
                                                class="mt-0.5 w-4 h-4 text-accent-600 border-gray-300 rounded focus:ring-accent-400">
                                            <span
                                                class="text-sm {{ in_array($code, $requested_standards) ? 'text-obq-anthracite font-medium' : 'text-obq-muted' }}">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('requested_standards')
                                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endif

                    {{-- Step 3: Client Info --}}
                    @if ($step === 3)
                        <div class="space-y-5">
                            <div class="flex items-center gap-3 mb-6">
                                <span
                                    class="w-7 h-7 bg-brand-600 text-white rounded-lg flex items-center justify-center text-xs font-bold shrink-0">3</span>
                                <h3 class="text-lg font-semibold text-obq-anthracite">Vos coordonnées</h3>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-obq-anthracite mb-1.5">Nom complet
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="client_name"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200"
                                        placeholder="Jean Dupont">
                                    @error('client_name')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-obq-anthracite mb-1.5">Email <span
                                            class="text-red-500">*</span></label>
                                    <input type="email" wire:model="client_email"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200"
                                        placeholder="jean@entreprise.ci">
                                    @error('client_email')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-obq-anthracite mb-1.5">Téléphone</label>
                                    <input type="tel" wire:model="client_phone"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200"
                                        placeholder="+225 07 XX XX XX XX">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-obq-anthracite mb-1.5">Société</label>
                                    <input type="text" wire:model="client_company"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200"
                                        placeholder="Nom de votre entreprise">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-obq-anthracite mb-1.5">Adresse</label>
                                <textarea wire:model="client_address" rows="2"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200 resize-none"
                                    placeholder="Cocody, Abidjan"></textarea>
                            </div>

                            {{-- reCAPTCHA v3 --}}
                            @if (config('services.recaptcha.site_key'))
                                <input type="hidden" wire:model="recaptchaToken" id="recaptcha-token">
                                @error('recaptcha')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                    @endif

                    {{-- Buttons --}}
                    <div class="flex justify-between mt-8 pt-6 border-t border-brand-50">
                        @if ($step > 1)
                            <button type="button" wire:click="prevStep"
                                class="flex items-center gap-2 text-obq-muted hover:text-obq-anthracite font-medium px-4 py-3 rounded-xl transition-all duration-200 active:scale-95">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                                </svg>
                                Retour
                            </button>
                        @else
                            <span></span>
                        @endif

                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-accent-600 hover:bg-accent-400 text-white font-semibold px-7 py-3 rounded-xl transition-all duration-150 shadow-sm active:scale-95">
                            {{ $step === 3 ? 'Envoyer ma demande' : 'Continuer' }}
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Trust Badges --}}
            <div class="mt-12 grid sm:grid-cols-3 gap-6 text-center">
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-brand-100 text-brand-600 mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <p class="font-medium text-gray-900">100% confidentiel</p>
                    <p class="text-sm text-gray-500">Vos données sont protégées</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 text-amber-600 mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <p class="font-medium text-gray-900">Réponse rapide</p>
                    <p class="text-sm text-gray-500">Sous 24-48 heures</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                    <p class="font-medium text-gray-900">Gratuit & sans engagement</p>
                    <p class="text-sm text-gray-500">Aucun frais caché</p>
                </div>
            </div>
        @endif
    </div>

    @if (config('services.recaptcha.site_key') && !$submitted)
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('submit', () => {
                    grecaptcha.ready(function() {
                        grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {
                            action: 'diagnostic_request'
                        }).then(function(token) {
                            document.getElementById('recaptcha-token').value = token;
                            @this.submit();
                        });
                    });
                });
            });
        </script>
    @endif

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
