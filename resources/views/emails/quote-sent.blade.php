<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Votre devis {{ $quote->reference }}</title>
<style>
  body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f8fafc; margin: 0; padding: 0; color: #1e293b; }
  .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
  .header { background: #1a7a4a; padding: 32px 40px; }
  .header h1 { color: #ffffff; margin: 0; font-size: 22px; font-weight: 700; }
  .header p { color: #a7f3d0; margin: 4px 0 0; font-size: 14px; }
  .body { padding: 40px; }
  .body p { line-height: 1.7; color: #475569; margin: 0 0 16px; }
  .meta { background: #f1f5f9; border-radius: 8px; padding: 20px 24px; margin: 24px 0; }
  .meta table { width: 100%; border-collapse: collapse; }
  .meta td { padding: 6px 0; font-size: 14px; color: #475569; }
  .meta td:first-child { font-weight: 600; color: #1e293b; width: 40%; }
  .btn { display: inline-block; background: #1a7a4a; color: #ffffff !important; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 15px; margin: 8px 0; }
  .btn-outline { display: inline-block; border: 2px solid #1a7a4a; color: #1a7a4a !important; text-decoration: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; font-size: 14px; margin: 8px 0 8px 12px; }
  .footer { padding: 24px 40px; border-top: 1px solid #e2e8f0; text-align: center; }
  .footer p { font-size: 12px; color: #94a3b8; margin: 0; }
  .warning { background: #fffbeb; border-left: 3px solid #f59e0b; padding: 12px 16px; border-radius: 4px; font-size: 13px; color: #92400e; margin-top: 24px; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>{{ config('app.name') }}</h1>
    <p>Conseil & Formation QHSE</p>
  </div>

  <div class="body">
    <p>Bonjour {{ $quote->client_name }},</p>
    <p>
      Nous avons le plaisir de vous faire parvenir votre devis
      <strong>{{ $quote->reference }}</strong>
      @if($quote->client_company) pour <strong>{{ $quote->client_company }}</strong>@endif.
    </p>

    <div class="meta">
      <table>
        <tr>
          <td>Référence</td>
          <td>{{ $quote->reference }}</td>
        </tr>
        <tr>
          <td>Prestation</td>
          <td>{{ match($quote->service_type) {
            'strategic' => 'Accompagnement stratégique',
            'audit'     => 'Audit',
            'qhse'      => 'Conseil QHSE',
            'training'  => 'Formation',
            default     => 'Autre',
          } }}</td>
        </tr>
        @if($quote->total > 0)
        <tr>
          <td>Montant TTC</td>
          <td><strong>{{ number_format($quote->total, 2, ',', ' ') }} €</strong></td>
        </tr>
        @endif
        @if($quote->valid_until)
        <tr>
          <td>Valable jusqu'au</td>
          <td>{{ $quote->valid_until->format('d/m/Y') }}</td>
        </tr>
        @endif
      </table>
    </div>

    <p>Pour consulter le détail de votre devis, le télécharger en PDF et valider votre accord en ligne, cliquez sur le bouton ci-dessous :</p>

    <p style="text-align:center; margin: 32px 0;">
      <a href="{{ $quote->portalUrl() }}" class="btn">Consulter mon devis</a>
    </p>

    <p>Vous pouvez également télécharger directement le PDF :</p>
    <p>
      <a href="{{ route('quotes.portal.pdf', $quote->token) }}" class="btn-outline">Télécharger le PDF</a>
    </p>

    @if($quote->valid_until)
    <div class="warning">
      Ce devis est valable jusqu'au {{ $quote->valid_until->format('d/m/Y') }}. Au-delà de cette date, merci de nous contacter pour obtenir une nouvelle proposition.
    </div>
    @endif

    <p style="margin-top: 32px;">
      Pour toute question, n'hésitez pas à nous contacter à
      <a href="mailto:{{ config('mail.from.address') }}" style="color:#1a7a4a;">{{ config('mail.from.address') }}</a>.
    </p>

    <p>Cordialement,<br><strong>L'équipe {{ config('app.name') }}</strong></p>
  </div>

  <div class="footer">
    <p>{{ config('app.name') }} · Ce message vous a été envoyé suite à votre demande de devis.</p>
  </div>
</div>
</body>
</html>
