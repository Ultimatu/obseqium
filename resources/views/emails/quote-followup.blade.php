<x-emails.partials.layout>
<p>Bonjour {{ $quote->client_name }},</p>
<p>Nous revenons vers vous concernant votre devis <strong>{{ $quote->reference }}</strong> envoyé il y a quelques jours, qui est toujours en attente de votre réponse.</p>
<div class="meta">
  <table>
    <tr><td>Référence</td><td>{{ $quote->reference }}</td></tr>
    @if($quote->total > 0)<tr><td>Montant TTC</td><td><strong>{{ number_format($quote->total, 2, ',', ' ') }} €</strong></td></tr>@endif
    @if($quote->valid_until)<tr><td>Valable jusqu'au</td><td>{{ $quote->valid_until->format('d/m/Y') }}</td></tr>@endif
  </table>
</div>
@if($quote->valid_until && $quote->valid_until->diffInDays(now()) <= 7)
<div class="alert alert-warning">Ce devis expire dans {{ $quote->valid_until->diffInDays(now()) }} jours. Pensez à le valider avant la date d'expiration.</div>
@endif
<p style="text-align:center;margin:24px 0">
  <a href="{{ $quote->portalUrl() }}" class="btn">Consulter et valider mon devis</a>
</p>
<p>N'hésitez pas à nous contacter pour toute question à <a href="mailto:{{ config('mail.from.address') }}" style="color:#1a7a4a">{{ config('mail.from.address') }}</a>.</p>
<p>Cordialement,<br><strong>L'équipe {{ config('app.name') }}</strong></p>
</x-emails.partials.layout>
