@if(config('services.recaptcha.site_key'))
@assets
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
<style>.grecaptcha-badge { visibility: hidden !important; }</style>
@endassets
@endif

<div x-data x-init="Alpine.store('quoteNav', { dir: 1 })">
    <div class="bg-gray-50 border-b border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-600">Accueil</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">Demande de devis</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Demande de devis</h1>
            <p class="text-gray-500 mt-2">Décrivez votre projet, nous vous répondons sous 24h avec une proposition adaptée.</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($submitted)
        {{-- Success state --}}
        <div class="bg-brand-50 border border-brand-200 rounded-2xl p-10 text-center overflow-hidden"
             x-data
             x-init="$el.animate([{opacity:0,transform:'scale(0.92) translateY(12px)'},{opacity:1,transform:'scale(1) translateY(0)'}],{duration:400,easing:'cubic-bezier(0.16,1,0.3,1)'})">

            {{-- Animated check circle --}}
            <div class="flex justify-center mb-6">
                <div class="relative w-20 h-20">
                    <svg class="w-20 h-20 text-brand-100" viewBox="0 0 80 80" fill="currentColor">
                        <circle cx="40" cy="40" r="40"/>
                    </svg>
                    <svg class="absolute inset-0 w-20 h-20 text-brand-600" viewBox="0 0 80 80" fill="none" stroke="currentColor" stroke-width="4">
                        <circle cx="40" cy="40" r="36" stroke="currentColor" stroke-opacity="0.2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M24 40l12 12 20-20"
                              style="stroke-dasharray:48;stroke-dashoffset:48;animation:drawCheck .55s cubic-bezier(.16,1,.3,1) .25s forwards"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-xl font-semibold text-brand-800 mb-2"
                style="opacity:0;animation:fadeUp .4s ease .5s forwards">Demande reçue !</h2>
            <p class="text-brand-700 max-w-sm mx-auto"
               style="opacity:0;animation:fadeUp .4s ease .65s forwards">
                Votre demande de devis a bien été enregistrée. Notre équipe vous contactera sous 24 heures ouvrées avec une proposition personnalisée.
            </p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-6 text-brand-600 hover:text-brand-700 font-medium text-sm transition-colors"
               style="opacity:0;animation:fadeUp .4s ease .8s forwards">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                Retour à l'accueil
            </a>
        </div>

        @else

        {{-- Stepper --}}
        <div class="flex items-start w-full mb-10">
            @php $steps = ['Vos informations', 'Votre projet', 'Récapitulatif']; @endphp
            @foreach($steps as $i => $label)
                @php $stepNum = $i + 1; @endphp
                <div class="flex flex-col items-center flex-shrink-0">
                    <div class="relative w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold transition-all duration-300
                        {{ $step > $stepNum ? 'bg-brand-600 text-white shadow-sm shadow-brand-200'
                         : ($step === $stepNum ? 'bg-brand-600 text-white' : 'bg-white border-2 border-gray-200 text-gray-400') }}">
                        @if($step === $stepNum)
                        <span class="absolute inset-0 rounded-full ring-4 ring-brand-100 transition-all duration-300"></span>
                        @endif
                        @if($step > $stepNum)
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        @else
                        {{ $stepNum }}
                        @endif
                    </div>
                    <span class="text-xs font-medium mt-2 text-center hidden sm:block transition-colors duration-300
                        {{ $step === $stepNum ? 'text-brand-600' : ($step > $stepNum ? 'text-brand-400' : 'text-gray-400') }}">
                        {{ $label }}
                    </span>
                </div>
                @if($i < count($steps) - 1)
                <div class="relative flex-1 h-0.5 mt-4 mx-2 bg-gray-200 overflow-hidden rounded-full">
                    <div class="absolute inset-y-0 left-0 bg-brand-600 transition-all duration-500 ease-out rounded-full"
                         style="width: {{ $step > $stepNum ? '100%' : '0%' }}"></div>
                </div>
                @endif
            @endforeach
        </div>

        {{-- Step card with directional transition + staggered fields --}}
        <div wire:key="step-{{ $step }}"
             x-data
             x-init="
                $nextTick(() => {
                    let d = Alpine.store('quoteNav')?.dir ?? 1;
                    $el.animate(
                        [{opacity:0, transform: d > 0 ? 'translateX(20px)' : 'translateX(-20px)'},
                         {opacity:1, transform:'translateX(0)'}],
                        {duration:280, easing:'cubic-bezier(0.16,1,0.3,1)'}
                    );
                    $el.querySelectorAll('[data-field]').forEach((el, i) => {
                        el.animate(
                            [{opacity:0, transform:'translateY(10px)'}, {opacity:1, transform:'translateY(0)'}],
                            {duration:300, easing:'cubic-bezier(0.16,1,0.3,1)', delay: 80 + i * 60, fill:'backwards'}
                        );
                    });
                });
             "
             class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            @if($step === 1)
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Vos informations</h2>
            <div class="space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div data-field>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet <span class="text-red-500">*</span></label>
                        <input wire:model="client_name" type="text"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200">
                        @error('client_name')
                        <p class="text-red-500 text-xs mt-1 animate-[fadeUp_.2s_ease_forwards]">{{ $message }}</p>
                        @enderror
                    </div>
                    <div data-field>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email professionnel <span class="text-red-500">*</span></label>
                        <input wire:model="client_email" type="email"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200">
                        @error('client_email')
                        <p class="text-red-500 text-xs mt-1 animate-[fadeUp_.2s_ease_forwards]">{{ $message }}</p>
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
                            class="bg-brand-600 hover:bg-brand-700 disabled:opacity-60 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 active:scale-95 flex items-center gap-2">
                        <span wire:loading.remove wire:target="nextStep">Suivant</span>
                        <svg wire:loading wire:target="nextStep" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <svg wire:loading.remove wire:target="nextStep" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </div>
            </div>
            @endif

            @if($step === 2)
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Votre projet</h2>
            <div class="space-y-4">
                <div data-field>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type de prestation <span class="text-red-500">*</span></label>
                    <select wire:model="service_type"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 bg-white transition-all duration-200">
                        <option value="">Sélectionnez...</option>
                        @foreach($this->services as $service)
                        <option value="{{ $service->type }}">{{ $service->title }}</option>
                        @endforeach
                        <option value="autre">Autre</option>
                    </select>
                    @error('service_type')
                    <p class="text-red-500 text-xs mt-1 animate-[fadeUp_.2s_ease_forwards]">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div data-field>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Secteur d'activité</label>
                        <input wire:model="sector" type="text" placeholder="ex: Industrie, BTP, Santé…"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200">
                    </div>
                    <div data-field>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Taille de l'entreprise</label>
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description du projet <span class="text-red-500">*</span></label>
                    <textarea wire:model="description" rows="6" placeholder="Décrivez vos besoins, vos objectifs, le contexte…"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent hover:border-gray-300 transition-all duration-200 resize-none"></textarea>
                    @error('description')
                    <p class="text-red-500 text-xs mt-1 animate-[fadeUp_.2s_ease_forwards]">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-between pt-2" data-field>
                    <button wire:loading.attr="disabled"
                            @click="Alpine.store('quoteNav').dir = -1; $wire.prevStep()"
                            class="text-gray-500 hover:text-gray-700 disabled:opacity-60 font-medium px-4 py-3 rounded-xl transition-all duration-200 active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Retour
                    </button>
                    <button wire:loading.attr="disabled"
                            @click="Alpine.store('quoteNav').dir = 1; $wire.nextStep()"
                            class="bg-brand-600 hover:bg-brand-700 disabled:opacity-60 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 active:scale-95 flex items-center gap-2">
                        <span wire:loading.remove wire:target="nextStep">Récapitulatif</span>
                        <svg wire:loading wire:target="nextStep" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <svg wire:loading.remove wire:target="nextStep" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </div>
            </div>
            @endif

            @if($step === 3)
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Récapitulatif</h2>
            <div class="space-y-4 text-sm">
                <div class="bg-gray-50 rounded-xl p-4" data-field>
                    <h3 class="font-semibold text-gray-500 text-xs uppercase tracking-wider mb-3">Vos informations</h3>
                    <dl class="grid grid-cols-2 gap-x-4 gap-y-2 text-gray-700">
                        <dt class="font-medium text-gray-500">Nom</dt><dd>{{ $client_name }}</dd>
                        <dt class="font-medium text-gray-500">Email</dt><dd class="truncate">{{ $client_email }}</dd>
                        @if($client_phone)<dt class="font-medium text-gray-500">Téléphone</dt><dd>{{ $client_phone }}</dd>@endif
                        @if($client_company)<dt class="font-medium text-gray-500">Société</dt><dd>{{ $client_company }}</dd>@endif
                        @if($client_job_title)<dt class="font-medium text-gray-500">Fonction</dt><dd>{{ $client_job_title }}</dd>@endif
                    </dl>
                </div>
                <div class="bg-gray-50 rounded-xl p-4" data-field>
                    <h3 class="font-semibold text-gray-500 text-xs uppercase tracking-wider mb-3">Votre projet</h3>
                    <dl class="grid grid-cols-2 gap-x-4 gap-y-2 text-gray-700">
                        @if($service_type)<dt class="font-medium text-gray-500">Prestation</dt><dd>{{ $service_type }}</dd>@endif
                        @if($sector)<dt class="font-medium text-gray-500">Secteur</dt><dd>{{ $sector }}</dd>@endif
                        @if($company_size)<dt class="font-medium text-gray-500">Taille</dt><dd>{{ $company_size }}</dd>@endif
                    </dl>
                    @if($description)
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <p class="font-medium text-gray-500 mb-1">Description</p>
                        <p class="text-gray-600 whitespace-pre-wrap">{{ $description }}</p>
                    </div>
                    @endif
                </div>
                <div class="flex justify-between pt-2" data-field>
                    <button wire:loading.attr="disabled"
                            @click="Alpine.store('quoteNav').dir = -1; $wire.prevStep()"
                            class="text-gray-500 hover:text-gray-700 disabled:opacity-60 font-medium px-4 py-3 rounded-xl transition-all duration-200 active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Modifier
                    </button>
                    <button wire:loading.attr="disabled"
                            @click="
                                @if(config('services.recaptcha.site_key'))
                                grecaptcha.ready(async () => {
                                    try {
                                        const token = await grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'quote_submit' });
                                        await $wire.set('recaptchaToken', token);
                                    } catch(e) {}
                                    $wire.submit();
                                });
                                @else
                                $wire.submit();
                                @endif
                            "
                            class="bg-brand-600 hover:bg-brand-700 disabled:opacity-60 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 active:scale-95 flex items-center gap-2">
                        <span wire:loading.remove wire:target="submit">Envoyer ma demande</span>
                        <svg wire:loading wire:target="submit" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <span wire:loading.remove wire:target="submit">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </span>
                    </button>
                </div>
            </div>
            @endif

        </div>
        @endif
    </div>

    <style>
        @keyframes drawCheck { to { stroke-dashoffset: 0; } }
        @keyframes fadeUp { from { opacity:0; transform:translateY(8px) } to { opacity:1; transform:translateY(0) } }
    </style>
</div>
