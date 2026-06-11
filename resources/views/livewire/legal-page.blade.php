<div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Mentions légales</h1>
        <div class="prose prose-gray max-w-none">
            <h2>Éditeur du site</h2>
            <p>
                <strong>{{ \App\Models\SiteSetting::get('brand_name', 'OBSEQUIUM') }}</strong> - {{ \App\Models\SiteSetting::get('brand_tagline', 'Cabinet de Conseil en Management Qualité et Conformité') }}<br>
                @if($manager = \App\Models\SiteSetting::get('manager_name'))
                Gérant : {{ $manager }}<br>
                @endif
                Siège social : {{ \App\Models\SiteSetting::get('contact_address', 'Cocody, Abidjan - Côte d’Ivoire') }}<br>
                Adresse postale : {{ \App\Models\SiteSetting::get('contact_postal', '08 BP 2940 ABIDJAN 08') }}<br>
                RCCM : {{ \App\Models\SiteSetting::get('rccm', 'CI-ABJ-03-2026-B13-06180') }}<br>
                Email : <a href="mailto:{{ \App\Models\SiteSetting::get('contact_email') }}">{{ \App\Models\SiteSetting::get('contact_email') }}</a>@if($alt = \App\Models\SiteSetting::get('contact_email_manager')) / <a href="mailto:{{ $alt }}">{{ $alt }}</a>@endif<br>
                Tél. : {{ \App\Models\SiteSetting::get('contact_phone') }}@if($p2 = \App\Models\SiteSetting::get('contact_phone_alt')) / {{ $p2 }}@endif
            </p>

            <h2>Hébergement</h2>
            <p>Ce site est hébergé par un prestataire conforme aux obligations de sécurité et de protection des données. Les coordonnées de l'hébergeur sont disponibles sur simple demande à <a href="mailto:{{ \App\Models\SiteSetting::get('contact_email') }}">{{ \App\Models\SiteSetting::get('contact_email') }}</a>.</p>

            <h2>Propriété intellectuelle</h2>
            <p>L'ensemble du contenu de ce site (textes, images, graphismes, logo, marque OBSEQUIUM) est la propriété exclusive du cabinet OBSEQUIUM, sauf mention contraire. Toute reproduction, représentation ou exploitation, totale ou partielle, est interdite sans autorisation écrite préalable.</p>

            <h2>Confidentialité</h2>
            <p>OBSEQUIUM s'engage à respecter la confidentialité de toutes les informations clients communiquées dans le cadre de ses missions d'audit, de conseil, de formation et d'accompagnement. Un contrat formel encadre les droits et obligations de chaque partie.</p>

            <h2>Limitation de responsabilité</h2>
            <p>OBSEQUIUM s'efforce d'assurer l'exactitude et la mise à jour des informations diffusées sur ce site. Cependant, les informations sont fournies sans garantie d'aucune sorte et n'engagent pas la responsabilité du cabinet en cas d'utilisation par un tiers à des fins autres qu'informatives.</p>

            <h2>Droit applicable</h2>
            <p>Les présentes mentions légales sont régies par le droit ivoirien. Tout litige relatif à l'utilisation du site sera soumis aux tribunaux compétents d'Abidjan.</p>
        </div>
    </div>
</div>
