<div class="min-h-screen bg-gradient-to-br from-brand-50 to-white">
    <div class="max-w-4xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-brand-100 mb-6">
                <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                Diagnostic ISO gratuit
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Évaluez votre niveau de conformité sans engagement. Notre équipe d'experts analyse votre organisation et vous remet un rapport détaillé avec recommandations.
            </p>
        </div>

        @if($submitted)
            {{-- Success Message --}}
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    Votre demande a bien été envoyée !
                </h2>
                <div class="bg-brand-50 rounded-lg p-4 mb-6 inline-block">
                    <p class="text-sm text-gray-600 mb-1">Votre référence</p>
                    <p class="text-xl font-bold text-brand-600">{{ $reference }}</p>
                </div>
                <p class="text-gray-600 mb-6 max-w-lg mx-auto">
                    Notre équipe vous contactera sous 24 à 48 heures pour planifier votre diagnostic. Un email de confirmation vous a été envoyé.
                </p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-brand-600 text-white rounded-lg hover:bg-brand-700 transition-colors">
                    Retour à l'accueil
                </a>
            </div>
        @else
            {{-- Form --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                {{-- Progress Bar --}}
                <div class="bg-gray-50 px-8 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-600">Étape {{ $step }} sur 3</span>
                        <span class="text-sm text-gray-500">{{ match($step) { 1 => 'Vos coordonnées', 2 => 'Votre entreprise', 3 => 'Planification' } }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-brand-600 h-2 rounded-full transition-all duration-300" style="width: {{ ($step / 3) * 100 }}%"></div>
                    </div>
                </div>

                <form wire:submit="{{ $step === 3 ? 'submit' : 'nextStep' }}" class="p-8">
                    {{-- Step 1: Client Info --}}
                    @if($step === 1)
                        <div class="space-y-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">Vos coordonnées</h3>

                            <div class="grid sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                                    <input type="text" wire:model="client_name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="Jean Dupont">
                                    @error('client_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" wire:model="client_email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="jean@entreprise.ci">
                                    @error('client_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                    <input type="tel" wire:model="client_phone" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="+225 07 XX XX XX XX">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Société</label>
                                    <input type="text" wire:model="client_company" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="Nom de votre entreprise">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                <textarea wire:model="client_address" rows="2" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="Cocody, Abidjan"></textarea>
                            </div>
                        </div>
                    @endif

                    {{-- Step 2: Company Profile --}}
                    @if($step === 2)
                        <div class="space-y-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">Votre entreprise</h3>

                            <div class="grid sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Secteur d'activité *</label>
                                    <input type="text" wire:model="sector" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="Industrie, Santé, BTP...">
                                    @error('sector') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Taille de l'entreprise *</label>
                                    <select wire:model="company_size" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                                        <option value="">Sélectionnez...</option>
                                        <option value="micro">Micro-entreprise (&lt; 10 pers.)</option>
                                        <option value="small">Petite entreprise (10-49 pers.)</option>
                                        <option value="medium">Moyenne entreprise (50-249 pers.)</option>
                                        <option value="large">Grande entreprise (≥ 250 pers.)</option>
                                    </select>
                                    @error('company_size') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Normes ISO concernées *</label>
                                <div class="grid sm:grid-cols-2 gap-3">
                                    @foreach(['ISO 9001' => 'ISO 9001 — Management de la Qualité', 'ISO 14001' => 'ISO 14001 — Management Environnemental', 'ISO 45001' => 'ISO 45001 — Santé et Sécurité au Travail', 'ISO 22000' => 'ISO 22000 — Sécurité des Denrées Alimentaires', 'ISO 27001' => 'ISO 27001 — Sécurité de l\'Information'] as $code => $label)
                                        <label class="flex items-start p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ in_array($code, $requested_standards) ? 'border-brand-500 bg-brand-50' : '' }}">
                                            <input type="checkbox" wire:model="requested_standards" value="{{ $code }}" class="mt-1 w-4 h-4 text-brand-600 border-gray-300 rounded focus:ring-brand-500">
                                            <span class="ml-3 text-sm text-gray-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('requested_standards') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    @endif

                    {{-- Step 3: Scheduling --}}
                    @if($step === 3)
                        <div class="space-y-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">Planification souhaitée</h3>

                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <p class="text-sm text-blue-800">
                                    <strong>Information :</strong> Cette date est indicative. Notre équipe vous contactera pour confirmer la disponibilité.
                                </p>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date souhaitée</label>
                                    <input type="date" wire:model="requested_date" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500" min="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Informations complémentaires</label>
                                <textarea wire:model="notes" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="Décrivez vos besoins spécifiques, contexte particulier, délais..."></textarea>
                            </div>

                            {{-- reCAPTCHA v3 --}}
                            @if(config('services.recaptcha.site_key'))
                                <input type="hidden" wire:model="recaptchaToken" id="recaptcha-token">
                                @error('recaptcha') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                            @endif
                        </div>
                    @endif

                    {{-- Buttons --}}
                    <div class="flex justify-between mt-8 pt-6 border-t border-gray-100">
                        @if($step > 1)
                            <button type="button" wire:click="prevStep" class="px-6 py-3 text-gray-600 hover:text-gray-900 font-medium">
                                ← Retour
                            </button>
                        @else
                            <span></span>
                        @endif

                        <button type="submit" class="px-8 py-3 bg-brand-600 text-white rounded-lg hover:bg-brand-700 font-medium transition-colors">
                            {{ $step === 3 ? 'Envoyer ma demande' : 'Continuer →' }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Trust Badges --}}
            <div class="mt-12 grid sm:grid-cols-3 gap-6 text-center">
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-brand-100 text-brand-600 mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <p class="font-medium text-gray-900">100% confidentiel</p>
                    <p class="text-sm text-gray-500">Vos données sont protégées</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 text-amber-600 mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <p class="font-medium text-gray-900">Réponse rapide</p>
                    <p class="text-sm text-gray-500">Sous 24-48 heures</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                    </div>
                    <p class="font-medium text-gray-900">Gratuit & sans engagement</p>
                    <p class="text-sm text-gray-500">Aucun frais caché</p>
                </div>
            </div>
        @endif
    </div>

    @if(config('services.recaptcha.site_key') && !$submitted)
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('submit', () => {
                    grecaptcha.ready(function() {
                        grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'diagnostic_request'}).then(function(token) {
                            document.getElementById('recaptcha-token').value = token;
                            @this.submit();
                        });
                    });
                });
            });
        </script>
    @endif
</div>
