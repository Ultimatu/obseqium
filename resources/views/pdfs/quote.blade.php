<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Devis {{ $quote->reference }}</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1e293b; line-height: 1.55; background: #fff; }

/* ── Header ──────────────────────────────────────────── */
.header { background: #46511f; padding: 0; margin-bottom: 0; }
.header-inner { display: flex; justify-content: space-between; align-items: stretch; }
.header-left { padding: 28px 32px; flex: 1; }
.header-right { background: #7c9131; padding: 28px 32px; min-width: 220px; text-align: right; }
.logo img { max-height: 52px; max-width: 180px; }
.brand-name { font-size: 19px; font-weight: 700; color: #fff; letter-spacing: .01em; }
.brand-tagline { font-size: 10px; color: #cfdba3; margin-top: 3px; text-transform: uppercase; letter-spacing: .06em; }
.brand-legal { margin-top: 10px; font-size: 9.5px; color: #e4edc5; line-height: 1.6; }

.doc-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: #cfdba3; margin-bottom: 6px; }
.doc-ref { font-size: 20px; font-weight: 700; color: #fff; letter-spacing: .02em; }
.doc-dates { margin-top: 8px; font-size: 10px; color: #e4edc5; line-height: 1.8; }
.doc-status { display: inline-block; margin-top: 10px; background: rgba(255,255,255,.15); border-radius: 20px; padding: 3px 12px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #fff; }

/* ── Stripe ──────────────────────────────────────────── */
.stripe { height: 4px; background: linear-gradient(to right, #46511f, #a3bb4e, #46511f); }

/* ── Parties ─────────────────────────────────────────── */
.parties { display: flex; gap: 16px; margin: 24px 32px; }
.party { flex: 1; border-radius: 8px; overflow: hidden; }
.party-head { padding: 8px 14px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; }
.party-emitter .party-head { background: #46511f; color: #cfdba3; }
.party-client .party-head { background: #f1f5f9; color: #64748b; }
.party-body { padding: 12px 14px; border: 1px solid #e2e8f0; border-top: none; border-radius: 0 0 8px 8px; }
.party-name { font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
.party-detail { font-size: 10.5px; color: #475569; line-height: 1.7; }

/* ── Object ──────────────────────────────────────────── */
.object-box { margin: 0 32px 20px; background: #f8fafc; border-left: 3px solid #7c9131; padding: 10px 14px; border-radius: 0 6px 6px 0; }
.object-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #64748b; margin-bottom: 3px; }
.object-text { font-size: 12px; color: #334155; }

/* ── Table ───────────────────────────────────────────── */
table.items { width: calc(100% - 64px); margin: 0 32px 20px; border-collapse: collapse; }
table.items thead tr th { background: #46511f; color: #fff; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; padding: 9px 11px; text-align: left; }
table.items thead tr th.r { text-align: right; }
table.items tbody tr td { padding: 9px 11px; border-bottom: 1px solid #e9eff5; vertical-align: top; font-size: 11.5px; }
table.items tbody tr td.r { text-align: right; }
table.items tbody tr:nth-child(even) td { background: #f8fafc; }
table.items tbody tr:last-child td { border-bottom: 2px solid #46511f; }
.item-name { font-weight: 600; color: #0f172a; }
.item-detail { font-size: 10px; color: #64748b; margin-top: 2px; }

/* ── Totaux ──────────────────────────────────────────── */
.totals-wrap { display: flex; justify-content: flex-end; margin: 0 32px 20px; }
.totals-table { width: 290px; border-collapse: collapse; }
.totals-table td { padding: 6px 11px; font-size: 11.5px; border-bottom: 1px solid #f1f5f9; }
.totals-table td:last-child { text-align: right; font-weight: 600; color: #0f172a; }
.totals-table td:first-child { color: #64748b; }
.totals-table .ttc td { background: #46511f; color: #fff !important; font-size: 13px; font-weight: 700; }

/* ── En lettres ─────────────────────────────────────── */
.amount-words { margin: 0 32px 20px; background: #f9fbf4; border: 1px solid #cfdba3; border-radius: 6px; padding: 10px 14px; }
.amount-words-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #617029; margin-bottom: 3px; }
.amount-words-text { font-size: 12px; font-style: italic; color: #46511f; font-weight: 600; }

/* ── Notes ───────────────────────────────────────────── */
.notes { margin: 0 32px 20px; background: #fffbeb; border-left: 3px solid #f59e0b; padding: 10px 14px; border-radius: 0 6px 6px 0; font-size: 11px; color: #78350f; }
.notes-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 4px; color: #92400e; }

/* ── Validité ────────────────────────────────────────── */
.validity { margin: 0 32px 24px; font-size: 10.5px; color: #64748b; padding: 8px 14px; background: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0; }

/* ── Signatures ──────────────────────────────────────── */
.sig-section { margin: 0 32px 8px; }
.sig-section-title { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #64748b; margin-bottom: 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px; }
.sig-row { display: flex; gap: 20px; }
.sig-box { flex: 1; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
.sig-box-head { background: #f8fafc; padding: 8px 14px; font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #475569; border-bottom: 1px solid #e2e8f0; }
.sig-box-body { padding: 12px 14px; min-height: 90px; }
.sig-box-body .sig-img img { max-height: 70px; max-width: 180px; }
.sig-box-body .sig-name { font-size: 10.5px; font-weight: 600; color: #0f172a; margin-top: 8px; }
.sig-box-body .sig-date { font-size: 10px; color: #64748b; margin-top: 2px; }
.sig-placeholder { font-size: 10px; color: #94a3b8; font-style: italic; line-height: 1.8; }
.sig-line { border-bottom: 1px dashed #cbd5e1; margin: 28px 0 4px; }
.sig-line-label { font-size: 9px; color: #94a3b8; }

/* ── CGV ─────────────────────────────────────────────── */
.terms-section { margin: 20px 32px 0; border-top: 2px solid #e2e8f0; padding-top: 16px; }
.terms-title { font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #475569; margin-bottom: 10px; }
.terms-text { font-size: 8.5px; color: #64748b; line-height: 1.65; white-space: pre-wrap; }

/* ── Footer ──────────────────────────────────────────── */
.footer { margin-top: 20px; border-top: 1px solid #e2e8f0; padding: 10px 32px; display: flex; justify-content: space-between; font-size: 9px; color: #94a3b8; }
</style>
</head>
<body>

{{-- ── En-tête ──────────────────────────────────────────── --}}
<div class="header">
  <div class="header-inner">
    <div class="header-left">
      @if($logoBase64)
      <div class="logo" style="margin-bottom:10px"><img src="{{ $logoBase64 }}" alt="Logo"></div>
      @else
      <div class="brand-name">{{ $settings->get('quote_legal_name', $settings->get('brand_name', config('app.name'))) }}</div>
      <div class="brand-tagline">{{ $settings->get('brand_tagline', 'Conseil & Formation QHSE') }}</div>
      @endif
      <div class="brand-legal">
        @if($settings->get('quote_legal_name')) {{ $settings->get('quote_legal_name') }}<br>@endif
        @if($settings->get('quote_rccm')) RCCM : {{ $settings->get('quote_rccm') }}<br>@endif
        @if($settings->get('quote_cc')) CC : {{ $settings->get('quote_cc') }}<br>@endif
        @if($settings->get('quote_ape')) Activité : {{ $settings->get('quote_ape') }}@endif
        @if($settings->get('quote_capital'))  — Capital : {{ $settings->get('quote_capital') }}@endif
      </div>
    </div>
    <div class="header-right">
      <div class="doc-ref" style="font-size:14px; margin-top:4px">{{ $quote->reference }}</div>
      <div class="doc-dates">
        Émis le : {{ $quote->created_at->format('d/m/Y') }}<br>
        @if($quote->valid_until)
        Valable jusqu'au : <strong style="color:#fff">{{ $quote->valid_until->format('d/m/Y') }}</strong>
        @elseif($settings->get('quote_validity_days'))
        Valable {{ $settings->get('quote_validity_days') }} jours
        @endif
      </div>
      <div class="doc-status">{{ match($quote->status) { 'draft' => 'Brouillon', 'sent' => 'Envoyé', 'accepted' => 'Accepté', 'rejected' => 'Refusé', default => ucfirst($quote->status) } }}</div>
    </div>
  </div>
</div>
<div class="stripe"></div>

{{-- ── Parties ───────────────────────────────────────────── --}}
<div class="parties">
  <div class="party party-emitter">
    <div class="party-head">Source</div>
    <div class="party-body">
      <div class="party-name">{{ $settings->get('quote_legal_name', $settings->get('brand_name', config('app.name'))) }}</div>
      @if($settings->get('contact_address'))<div class="party-detail">{{ $settings->get('contact_address') }}</div>@endif
      @if($settings->get('contact_email'))<div class="party-detail">{{ $settings->get('contact_email') }}</div>@endif
      @if($settings->get('contact_phone'))<div class="party-detail">{{ $settings->get('contact_phone') }}</div>@endif
    </div>
  </div>
  <div class="party party-client">
    <div class="party-head">Facture pour :</div>
    <div class="party-body">
      <div class="party-name">{{ $quote->client_name }}</div>
      @if($quote->client_company)<div class="party-detail">{{ $quote->client_company }}</div>@endif
      @if($quote->client_job_title)<div class="party-detail">{{ $quote->client_job_title }}</div>@endif
      <div class="party-detail">{{ $quote->client_email }}</div>
      @if($quote->client_phone)<div class="party-detail">{{ $quote->client_phone }}</div>@endif
    </div>
  </div>
</div>

{{-- ── Objet ─────────────────────────────────────────────── --}}
@if($quote->description)
<div class="object-box">
  <div class="object-label">Objet de la prestation</div>
  <div class="object-text">{{ $quote->description }}</div>
</div>
@endif

{{-- ── Lignes ────────────────────────────────────────────── --}}
@if($quote->items->count())
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
    @foreach($quote->items->sortBy('order') as $item)
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

{{-- ── Totaux ─────────────────────────────────────────────── --}}
<div class="totals-wrap">
  <table class="totals-table">
    <tr>
      <td>Sous-total HT</td>
      <td>{{ number_format($quote->subtotal, 2, ',', ' ') }} {{ $currency }}</td>
    </tr>
    @if($quote->tax_rate > 0)
    <tr>
      <td>TVA ({{ number_format($quote->tax_rate, 0) }} %)</td>
      <td>{{ number_format($quote->tax_amount, 2, ',', ' ') }} {{ $currency }}</td>
    </tr>
    @else
    <tr>
      <td colspan="2" style="font-size:10px; color:#64748b; font-style:italic">TVA non applicable</td>
    </tr>
    @endif
    <tr class="ttc">
      <td>Total TTC</td>
      <td>{{ number_format($quote->total, 2, ',', ' ') }} {{ $currency }}</td>
    </tr>
  </table>
</div>

{{-- ── Montant en lettres ─────────────────────────────────── --}}
<div class="amount-words">
  <div class="amount-words-label">Arrêté le présent devis à la somme de</div>
  <div class="amount-words-text">{{ $totalInWords }} TTC</div>
</div>
@endif

{{-- ── Conditions particulières ──────────────────────────── --}}
@if($quote->notes)
<div class="notes">
  <div class="notes-label">Conditions particulières</div>
  {{ $quote->notes }}
</div>
@endif

{{-- ── Validité ───────────────────────────────────────────── --}}
@if($quote->valid_until)
<div class="validity">
  Ce devis est valable jusqu'au <strong>{{ $quote->valid_until->format('d/m/Y') }}</strong>.
  Passé ce délai, une nouvelle proposition pourra être établie sur demande.
</div>
@endif

{{-- ── Signatures ─────────────────────────────────────────── --}}
<div class="sig-section">
  <div class="sig-section-title">Bon pour accord — Signatures</div>
  <div class="sig-row">

    {{-- Signature émetteur --}}
    <div class="sig-box">
      <div class="sig-box-head">Pour {{ $settings->get('quote_legal_name', $settings->get('brand_name', config('app.name'))) }}</div>
      <div class="sig-box-body">
        @if($signatureBase64)
        <div class="sig-img"><img src="{{ $signatureBase64 }}" alt="Signature"></div>
        @else
        <div class="sig-line"></div>
        <div class="sig-line-label">Signature</div>
        @endif
        <div class="sig-name">{{ $settings->get('quote_legal_name', $settings->get('brand_name', config('app.name'))) }}</div>
        <div class="sig-date">Le {{ now()->format('d/m/Y') }}</div>
      </div>
    </div>

    {{-- Signature client --}}
    <div class="sig-box">
      <div class="sig-box-head">Bon pour accord — {{ $quote->client_name }}</div>
      <div class="sig-box-body">
        <div class="sig-placeholder">
          Mention « Bon pour accord »<br>
          Signature + cachet de l'entreprise<br>
          Date : _____ / _____ / _________
        </div>
        <div class="sig-line"></div>
        <div class="sig-line-label">Signature et cachet</div>
      </div>
    </div>

  </div>
</div>

{{-- ── Conditions générales de vente ─────────────────────── --}}
@if($settings->get('quote_terms'))
<div class="terms-section">
  <div class="terms-title">Conditions générales de vente</div>
  <div class="terms-text">{{ $settings->get('quote_terms') }}</div>
</div>
@endif

{{-- ── Footer ──────────────────────────────────────────────── --}}
<div class="footer">
  <span>
    {{ $settings->get('quote_legal_name', $settings->get('brand_name', config('app.name'))) }}
    @if($settings->get('quote_rccm')) — RCCM {{ $settings->get('quote_rccm') }}@endif
    @if($settings->get('quote_cc')) — CC {{ $settings->get('quote_cc') }}@endif
    @if($settings->get('quote_iban')) — IBAN : {{ $settings->get('quote_iban') }}@endif
    @if($settings->get('quote_bank_name')) ({{ $settings->get('quote_bank_name') }})@endif
  </span>
  <span>{{ $quote->reference }} · {{ now()->format('d/m/Y') }}</span>
</div>

</body>
</html>
