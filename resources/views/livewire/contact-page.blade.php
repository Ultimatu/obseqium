<div>
    <!-- Page header -->
    <div class="bg-gray-50 border-b border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-600">Accueil</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">Contact</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Contactez-nous</h1>
            <p class="text-gray-500 mt-2">Notre équipe vous répond sous 24 heures ouvrées.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-3 gap-12">

            <!-- Infos contact -->
            <div class="space-y-8">
                <div>
                    <h2 class="font-semibold text-gray-900 mb-4">Informations</h2>
                    <ul class="space-y-4 text-sm text-gray-600">
                        <li class="flex items-start gap-3">
                            <div class="w-9 h-9 bg-brand-50 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Email</p>
                                <a href="mailto:{{ $siteSettings->get('contact_email') }}" class="text-brand-600 hover:underline">{{ $siteSettings->get('contact_email') }}</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-9 h-9 bg-brand-50 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Téléphone</p>
                                <a href="tel:{{ $siteSettings->get('contact_phone') }}" class="text-brand-600 hover:underline">{{ $siteSettings->get('contact_phone') }}</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-9 h-9 bg-brand-50 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">Horaires</p>
                                <p>{{ $siteSettings->get('contact_hours') }}</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="bg-brand-50 rounded-2xl p-5 border border-brand-100">
                    <h3 class="font-semibold text-brand-800 mb-2">Besoin d'un devis ?</h3>
                    <p class="text-brand-700 text-sm mb-4">Décrivez votre projet et obtenez une estimation personnalisée.</p>
                    <a href="{{ route('quotes.request') }}" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                        Demander un devis
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="lg:col-span-2">
                @if($sent)
                <div class="bg-brand-50 border border-brand-200 rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 bg-brand-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h2 class="text-xl font-semibold text-brand-800 mb-2">Message envoyé !</h2>
                    <p class="text-brand-700">Merci pour votre message. Nous vous répondrons dans les plus brefs délais.</p>
                </div>
                @else
                <form wire:submit="send" class="space-y-5">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet <span class="text-red-500">*</span></label>
                            <input wire:model="name" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input wire:model="email" type="email" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                            <input wire:model="phone" type="tel" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Société</label>
                            <input wire:model="company" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Objet <span class="text-red-500">*</span></label>
                        <input wire:model="subject" type="text" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                        @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Format de rencontre souhaité</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach([
                                ['presentiel', 'Présentiel', 'Rendez-vous dans nos locaux', 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
                                ['visio',       'Visio',      'Appel vidéo à distance',       'M15 10l4.553-2.069A1 1 0 0121 8.867v6.266a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
                                ['client',      'Chez vous',  'Déplacement chez le client',   'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                            ] as [$value, $label, $desc, $path])
                            <label
                                wire:click="$set('meeting_format', '{{ $value }}')"
                                class="relative flex flex-col items-center gap-2 p-4 rounded-xl border-2 cursor-pointer transition-all
                                    {{ $meeting_format === $value
                                        ? 'border-brand-500 bg-brand-50 text-brand-700'
                                        : 'border-gray-200 bg-white text-gray-600 hover:border-brand-300 hover:bg-brand-50/50' }}">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center
                                    {{ $meeting_format === $value ? 'bg-brand-100' : 'bg-gray-100' }}">
                                    <svg class="w-5 h-5 {{ $meeting_format === $value ? 'text-brand-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
                                    </svg>
                                </div>
                                <span class="font-semibold text-sm">{{ $label }}</span>
                                <span class="text-xs text-center leading-tight {{ $meeting_format === $value ? 'text-brand-600' : 'text-gray-400' }}">{{ $desc }}</span>
                                @if($meeting_format === $value)
                                <div class="absolute top-2 right-2 w-5 h-5 bg-brand-500 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                @endif
                            </label>
                            @endforeach
                        </div>
                        @error('meeting_format') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message <span class="text-red-500">*</span></label>
                        <textarea wire:model="message" rows="6" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition resize-none"></textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="text-xs text-gray-400">En soumettant ce formulaire, vous acceptez notre <a href="{{ route('privacy') }}" class="underline hover:text-brand-600">politique de confidentialité</a>.</p>
                        <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors">
                            <span wire:loading.remove wire:target="send">Envoyer le message</span>
                            <span wire:loading wire:target="send">Envoi en cours...</span>
                        </button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
