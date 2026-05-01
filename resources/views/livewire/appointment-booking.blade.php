<div>
    <div class="bg-gray-50 border-b border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-600">Accueil</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">Rendez-vous</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Prendre rendez-vous</h1>
            <p class="text-gray-500 mt-2">Un premier échange de 30 minutes pour discuter de votre projet.</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($booked)
        <div class="bg-brand-50 border border-brand-200 rounded-2xl p-8 text-center"
             x-data
             x-init="$el.animate([{opacity:0,transform:'scale(0.95)'},{opacity:1,transform:'scale(1)'}],{duration:300,easing:'ease-out'})">
            <div class="w-16 h-16 bg-brand-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h2 class="text-xl font-semibold text-brand-800 mb-2">Demande envoyée !</h2>
            <p class="text-brand-700">Votre demande de rendez-vous a été reçue. Nous vous contacterons rapidement pour confirmer le créneau.</p>
        </div>
        @else

        <!-- Stepper pleine largeur -->
        <div class="flex items-start w-full mb-10">
            @php $steps = ['Vos coordonnées', 'Votre projet', 'Date souhaitée']; @endphp
            @foreach($steps as $i => $label)
                <div class="flex flex-col items-center flex-shrink-0">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold transition-all duration-300
                        {{ $step > $i + 1 ? 'bg-brand-600 text-white shadow-sm shadow-brand-200' : ($step === $i + 1 ? 'bg-brand-600 text-white ring-4 ring-brand-100' : 'bg-white border-2 border-gray-200 text-gray-400') }}">
                        @if($step > $i + 1)
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        @else
                        {{ $i + 1 }}
                        @endif
                    </div>
                    <span class="text-xs font-medium mt-2 text-center hidden sm:block
                        {{ $step === $i + 1 ? 'text-brand-600' : ($step > $i + 1 ? 'text-brand-400' : 'text-gray-400') }}">
                        {{ $label }}
                    </span>
                </div>
                @if($i < count($steps) - 1)
                <div class="flex-1 h-0.5 mt-4 mx-2 transition-colors duration-500 {{ $step > $i + 1 ? 'bg-brand-600' : 'bg-gray-200' }}"></div>
                @endif
            @endforeach
        </div>

        <!-- Contenu de l'étape avec animation -->
        <div wire:key="step-{{ $step }}"
             x-data
             x-init="$el.animate([{opacity:0,transform:'translateX(16px)'},{opacity:1,transform:'translateX(0)'}],{duration:220,easing:'ease-out'})"
             class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            @if($step === 1)
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Vos coordonnées</h2>
            <div class="space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet <span class="text-red-500">*</span></label>
                        <input wire:model="guest_name" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                        @error('guest_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input wire:model="guest_email" type="email" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                        @error('guest_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input wire:model="guest_phone" type="tel" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Société</label>
                        <input wire:model="guest_company" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                    </div>
                </div>
                <div class="flex justify-end pt-2">
                    <button wire:click="nextStep" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors flex items-center gap-2">
                        <span wire:loading.remove wire:target="nextStep">Suivant</span>
                        <span wire:loading wire:target="nextStep">...</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </div>
            </div>
            @endif

            @if($step === 2)
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Votre projet</h2>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Format souhaité <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Visioconférence -->
                        <button type="button"
                            wire:click="$set('type', 'visio')"
                            class="relative flex flex-col items-center gap-2 border-2 rounded-xl p-5 cursor-pointer transition-all duration-150
                                {{ $type === 'visio' ? 'border-brand-600 bg-brand-50 shadow-sm' : 'border-gray-200 hover:border-brand-300 hover:bg-gray-50' }}">
                            <svg class="w-7 h-7 {{ $type === 'visio' ? 'text-brand-600' : 'text-gray-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 10l4.553-2.069A1 1 0 0121 8.82v6.36a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                            </svg>
                            <span class="font-semibold text-sm {{ $type === 'visio' ? 'text-brand-700' : 'text-gray-600' }}">Visioconférence</span>
                            <span class="text-xs {{ $type === 'visio' ? 'text-brand-500' : 'text-gray-400' }}">Teams, Zoom, Meet…</span>
                            @if($type === 'visio')
                            <div class="absolute top-2 right-2 w-5 h-5 bg-brand-600 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            @endif
                        </button>

                        <!-- Présentiel -->
                        <button type="button"
                            wire:click="$set('type', 'presential')"
                            class="relative flex flex-col items-center gap-2 border-2 rounded-xl p-5 cursor-pointer transition-all duration-150
                                {{ $type === 'presential' ? 'border-brand-600 bg-brand-50 shadow-sm' : 'border-gray-200 hover:border-brand-300 hover:bg-gray-50' }}">
                            <svg class="w-7 h-7 {{ $type === 'presential' ? 'text-brand-600' : 'text-gray-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="font-semibold text-sm {{ $type === 'presential' ? 'text-brand-700' : 'text-gray-600' }}">Présentiel</span>
                            <span class="text-xs {{ $type === 'presential' ? 'text-brand-500' : 'text-gray-400' }}">Dans nos locaux</span>
                            @if($type === 'presential')
                            <div class="absolute top-2 right-2 w-5 h-5 bg-brand-600 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            @endif
                        </button>
                    </div>
                    @error('type') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Objet du rendez-vous</label>
                    <textarea wire:model="subject" rows="4" placeholder="Décrivez brièvement le sujet de votre rendez-vous…" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition resize-none"></textarea>
                </div>

                <div class="flex justify-between pt-2">
                    <button wire:click="prevStep" class="text-gray-500 hover:text-gray-700 font-medium px-4 py-3 rounded-xl transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Retour
                    </button>
                    <button wire:click="nextStep" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors flex items-center gap-2">
                        <span wire:loading.remove wire:target="nextStep">Suivant</span>
                        <span wire:loading wire:target="nextStep">...</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </div>
            </div>
            @endif

            @if($step === 3)
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Date souhaitée</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date et heure <span class="text-red-500">*</span></label>
                    <input wire:model="requested_date" type="datetime-local" min="{{ now()->addDay()->format('Y-m-d\TH:i') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                    @error('requested_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <p class="text-xs text-gray-400">Nous confirmerons le créneau définitif par email sous 24h.</p>
                <div class="flex justify-between pt-2">
                    <button wire:click="prevStep" class="text-gray-500 hover:text-gray-700 font-medium px-4 py-3 rounded-xl transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Retour
                    </button>
                    <button wire:click="book" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors">
                        <span wire:loading.remove wire:target="book">Confirmer la demande</span>
                        <span wire:loading wire:target="book">Envoi en cours…</span>
                    </button>
                </div>
            </div>
            @endif

        </div>
        @endif
    </div>
</div>
