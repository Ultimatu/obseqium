<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Facture {{ $invoice->reference }}</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1e293b; line-height: 1.55; background: #fff; }

.header { background: #46511f; padding: 20px 32px 16px; }
.header-table { width: 100%; border-collapse: collapse; }
.header-table td { vertical-align: middle; padding: 0; }
.brand-name { font-size: 19px; font-weight: 700; color: #fff; }
.brand-tagline { font-size: 10px; color: #cfdba3; margin-top: 3px; text-transform: uppercase; }
.doc-title { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: #cfdba3; margin-bottom: 4px; }
.doc-ref { font-size: 20px; font-weight: 700; color: #fff; }
.doc-status { display: block; margin-top: 6px; background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.3); border-radius: 12px; padding: 3px 12px; font-size: 9px; font-weight: 700; text-transform: uppercase; color: #fff; text-align: center; }
.brand-legal { margin-top: 10px; padding-top: 8px; border-top: 1px solid rgba(255,255,255,.2); font-size: 9.5px; color: #e4edc5; line-height: 1.6; }
.stripe { height: 4px; background: #a3bb4e; }

.parties-table { width: calc(100% - 64px); margin: 24px 32px; border-collapse: separate; border-spacing: 16px 0; }
.parties-table td { width: 50%; vertical-align: top; padding: 0; }
.party { border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
.party-head { padding: 8px 14px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; }
.party-client .party-head { background: #f1f5f9; color: #64748b; }
.party-emitter .party-head { background: #46511f; color: #cfdba3; }
.party-body { padding: 12px 14px; }
.party-name { font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
.party-detail { font-size: 10.5px; color: #475569; line-height: 1.7; }
.doc-info { margin-top: 10px; padding-top: 8px; border-top: 1px solid #e2e8f0; }
.doc-info-table { width: 100%; border-collapse: collapse; }
.doc-info-table td { padding: 3px 0; font-size: 10.5px; }
.doc-info-table td:first-child { color: #64748b; }
.doc-info-table td:last-child { font-weight: 600; color: #0f172a; text-align: right; }

.status-paid { display: block; background: #dcfce7; color: #166534; font-size: 11px; font-weight: 700; text-transform: uppercase; padding: 6px 14px; margin: 0 32px 16px; border-radius: 4px; }

table.items { width: calc(100% - 64px); margin: 0 32px 20px; border-collapse: collapse; }
table.items th { background: #46511f; color: #fff; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; padding: 9px 11px; text-align: left; }
table.items th.r { text-align: right; }
table.items td { padding: 9px 11px; border-bottom: 1px solid #e9eff5; vertical-align: top; font-size: 11.5px; }
table.items td.r { text-align: right; }
table.items tr:nth-child(even) td { background: #f8fafc; }
table.items tr:last-child td { border-bottom: 2px solid #46511f; }
.item-name { font-weight: 600; color: #0f172a; }
.item-detail { font-size: 10px; color: #64748b; margin-top: 2px; }

.totals-outer { width: calc(100% - 64px); margin: 0 32px 20px; border-collapse: collapse; }
.totals-outer td.spacer { width: 60%; }
.totals-outer td.totals-cell { width: 40%; vertical-align: top; }
.totals-table { width: 100%; border-collapse: collapse; }
.totals-table td { padding: 6px 11px; font-size: 11.5px; border-bottom: 1px solid #f1f5f9; }
.totals-table td:last-child { text-align: right; font-weight: 600; color: #0f172a; }
.totals-table td:first-child { color: #64748b; }
.totals-table .ttc td { background: #46511f; color: #fff; font-size: 13px; font-weight: 700; }
.amount-words { margin-top: 8px; background: #f9fbf4; border: 1px solid #cfdba3; border-radius: 6px; padding: 10px 14px; }
.amount-words-label { font-size: 9px; font-weight: 700; text-transform: uppercase; color: #617029; margin-bottom: 3px; }
.amount-words-text { font-size: 11px; font-style: italic; color: #46511f; font-weight: 600; }

.payment-info { margin: 0 32px 20px; background: #eff6ff; border-left: 3px solid #3b82f6; padding: 10px 14px; font-size: 11px; color: #1e40af; }
.payment-info strong { display: block; margin-bottom: 3px; font-size: 9px; text-transform: uppercase; letter-spacing: .06em; }

.notes { margin: 0 32px 20px; background: #fffbeb; border-left: 3px solid #f59e0b; padding: 10px 14px; font-size: 11px; color: #78350f; }
.notes strong { display: block; margin-bottom: 3px; font-size: 9px; text-transform: uppercase; letter-spacing: .06em; }

.footer-table { width: 100%; border-collapse: collapse; margin-top: 20px; border-top: 1px solid #e2e8f0; }
.footer-table td { padding: 10px 32px; font-size: 9px; color: #94a3b8; }
.footer-table td:last-child { text-align: right; }
</style>
</head>
<body>

{{-- En-tête --}}
<div class="header">
  <table class="header-table">
    <tr>
      <td style="text-align:left;">
        @if($logoBase64 ?? null)
        <img src="{{ $logoBase64 }}" alt="Logo" style="max-height:56px; max-width:200px;">
        @else
        <div class="brand-name">{{ $settings->get('quote_legal_name', $settings->get('brand_name', config('app.name'))) }}</div>
        <div class="brand-tagline">{{ $settings->get('brand_tagline', 'Conseil & Formation QHSE') }}</div>
        @endif
      </td>
      <td style="text-align:right; width:200px;">
        <div class="doc-title">Facture</div>
        <div class="doc-ref">{{ $invoice->reference }}</div>
        <div class="doc-status">{{ match($invoice->status) { 'draft' => 'Brouillon', 'sent' => 'Envoyée', 'paid' => 'Payée', 'cancelled' => 'Annulée', default => ucfirst($invoice->status) } }}</div>
      </td>
    </tr>
  </table>
  <div class="brand-legal">
    @if($settings->get('quote_legal_name')) {{ $settings->get('quote_legal_name') }}@endif
    @if($settings->get('quote_rccm')) · RCCM : {{ $settings->get('quote_rccm') }}@endif
    @if($settings->get('quote_cc')) · CC : {{ $settings->get('quote_cc') }}@endif
    @if($settings->get('contact_address')) · {{ $settings->get('contact_address') }}@endif
    @if($settings->get('contact_email')) · {{ $settings->get('contact_email') }}@endif
    @if($settings->get('contact_phone')) · {{ $settings->get('contact_phone') }}@endif
  </div>
</div>
<div class="stripe"></div>

@if($invoice->paid_at)
<div class="status-paid">✓ Payée le {{ $invoice->paid_at->format('d/m/Y') }}</div>
@endif

{{-- Parties --}}
<table class="parties-table">
  <tr>
    <td>
      <div class="party party-client">
        <div class="party-head">Facturé à</div>
        <div class="party-body">
          <div class="party-name">{{ $invoice->client_name }}</div>
          @if($invoice->client_company)<div class="party-detail">{{ $invoice->client_company }}</div>@endif
          <div class="party-detail">{{ $invoice->client_email }}</div>
          @if($invoice->client_phone)<div class="party-detail">{{ $invoice->client_phone }}</div>@endif
          @if($invoice->client_address)<div class="party-detail">{{ $invoice->client_address }}</div>@endif
        </div>
      </div>
    </td>
    <td>
      <div class="party party-emitter">
        <div class="party-head">Source</div>
        <div class="party-body">
          <div class="party-name">{{ $settings->get('quote_legal_name', $settings->get('brand_name', config('app.name'))) }}</div>
          @if($settings->get('contact_address'))<div class="party-detail">{{ $settings->get('contact_address') }}</div>@endif
          @if($settings->get('contact_email'))<div class="party-detail">{{ $settings->get('contact_email') }}</div>@endif
          @if($settings->get('contact_phone'))<div class="party-detail">{{ $settings->get('contact_phone') }}</div>@endif
          <div class="doc-info">
            <table class="doc-info-table">
              <tr><td>Référence</td><td>{{ $invoice->reference }}</td></tr>
              <tr><td>Date d'émission</td><td>{{ $invoice->issued_at->format('d/m/Y') }}</td></tr>
              @if($invoice->due_at)<tr><td>Échéance</td><td>{{ $invoice->due_at->format('d/m/Y') }}</td></tr>@endif
              @if($invoice->quote)<tr><td>Réf. devis</td><td>{{ $invoice->quote->reference }}</td></tr>@endif
            </table>
          </div>
        </div>
      </div>
    </td>
  </tr>
</table>

{{-- Lignes --}}
@if($invoice->items->count())
<table class="items">
  <thead>
    <tr>
      <th style="width:46%">Désignation</th>
      <th class="r" style="width:10%">Qté</th>
      <th style="width:11%">Unité</th>
      <th class="r" style="width:15%">P.U. HT</th>
      <th class="r" style="width:18%">Total HT</th>
    </tr>
  </thead>
  <tbody>
    @foreach($invoice->items as $item)
    <tr>
      <td>
        <div class="item-name">{{ $item->description }}</div>
        @if($item->details)<div class="item-detail">{{ $item->details }}</div>@endif
      </td>
      <td class="r">{{ rtrim(rtrim(number_format($item->quantity, 2, ',', ''), '0'), ',') }}</td>
      <td>{{ $item->unit }}</td>
      <td class="r">{{ number_format($item->unit_price, 2, ',', ' ') }} {{ $currency }}</td>
      <td class="r">{{ number_format($item->total, 2, ',', ' ') }} {{ $currency }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

{{-- Totaux --}}
<table class="totals-outer">
  <tr>
    <td class="spacer"></td>
    <td class="totals-cell">
      <table class="totals-table">
        <tr>
          <td>Sous-total HT</td>
          <td>{{ number_format($invoice->subtotal, 2, ',', ' ') }} {{ $currency }}</td>
        </tr>
        @if($invoice->tax_rate > 0)
        <tr>
          <td>TVA ({{ number_format($invoice->tax_rate, 0) }}%)</td>
          <td>{{ number_format($invoice->tax_amount, 2, ',', ' ') }} {{ $currency }}</td>
        </tr>
        @else
        <tr>
          <td colspan="2" style="font-size:10px; color:#64748b; font-style:italic">TVA non applicable</td>
        </tr>
        @endif
        <tr class="ttc">
          <td>Total TTC</td>
          <td>{{ number_format($invoice->total, 2, ',', ' ') }} {{ $currency }}</td>
        </tr>
      </table>
      <div class="amount-words">
        <div class="amount-words-label">Arrêté à la somme de</div>
        <div class="amount-words-text">{{ \App\Helpers\NumberToWords::convert((float) $invoice->total, $currency) }} TTC</div>
      </div>
    </td>
  </tr>
</table>
@endif

@if(! $invoice->paid_at)
<div class="payment-info">
  <strong>Modalités de paiement</strong>
  Règlement par virement bancaire. Échéance : {{ $invoice->due_at->format('d/m/Y') }}.
  @if($settings->get('quote_iban')) — IBAN : {{ $settings->get('quote_iban') }}@endif
  @if($settings->get('quote_bank_name')) ({{ $settings->get('quote_bank_name') }})@endif
</div>
@endif

@if($invoice->notes)
<div class="notes">
  <strong>Notes</strong>
  {{ $invoice->notes }}
</div>
@endif

{{-- Footer --}}
<table class="footer-table">
  <tr>
    <td>
      {{ $settings->get('quote_legal_name', $settings->get('brand_name', config('app.name'))) }}
      @if($settings->get('quote_rccm')) - RCCM {{ $settings->get('quote_rccm') }}@endif
      @if($settings->get('contact_email')) - {{ $settings->get('contact_email') }}@endif
    </td>
    <td>{{ $invoice->reference }} · {{ now()->format('d/m/Y') }}</td>
  </tr>
</table>

</body>
</html>
