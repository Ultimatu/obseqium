<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre demande de diagnostic {{ $diagnostic->reference }}</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #374151; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; padding: 20px 0; border-bottom: 2px solid #0d9488; }
        .logo { font-size: 24px; font-weight: bold; color: #0d9488; }
        .content { padding: 30px 0; }
        .box { background: #f0fdf4; border-radius: 8px; padding: 20px; margin: 20px 0; border-left: 4px solid #0d9488; }
        .button { display: inline-block; background: #0d9488; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px 0; font-size: 14px; color: #6b7280; border-top: 1px solid #e5e7eb; }
        .badge { display: inline-block; background: #0d9488; color: white; padding: 4px 12px; border-radius: 4px; font-size: 14px; }
        ul { padding-left: 20px; }
        li { margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ $settings->get('brand_name', 'OBSEQUIUM') }}</div>
            <p style="margin: 5px 0 0; color: #6b7280;">{{ $settings->get('brand_tagline', 'Cabinet de conseil en management QHSE') }}</p>
        </div>

        <div class="content">
            <p>Bonjour {{ $diagnostic->client_name }},</p>

            <p>Nous avons bien reçu votre demande de <strong>diagnostic ISO gratuit</strong>.</p>

            <div class="box">
                <span class="badge">Référence : {{ $diagnostic->reference }}</span>
                <p style="margin-top: 15px;"><strong>Nom :</strong> {{ $diagnostic->client_name }}</p>
                <p><strong>Société :</strong> {{ $diagnostic->client_company ?: 'Non renseigné' }}</p>
                <p><strong>Secteur :</strong> {{ $diagnostic->sector }}</p>
                <p><strong>Normes concernées :</strong></p>
                <ul>
                    @foreach($diagnostic->requested_standards as $standard)
                        <li>{{ $standard }}</li>
                    @endforeach
                </ul>
            </div>

            <h3 style="color: #0d9488;">Prochaines étapes</h3>
            <ol>
                <li><strong>Analyse de votre demande</strong> — Notre équipe étudie votre besoin (24-48h)</li>
                <li><strong>Contact téléphonique</strong> — Nous vous appelons pour planifier la visite</li>
                <li><strong>Diagnostic sur site</strong> — Audit complet de votre organisation</li>
                <li><strong>Rapport et recommandations</strong> — Vous recevez un rapport détaillé</li>
            </ol>

            <p style="background: #fef3c7; padding: 15px; border-radius: 6px; margin: 20px 0;">
                <strong>Gratuit et sans engagement</strong> — Ce diagnostic est une prestation offerte par OBSEQUIUM pour vous permettre d'évaluer votre niveau de conformité.
            </p>

            <p style="margin-top: 30px;">
                Pour toute question, contactez-nous :<br>
                <a href="mailto:{{ $settings->get('contact_email', 'accueil@obsequium-ci.com') }}">{{ $settings->get('contact_email', 'accueil@obsequium-ci.com') }}</a><br>
                {{ $settings->get('contact_phone', '+225 07 79 18 17 67') }}
            </p>

            <p style="margin-top: 30px;">
                Cordialement,<br>
                <strong>L'équipe {{ $settings->get('brand_name', 'OBSEQUIUM') }}</strong>
            </p>
        </div>

        <div class="footer">
            <p>{{ $settings->get('contact_address', 'Cocody, Abidjan') }}</p>
            <p>RCCM: {{ $settings->get('rccm', 'CI-ABJ-03-2026-B13-06180') }}</p>
        </div>
    </div>
</body>
</html>
