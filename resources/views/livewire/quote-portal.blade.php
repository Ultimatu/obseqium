<div>
    {{-- Hero band --}}
    <div class="bg-gray-50 border-b border-gray-100 py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Référence devis</p>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $quote->reference }}</h1>
                    <p class="text-gray-500 text-sm mt-1">
                        Émis le {{ $quote->created_at->format('d/m/Y') }}
                        @if($quote->valid_until)
                            · Valable jusqu'au
                            <span @class(['text-red-500 font-medium' => $quote->isExpired()])>
                                {{ $quote->valid_until->format('d/m/Y') }}
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    @php
                        $badge = match($quote->status) {
                            'accepted' => ['label' => 'Accepté', 'class' => 'bg-green-100 text-green-700'],
                            'refused'  => ['label' => 'Refusé',  'class' => 'bg-red-100 text-red-700'],
                            'viewed'   => ['label' => 'Consulté','class' => 'bg-yellow-100 text-yellow-700'],
                            'sent'     => ['label' => 'En attente','class' => 'bg-blue-100 text-blue-700'],
                            default    => ['label' => 'Brouillon','class' => 'bg-gray-100 text-gray-600'],
                        };
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badge['class'] }}">
                        {{ $badge['label'] }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-10 space-y-6">

        {{-- Expiry warning --}}
        @if($quote->isExpired() && $quote->isPending())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex gap-3">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <p class="text-sm text-red-700">Ce devis a expiré le {{ $quote->valid_until->format('d/m/Y') }}. Contactez-nous pour obtenir une proposition actualisée.</p>
        </div>
        @endif

        {{-- Success banner after approval --}}
        @if($quote->status === 'accepted')
        <div class="bg-green-50 border border-green-200 rounded-xl p-5 flex gap-4"
             x-data x-init="$el.animate([{opacity:0,transform:'translateY(-8px)'},{opacity:1,transform:'translateY(0)'}],{duration:350,easing:'ease-out'})">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="font-semibold text-green-800">Devis accepté
                    @if($quote->approved_at) le {{ $quote->approved_at->format('d/m/Y à H:i') }}@endif
                </p>
                <p class="text-sm text-green-700 mt-1">Merci pour votre confiance. Notre équipe vous contactera très prochainement pour la suite.</p>
            </div>
        </div>
        @endif

        {{-- Client & project info --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <h2 class="font-semibold text-gray-800">Informations</h2>
            </div>
            <div class="grid sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-gray-50">
                <div class="px-6 py-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Client</p>
                    <p class="font-semibold text-gray-900">{{ $quote->client_name }}</p>
                    @if($quote->client_company)<p class="text-sm text-gray-500">{{ $quote->client_company }}</p>@endif
                    @if($quote->client_job_title)<p class="text-sm text-gray-500">{{ $quote->client_job_title }}</p>@endif
                    <p class="text-sm text-gray-500 mt-1">{{ $quote->client_email }}</p>
                </div>
                <div class="px-6 py-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Prestation</p>
                    <p class="font-semibold text-gray-900">
                        {{ match($quote->service_type) {
                            'strategic' => 'Accompagnement stratégique',
                            'audit'     => 'Audit',
                            'qhse'      => 'Conseil QHSE',
                            'training'  => 'Formation',
                            default     => 'Autre',
                        } }}
                    </p>
                    @if($quote->sector)<p class="text-sm text-gray-500">Secteur : {{ $quote->sector }}</p>@endif
                    @if($quote->description)<p class="text-sm text-gray-500 mt-2">{{ $quote->description }}</p>@endif
                </div>
            </div>
        </div>

        {{-- Items table --}}
        @if($quote->items->count())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <h2 class="font-semibold text-gray-800">Détail des prestations</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">Désignation</th>
                            <th class="px-4 py-3 text-right">Qté</th>
                            <th class="px-4 py-3 text-left">Unité</th>
                            <th class="px-4 py-3 text-right">P.U. HT</th>
                            <th class="px-6 py-3 text-right">Total HT</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($quote->items as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">{{ $item->description }}</p>
                                @if($item->details)<p class="text-xs text-gray-400 mt-0.5">{{ $item->details }}</p>@endif
                            </td>
                            <td class="px-4 py-4 text-right text-gray-600">{{ number_format($item->quantity, 2, ',', '') }}</td>
                            <td class="px-4 py-4 text-gray-500">{{ $item->unit }}</td>
                            <td class="px-4 py-4 text-right text-gray-600">{{ number_format($item->unit_price, 2, ',', ' ') }} €</td>
                            <td class="px-6 py-4 text-right font-semibold text-gray-900">{{ number_format($item->total, 2, ',', ' ') }} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Totals --}}
            <div class="border-t border-gray-100 px-6 py-4 flex justify-end">
                <div class="w-64 space-y-1 text-sm">
                    <div class="flex justify-between text-gray-500">
                        <span>Sous-total HT</span>
                        <span>{{ number_format($quote->subtotal, 2, ',', ' ') }} €</span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>TVA ({{ number_format($quote->tax_rate, 0) }}%)</span>
                        <span>{{ number_format($quote->tax_amount, 2, ',', ' ') }} €</span>
                    </div>
                    <div class="flex justify-between font-bold text-gray-900 text-base pt-2 border-t border-gray-200">
                        <span>Total TTC</span>
                        <span>{{ number_format($quote->total, 2, ',', ' ') }} €</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Notes --}}
        @if($quote->notes)
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800">
            <p class="font-semibold mb-1">Conditions particulières</p>
            <p class="whitespace-pre-wrap">{{ $quote->notes }}</p>
        </div>
        @endif

        {{-- Actions (only if pending) --}}
        @if($quote->isPending() && ! $quote->isExpired())
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6" x-data="{ confirming: false }">
            <h2 class="font-semibold text-gray-800 mb-1">Valider ce devis</h2>
            <p class="text-sm text-gray-500 mb-5">En cliquant sur « Bon pour accord », vous acceptez les termes de ce devis. Vous pourrez ensuite déposer votre bon pour accord signé.</p>

            <div x-show="!confirming">
                <button @click="confirming = true"
                        class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 active:scale-95 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Bon pour accord
                </button>
            </div>

            <div x-show="confirming" x-transition class="bg-brand-50 border border-brand-200 rounded-xl p-5">
                <p class="text-sm font-semibold text-brand-800 mb-4">Confirmez-vous l'acceptation du devis <strong>{{ $quote->reference }}</strong> ?</p>
                <div class="flex gap-3">
                    <button wire:click="approve" wire:loading.attr="disabled"
                            class="bg-brand-600 hover:bg-brand-700 disabled:opacity-60 text-white font-semibold px-5 py-2.5 rounded-xl transition-all active:scale-95 flex items-center gap-2">
                        <svg wire:loading wire:target="approve" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        <span wire:loading.remove wire:target="approve">Oui, je valide</span>
                        <span wire:loading wire:target="approve">Enregistrement…</span>
                    </button>
                    <button @click="confirming = false" class="text-gray-500 hover:text-gray-700 font-medium px-4 py-2.5 rounded-xl transition-colors">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- Upload bon pour accord --}}
        @if($quote->status === 'accepted')
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-semibold text-gray-800 mb-1">Bon pour accord signé</h2>
            <p class="text-sm text-gray-500 mb-5">Déposez votre bon pour accord signé (PDF, JPG ou PNG, max 10 Mo).</p>

            @if($quote->approval_document)
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-green-800">Document déposé</p>
                    <p class="text-xs text-green-600 truncate">{{ basename($quote->approval_document) }}</p>
                </div>
                <a href="{{ Storage::url($quote->approval_document) }}" target="_blank"
                   class="text-xs text-green-700 hover:text-green-900 font-medium underline">
                    Voir
                </a>
            </div>
            @endif

            @if($fileUploaded)
            <div class="bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3 mb-4">
                Document enregistré avec succès.
            </div>
            @endif

            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $quote->approval_document ? 'Remplacer le document' : 'Choisir un fichier' }}
                    </label>
                    <input wire:model="approvalFile" type="file" accept=".pdf,.jpg,.jpeg,.png"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition">
                    @error('approvalFile') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                    <div wire:loading wire:target="approvalFile" class="text-xs text-gray-400 mt-1">
                        Chargement du fichier…
                    </div>
                </div>
                <button wire:click="uploadApprovalDocument" wire:loading.attr="disabled"
                        class="bg-gray-800 hover:bg-gray-900 disabled:opacity-60 text-white font-semibold px-5 py-2.5 rounded-xl transition-all active:scale-95 flex items-center gap-2">
                    <svg wire:loading wire:target="uploadApprovalDocument" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <svg wire:loading.remove wire:target="uploadApprovalDocument" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span wire:loading.remove wire:target="uploadApprovalDocument">Envoyer le document</span>
                    <span wire:loading wire:target="uploadApprovalDocument">Envoi…</span>
                </button>
            </div>
        </div>
        @endif

        {{-- Download PDF --}}
        <div class="flex items-center justify-between bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-4">
            <div>
                <p class="font-medium text-gray-800">Télécharger le devis en PDF</p>
                <p class="text-sm text-gray-400">Version complète avec tableau des prestations</p>
            </div>
            <a href="{{ route('quotes.portal.pdf', $quote->token) }}"
               class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2.5 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                PDF
            </a>
        </div>

    </div>
</div>
