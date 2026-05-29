<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre facture {{ $invoice->reference }}</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #374151; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; padding: 20px 0; border-bottom: 2px solid #0d9488; }
        .logo { font-size: 24px; font-weight: bold; color: #0d9488; }
        .content { padding: 30px 0; }
        .invoice-box { background: #f9fafb; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .amount { font-size: 28px; font-weight: bold; color: #0d9488; }
        .button { display: inline-block; background: #0d9488; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px 0; font-size: 14px; color: #6b7280; border-top: 1px solid #e5e7eb; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { text-align: left; padding: 8px; border-bottom: 1px solid #e5e7eb; }
        th { font-weight: 600; color: #111827; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ $settings->get('brand_name', 'OBSEQUIUM') }}</div>
            <p style="margin: 5px 0 0; color: #6b7280;">{{ $settings->get('brand_tagline', 'Cabinet de conseil en management QHSE') }}</p>
        </div>

        <div class="content">
            <p>Bonjour {{ $invoice->client_name }},</p>

            <p>Veuillez trouver ci-joint votre <strong>facture {{ $invoice->reference }}</strong>.</p>

            <div class="invoice-box">
                <table>
                    <tr>
                        <th>Référence</th>
                        <td>{{ $invoice->reference }}</td>
                    </tr>
                    <tr>
                        <th>Date d'émission</th>
                        <td>{{ $invoice->issued_at->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Échéance</th>
                        <td>{{ $invoice->due_at->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Total TTC</th>
                        <td class="amount">{{ number_format($invoice->total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </table>
            </div>

            <p><strong>Coordonnées bancaires pour le règlement :</strong></p>
            <p style="background: #f3f4f6; padding: 15px; border-radius: 6px; font-family: monospace;">
                {{ $settings->get('bank_name', 'À définir dans les paramètres') }}<br>
                IBAN: {{ $settings->get('bank_iban', '—') }}<br>
                BIC: {{ $settings->get('bank_bic', '—') }}
            </p>

            <p style="margin-top: 30px;">
                Pour toute question concernant cette facture, contactez-nous à <a href="mailto:{{ $settings->get('contact_email', 'accueil@obsequium-ci.com') }}">{{ $settings->get('contact_email', 'accueil@obsequium-ci.com') }}</a>
            </p>

            <p style="margin-top: 30px;">
                Cordialement,<br>
                <strong>L'équipe {{ $settings->get('brand_name', 'OBSEQUIUM') }}</strong>
            </p>
        </div>

        <div class="footer">
            <p>{{ $settings->get('contact_address', 'Cocody, Abidjan') }}</p>
            <p>Tél: {{ $settings->get('contact_phone', '+225 07 79 18 17 67') }} | Email: {{ $settings->get('contact_email', 'accueil@obsequium-ci.com') }}</p>
            <p style="font-size: 12px; margin-top: 15px;">RCCM: {{ $settings->get('rccm', 'CI-ABJ-03-2026-B13-06180') }}</p>
        </div>
    </div>
</body>
</html>
