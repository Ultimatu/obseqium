<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $pageTitle = ($title ?? config('app.name')) . ' - ' . $siteSettings->get('brand_name', 'Cabinet QHSE');
        $pageDesc = $metaDescription ?? $siteSettings->get('hero_description', '');
        $pageImage = $ogImage ?? asset('logos/Logo-Obsequium%20Fond%20blanc.png');
        $canonicalUrl = $canonicalUrl ?? url()->current();
    @endphp

    <title>{{ $pageTitle }}</title>

    @if ($pageDesc)
        <meta name="description" content="{{ $pageDesc }}">
    @endif

    <!-- OpenGraph -->
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:title" content="{{ $ogTitle ?? $pageTitle }}">
    <meta property="og:description" content="{{ $ogDescription ?? $pageDesc }}">
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:site_name" content="{{ $siteSettings->get('brand_name', config('app.name')) }}">
    <meta property="og:locale" content="fr_FR">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle ?? $pageTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription ?? $pageDesc }}">
    <meta name="twitter:image" content="{{ $pageImage }}">

    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('sitemap') }}">

    <!-- JSON-LD: Organization (toutes les pages) -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "{{ $siteSettings->get('brand_name', config('app.name')) }}",
        "url": "{{ config('app.url') }}",
        "logo": "{{ asset('logos/Logo-Obsequium_Fond_bleue.png') }}",
        "contactPoint": {
            "@@type": "ContactPoint",
            "telephone": "{{ $siteSettings->get('contact_phone', '') }}",
            "contactType": "customer service",
            "areaServed": "CI",
            "availableLanguage": "French"
        },
        "address": {
            "@@type": "PostalAddress",
            "addressLocality": "Abidjan",
            "addressCountry": "CI",
            "streetAddress": "{{ $siteSettings->get('contact_address', '') }}"
        }
    }
    </script>

    @if(isset($jsonLd))
    <script type="application/ld+json">{!! $jsonLd !!}</script>
    @endif

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#154286">
    <meta name="msapplication-TileColor" content="#154286">
    <meta name="msapplication-config" content="/browserconfig.xml">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-white text-gray-800 antialiased font-sans">

    <!-- Preloader -->
    <div id="preloader" aria-hidden="true">
        <div class="flex flex-col items-center gap-5">
            <div class="w-14 h-14 flex items-center justify-center">
                <img src="/logos/Obsequium%20vert.png" alt="{{ $siteSettings->get('brand_name', 'Obsequium') }}"
                    class="w-14 h-14 object-contain drop-shadow-lg">
            </div>
            <div class="w-28 h-1 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-10 bg-brand-600 rounded-full preloader-bar"></div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header x-data="{ mobileOpen: false }" class="sticky top-0 z-50 bg-[#154286] shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18 py-3">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center shrink-0">
                    <img src="/logos/Logo-Obsequium_Fond_bleue.png"
                        alt="{{ $siteSettings->get('brand_name', 'Obsequium') }}" class="h-12 w-auto object-contain">
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden lg:flex items-center gap-5">
                    <a href="{{ route('home') }}"
                        class="text-white/90 hover:text-[#96B857] font-medium text-sm transition-colors">Accueil</a>

                    <!-- Services dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button
                            class="flex items-center gap-1 text-white/90 hover:text-[#96B857] font-medium text-sm transition-colors">
                            Services
                            <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-64 bg-white rounded-xl shadow-xl border border-brand-50 py-2 z-50">
                            <a href="{{ route('services.index') }}"
                                class="block px-4 py-2 text-sm text-[#96B857] hover:bg-[#F0F4E8] font-semibold">Tous
                                nos services</a>
                            <div class="border-t border-brand-50 my-1"></div>
                            <a href="{{ route('services.index', ['type' => 'strategic']) }}"
                                class="block px-4 py-2 text-sm text-obq-anthracite hover:bg-[#F0F4E8] hover:text-[#769044]">Accompagnement
                                stratégique</a>
                            <a href="{{ route('services.index', ['type' => 'audit']) }}"
                                class="block px-4 py-2 text-sm text-obq-anthracite hover:bg-[#F0F4E8] hover:text-[#769044]">Audit
                                & Contrôle</a>
                            <a href="{{ route('services.index', ['type' => 'qhse']) }}"
                                class="block px-4 py-2 text-sm text-obq-anthracite hover:bg-[#F0F4E8] hover:text-[#769044]">Conseil
                                QHSE</a>
                            <a href="{{ route('services.index', ['type' => 'training']) }}"
                                class="block px-4 py-2 text-sm text-obq-anthracite hover:bg-[#F0F4E8] hover:text-[#769044]">Formation</a>
                        </div>
                    </div>

                    <a href="{{ route('process') }}"
                        class="text-white/90 hover:text-[#96B857] font-medium text-sm transition-colors">Notre
                        processus</a>
                    <a href="{{ route('formations.index') }}"
                        class="text-white/90 hover:text-[#96B857] font-medium text-sm transition-colors">Formations</a>
                    <a href="{{ route('pricing') }}"
                        class="text-white/90 hover:text-[#96B857] font-medium text-sm transition-colors">Tarifs</a>
                    <a href="{{ route('contact') }}"
                        class="text-white/90 hover:text-[#96B857] font-medium text-sm transition-colors">Contact</a>
                </nav>

                <!-- CTA -->
                <div class="hidden lg:flex items-center shrink-0 gap-3">
                    <a href="{{ route('quotes.request') }}"
                        class="text-white font-medium text-sm px-4 py-2 rounded-lg transition-colors whitespace-nowrap border border-white/40 hover:border-white hover:bg-white/10">
                        Devis
                    </a>
                    <a href="{{ route('diagnostic.request') }}"
                        class="bg-[#769044] hover:bg-accent-400 text-white font-semibold text-sm px-4 py-2 rounded-lg transition-colors whitespace-nowrap shadow-sm">
                        Diagnostic gratuit
                    </a>
                </div>

                <!-- Mobile burger -->
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 text-white hover:text-white/80">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileOpen" x-transition
            class="lg:hidden border-t border-white/20 bg-brand-600 px-4 py-4 space-y-1">
            <a href="{{ route('home') }}"
                class="block py-2.5 text-sm font-medium text-white/90 hover:text-white border-b border-white/10">Accueil</a>
            <a href="{{ route('services.index') }}"
                class="block py-2.5 text-sm font-medium text-white/90 hover:text-white border-b border-white/10">Services</a>
            <a href="{{ route('process') }}"
                class="block py-2.5 text-sm font-medium text-white/90 hover:text-white border-b border-white/10">Notre
                processus</a>
            <a href="{{ route('formations.index') }}"
                class="block py-2.5 text-sm font-medium text-white/90 hover:text-white border-b border-white/10">Formations</a>
            <a href="{{ route('references') }}"
                class="block py-2.5 text-sm font-medium text-white/90 hover:text-white border-b border-white/10">Références</a>
            <a href="{{ route('pricing') }}"
                class="block py-2.5 text-sm font-medium text-white/90 hover:text-white border-b border-white/10">Tarifs</a>
            <a href="{{ route('about') }}"
                class="block py-2.5 text-sm font-medium text-white/90 hover:text-white border-b border-white/10">À
                propos</a>
            <a href="{{ route('blog.index') }}"
                class="block py-2.5 text-sm font-medium text-white/90 hover:text-white border-b border-white/10">Blog</a>
            <a href="{{ route('contact') }}"
                class="block py-2.5 text-sm font-medium text-white/90 hover:text-white">Contact</a>
            <div class="pt-4 flex flex-col gap-2">
                <a href="{{ route('diagnostic.request') }}"
                    class="w-full text-center bg-accent-600 hover:bg-accent-400 text-white font-semibold text-sm px-4 py-2.5 rounded-lg transition-colors">Diagnostic
                    gratuit</a>
                <a href="{{ route('quotes.request') }}"
                    class="w-full text-center text-white border border-white/40 hover:border-white hover:bg-white/10 font-medium text-sm px-4 py-2.5 rounded-lg transition-colors">Demander
                    un devis</a>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-[#154286] text-white/80 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">

                <!-- Brand -->
                <div class="lg:col-span-1">
                    <div class="mb-5">
                        <img src="/logos/Logo-Obsequium_Fond_bleue.png"
                            alt="{{ $siteSettings->get('brand_name', 'Obsequium') }}"
                            class="h-16 w-auto object-contain">
                    </div>
                    <p class="text-sm text-white/70 leading-relaxed mb-5">
                        {{ $siteSettings->get('footer_description', 'Votre partenaire expert en QHSE.') }}
                    </p>
                    @if ($siteSettings->get('linkedin_url') && $siteSettings->get('linkedin_url') !== '#')
                        <div class="flex gap-3">
                            <a href="{{ $siteSettings->get('linkedin_url') }}" target="_blank"
                                rel="noopener noreferrer"
                                class="w-9 h-9 bg-white/10 hover:bg-[#769044] rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Services -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Services</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('services.index') }}"
                                class="hover:text-brand-400 transition-colors">Tous nos services</a></li>
                        <li><a href="{{ route('services.index', ['type' => 'strategic']) }}"
                                class="hover:text-brand-400 transition-colors">Accompagnement stratégique</a></li>
                        <li><a href="{{ route('services.index', ['type' => 'audit']) }}"
                                class="hover:text-brand-400 transition-colors">Audit & Contrôle</a></li>
                        <li><a href="{{ route('services.index', ['type' => 'qhse']) }}"
                                class="hover:text-brand-400 transition-colors">Conseil QHSE</a></li>
                        <li><a href="{{ route('services.index', ['type' => 'training']) }}"
                                class="hover:text-brand-400 transition-colors">Formation</a></li>
                        <li><a href="{{ route('formations.index') }}"
                                class="hover:text-brand-400 transition-colors">Catalogue formations</a></li>
                    </ul>
                </div>

                <!-- Cabinet -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Cabinet</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-brand-400 transition-colors">À
                                propos</a></li>
                        <li><a href="{{ route('process') }}" class="hover:text-brand-400 transition-colors">Notre
                                processus</a></li>
                        <li><a href="{{ route('references') }}"
                                class="hover:text-brand-400 transition-colors">Références</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-brand-400 transition-colors">Tarifs &
                                modalités</a></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-brand-400 transition-colors">Blog &
                                Actualités</a></li>
                        <li><a href="{{ route('contact') }}"
                                class="hover:text-brand-400 transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact & Newsletter -->
                <div>
                    <h3
                        class="text-white font-semibold text-xs uppercase tracking-widest mb-4 border-b border-white/20 pb-2">
                        Restons en contact</h3>
                    <ul class="space-y-3 text-sm mb-6">
                        @if ($siteSettings->get('contact_email'))
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 text-[#96B857] shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <a href="mailto:{{ $siteSettings->get('contact_email') }}"
                                    class="text-white/80 hover:text-[#96B857] transition-colors">{{ $siteSettings->get('contact_email') }}</a>
                            </li>
                        @endif
                        @if ($siteSettings->get('contact_phone'))
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 text-[#96B857] shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div>
                                    <div>{{ $siteSettings->get('contact_phone') }}</div>
                                    @if ($siteSettings->get('contact_phone_alt'))
                                        <div class="text-white/50 text-xs">
                                            {{ $siteSettings->get('contact_phone_alt') }}</div>
                                    @endif
                                </div>
                            </li>
                        @endif
                        @if ($siteSettings->get('contact_address'))
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 text-[#96B857] shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <div>{{ $siteSettings->get('contact_address') }}</div>
                                    @if ($siteSettings->get('contact_postal'))
                                        <div class="text-white/50 text-xs">{{ $siteSettings->get('contact_postal') }}
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endif
                        @if ($siteSettings->get('contact_hours'))
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 text-[#96B857] shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $siteSettings->get('contact_hours') }}</span>
                            </li>
                        @endif
                    </ul>
                    <p class="text-xs text-white/50 mb-2">Newsletter - nos actualités QHSE</p>
                    <livewire:newsletter-form compact />
                </div>
            </div>

            @if ($siteSettings->get('brand_slogan'))
                <div class="border-t border-white/20 pt-6 mb-6 text-center">
                    <p class="text-[#96B857] italic text-sm">« {{ $siteSettings->get('brand_slogan') }} »</p>
                </div>
            @endif

            <div
                class="border-t border-white/20 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-white/50">
                <div class="text-center sm:text-left">
                    <p class="text-white/60">© {{ date('Y') }}
                        {{ $siteSettings->get('brand_name', 'OBSEQUIUM') }}. Tous droits réservés.</p>
                    @if ($siteSettings->get('rccm'))
                        <p class="text-xs text-white/40 mt-1">RCCM : {{ $siteSettings->get('rccm') }}</p>
                    @endif
                </div>
                <div class="flex gap-6">
                    <a href="{{ route('legal') }}" class="text-white/50 hover:text-white transition-colors">Mentions
                        légales</a>
                    <a href="{{ route('privacy') }}"
                        class="text-white/50 hover:text-white transition-colors">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>

</html>
