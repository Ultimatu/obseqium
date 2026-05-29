<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Facture {{ $invoice->reference }}</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #1e293b; line-height: 1.5; }

  .header { background: #7c9131; color: #fff; padding: 28px 36px; margin-bottom: 28px; }
  .header-top { display: flex; justify-content: space-between; align-items: flex-start; }
  .brand-name { font-size: 20px; font-weight: 700; }
  .brand-tagline { font-size: 11px; color: #e4edc5; margin-top: 2px; }
  .reference-box { text-align: right; }
  .reference-box .ref { font-size: 18px; font-weight: 700; }
  .reference-box .date { font-size: 11px; color: #e4edc5; margin-top: 4px; }

  .parties { display: flex; gap: 24px; margin: 0 36px 24px; }
  .party { flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 16px; }
  .party-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #64748b; margin-bottom: 8px; }
  .party-name { font-weight: 700; font-size: 14px; margin-bottom: 4px; }
  .party-detail { color: #475569; font-size: 12px; }

  .status-paid { display: inline-block; background: #dcfce7; color: #166534; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; padding: 4px 10px; border-radius: 4px; margin: 0 36px 16px; }

  table.items { width: calc(100% - 72px); margin: 0 36px 24px; border-collapse: collapse; }
  table.items th { background: #7c9131; color: #fff; font-size: 11px; text-transform: uppercase; letter-spacing: .04em; padding: 10px 12px; text-align: left; }
  table.items th.right { text-align: right; }
  table.items td { padding: 10px 12px; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
  table.items td.right { text-align: right; }
  table.items tr:nth-child(even) td { background: #f8fafc; }
  .item-desc { font-weight: 600; }
  .item-detail { font-size: 11px; color: #64748b; margin-top: 2px; }

  .totals { margin: 0 36px 24px; }
  .totals-table { margin-left: auto; width: 280px; border-collapse: collapse; }
  .totals-table td { padding: 6px 12px; font-size: 13px; }
  .totals-table td:last-child { text-align: right; font-weight: 600; }
  .totals-table .total-row td { background: #7c9131; color: #fff; font-size: 14px; font-weight: 700; border-radius: 4px; }

  .payment-info { margin: 0 36px 24px; background: #eff6ff; border-left: 3px solid #3b82f6; padding: 12px 16px; border-radius: 4px; font-size: 12px; color: #1e40af; }
  .payment-info strong { display: block; margin-bottom: 4px; }

  .notes { margin: 0 36px 24px; background: #fffbeb; border-left: 3px solid #f59e0b; padding: 12px 16px; border-radius: 4px; font-size: 12px; color: #92400e; }
  .notes strong { display: block; margin-bottom: 4px; }

  .footer { margin-top: 36px; border-top: 1px solid #e2e8f0; padding: 14px 36px; font-size: 11px; color: #94a3b8; display: flex; justify-content: space-between; }
</style>
</head>
<body>

<div class="header">
  <div class="header-top">
    <div>
      <div class="brand-name">{{ $settings['brand_name'] ?? config('app.name') }}</div>
      <div class="brand-tagline">{{ $settings['tagline'] ?? 'Conseil & Formation QHSE' }}</div>
    </div>
    <div class="reference-box">
      <div class="ref">FACTURE {{ $invoice->reference }}</div>
      <div class="date">Émise le {{ $invoice->issued_at->format('d/m/Y') }}</div>
      <div class="date">Échéance le {{ $invoice->due_at->format('d/m/Y') }}</div>
      @if($invoice->quote)<div class="date">Réf. devis : {{ $invoice->quote->reference }}</div>@endif
    </div>
  </div>
</div>

@if($invoice->paid_at)
  <div class="status-paid"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;margin-right:4px"><polyline points="20 6 9 17 4 12"></polyline></svg> Payée le {{ $invoice->paid_at->format('d/m/Y') }}</div>
@endif

<div class="parties">
  <div class="party">
    <div class="party-title">Émetteur</div>
    <div class="party-name">{{ $settings['brand_name'] ?? config('app.name') }}</div>
    @if($settings['contact_email'] ?? null)<div class="party-detail">{{ $settings['contact_email'] }}</div>@endif
    @if($settings['contact_phone'] ?? null)<div class="party-detail">{{ $settings['contact_phone'] }}</div>@endif
    @if($settings['contact_address'] ?? null)<div class="party-detail">{{ $settings['contact_address'] }}</div>@endif
  </div>
  <div class="party">
    <div class="party-title">Facturé à</div>
    <div class="party-name">{{ $invoice->client_name }}</div>
    @if($invoice->client_company)<div class="party-detail">{{ $invoice->client_company }}</div>@endif
    <div class="party-detail">{{ $invoice->client_email }}</div>
    @if($invoice->client_phone)<div class="party-detail">{{ $invoice->client_phone }}</div>@endif
    @if($invoice->client_address)<div class="party-detail">{{ $invoice->client_address }}</div>@endif
  </div>
</div>

@if($invoice->items->count())
<table class="items">
  <thead>
    <tr>
      <th style="width:45%">Désignation</th>
      <th class="right" style="width:12%">Qté</th>
      <th style="width:12%">Unité</th>
      <th class="right" style="width:15%">P.U. HT</th>
      <th class="right" style="width:16%">Total HT</th>
    </tr>
  </thead>
  <tbody>
    @foreach($invoice->items as $item)
    <tr>
      <td>
        <div class="item-desc">{{ $item->description }}</div>
        @if($item->details)<div class="item-detail">{{ $item->details }}</div>@endif
      </td>
      <td class="right">{{ number_format($item->quantity, 2, ',', '') }}</td>
      <td>{{ $item->unit }}</td>
      <td class="right">{{ number_format($item->unit_price, 2, ',', ' ') }} {{ $currency }}</td>
      <td class="right">{{ number_format($item->total, 2, ',', ' ') }} {{ $currency }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<div class="totals">
  <table class="totals-table">
    <tr>
      <td style="color:#64748b">Sous-total HT</td>
      <td>{{ number_format($invoice->subtotal, 2, ',', ' ') }} {{ $currency }}</td>
    </tr>
    <tr>
      <td style="color:#64748b">TVA ({{ number_format($invoice->tax_rate, 0) }}%)</td>
      <td>{{ number_format($invoice->tax_amount, 2, ',', ' ') }} {{ $currency }}</td>
    </tr>
    <tr class="total-row">
      <td>Total TTC</td>
      <td>{{ number_format($invoice->total, 2, ',', ' ') }} {{ $currency }}</td>
    </tr>
  </table>
</div>
@endif

@if(! $invoice->paid_at)
<div class="payment-info">
  <strong>Modalités de paiement</strong>
  Règlement par virement bancaire sous 30 jours. Échéance : {{ $invoice->due_at->format('d/m/Y') }}.
</div>
@endif

@if($invoice->notes)
<div class="notes">
  <strong>Notes</strong>
  {{ $invoice->notes }}
</div>
@endif

<div class="footer">
  <span>{{ $settings['brand_name'] ?? config('app.name') }} — {{ $settings['contact_email'] ?? config('mail.from.address') }}</span>
  <span>{{ $invoice->reference }} · Généré le {{ now()->format('d/m/Y') }}</span>
</div>

</body>
</html>
