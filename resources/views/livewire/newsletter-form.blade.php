<div>
    @if($subscribed)
    <div class="flex items-center gap-3 bg-brand-50 border border-brand-200 text-brand-700 rounded-xl px-4 py-3 text-sm">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        Merci ! Vous êtes bien inscrit(e) à notre newsletter.
    </div>
    @else
    <form wire:submit="subscribe" class="{{ $compact ? 'flex gap-2' : 'space-y-3' }}">
        @if(!$compact)
        <div class="grid sm:grid-cols-2 gap-3">
            <input wire:model="name" type="text" placeholder="Votre prénom (optionnel)"
                class="w-full bg-white/10 border border-white/20 text-white placeholder-white/50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-white/50">
            <input wire:model="email" type="email" placeholder="Votre adresse email *" required
                class="w-full bg-white/10 border border-white/20 text-white placeholder-white/50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-white/50">
        </div>
        @else
        <input wire:model="email" type="email" placeholder="Votre email..." required
            class="flex-1 bg-gray-800 border border-gray-700 text-gray-200 placeholder-gray-500 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500">
        @endif

        @if($error)
        <p class="text-red-300 text-xs">{{ $error }}</p>
        @endif
        @error('email') <p class="text-red-300 text-xs">{{ $message }}</p> @enderror

        <button type="submit"
            class="{{ $compact
                ? 'bg-brand-600 hover:bg-brand-500 text-white text-sm px-3 py-2 rounded-lg font-medium transition-colors'
                : 'w-full bg-white text-brand-700 hover:bg-brand-50 font-semibold px-6 py-3 rounded-xl transition-colors' }}">
            <span wire:loading.remove wire:target="subscribe">S'inscrire</span>
            <span wire:loading wire:target="subscribe">...</span>
        </button>
    </form>
    @if(!$compact)
    <p class="text-brand-300 text-xs mt-3">Pas de spam. Désinscription en un clic.</p>
    @endif
    @endif
</div>
