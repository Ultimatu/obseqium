<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Devis {{ $quote->reference }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1e293b;
            line-height: 1.55;
            background: #fff;
        }

        /* ── Header ──────────────────────────────────────────── */
        .header {
            background: #46511f;
            padding: 20px 32px 16px;
            margin-bottom: 0;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
            padding: 0;
        }

        .brand-name {
            font-size: 19px;
            font-weight: 700;
            color: #fff;
            letter-spacing: .01em;
        }

        .brand-tagline {
            font-size: 10px;
            color: #cfdba3;
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .header-doc {
            text-align: right;
        }

        .doc-title {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #cfdba3;
            margin-bottom: 4px;
        }

        .doc-ref {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            letter-spacing: .02em;
        }

        .doc-status {
            display: block;
            margin-top: 6px;
            background: rgba(255, 255, 255, .18);
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 12px;
            padding: 3px 12px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #fff;
            text-align: center;
        }

        .brand-legal {
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid rgba(255, 255, 255, .2);
            font-size: 9.5px;
            color: #e4edc5;
            line-height: 1.6;
        }

        /* ── Stripe ──────────────────────────────────────────── */
        /* DomPDF ne supporte pas linear-gradient — on simule avec une couleur unie */
        .stripe {
            height: 4px;
            background: #a3bb4e;
        }

        /* ── Parties ─────────────────────────────────────────── */
        .parties-table {
            width: calc(100% - 64px);
            margin: 24px 32px;
            border-collapse: separate;
            border-spacing: 16px 0;
        }

        .parties-table td {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }

        .party {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .party-head {
            padding: 8px 14px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .party-client .party-head {
            background: #f1f5f9;
            color: #64748b;
        }

        .party-emitter .party-head {
            background: #46511f;
            color: #cfdba3;
        }

        .party-body {
            padding: 12px 14px;
        }

        .party-name {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .party-detail {
            font-size: 10.5px;
            color: #475569;
            line-height: 1.7;
        }

        .doc-info {
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #e2e8f0;
        }

        .doc-info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .doc-info-table td {
            padding: 3px 0;
            font-size: 10.5px;
        }

        .doc-info-table td:first-child {
            color: #64748b;
        }

        .doc-info-table td:last-child {
            font-weight: 600;
            color: #0f172a;
            text-align: right;
        }

        /* ── Object ──────────────────────────────────────────── */
        .object-box {
            margin: 0 32px 20px;
            background: #f8fafc;
            border-left: 3px solid #7c9131;
            padding: 10px 14px;
        }

        .object-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
            margin-bottom: 3px;
        }

        .object-text {
            font-size: 12px;
            color: #334155;
        }

        /* ── Table ───────────────────────────────────────────── */
        table.items {
            width: calc(100% - 64px);
            margin: 0 32px 20px;
            border-collapse: collapse;
        }

        table.items thead tr th {
            background: #46511f;
            color: #fff;
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            padding: 9px 11px;
            text-align: left;
        }

        table.items thead tr th.r {
            text-align: right;
        }

        table.items tbody tr td {
            padding: 9px 11px;
            border-bottom: 1px solid #e9eff5;
            vertical-align: top;
            font-size: 11.5px;
        }

        table.items tbody tr td.r {
            text-align: right;
        }

        table.items tbody tr:nth-child(even) td {
            background: #f8fafc;
        }

        table.items tbody tr:last-child td {
            border-bottom: 2px solid #46511f;
        }

        .item-name {
            font-weight: 600;
            color: #0f172a;
        }

        .item-detail {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }

        /* ── Totaux ──────────────────────────────────────────── */
        /* Remplacement de flex justify-content:flex-end par une table avec cellule gauche vide */
        .totals-outer {
            width: calc(100% - 64px);
            margin: 0 32px 20px;
            border-collapse: collapse;
        }

        .totals-outer td.spacer {
            width: 60%;
        }

        .totals-outer td.totals-cell {
            width: 40%;
            vertical-align: top;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 6px 11px;
            font-size: 11.5px;
            border-bottom: 1px solid #f1f5f9;
        }

        .totals-table td:last-child {
            text-align: right;
            font-weight: 600;
            color: #0f172a;
        }

        .totals-table td:first-child {
            color: #64748b;
        }

        .totals-table .ttc td {
            background: #46511f;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
        }

        /* ── En lettres ─────────────────────────────────────── */
        .amount-words {
            margin-top: 8px;
            background: #f9fbf4;
            border: 1px solid #cfdba3;
            border-radius: 6px;
            padding: 10px 14px;
        }

        .amount-words-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #617029;
            margin-bottom: 3px;
        }

        .amount-words-text {
            font-size: 11px;
            font-style: italic;
            color: #46511f;
            font-weight: 600;
        }

        /* ── Notes ───────────────────────────────────────────── */
        .notes {
            margin: 0 32px 20px;
            background: #fffbeb;
            border-left: 3px solid #f59e0b;
            padding: 10px 14px;
            font-size: 11px;
            color: #78350f;
        }

        .notes-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 4px;
            color: #92400e;
        }

        /* ── Validité ────────────────────────────────────────── */
        .validity {
            margin: 0 32px 24px;
            font-size: 10.5px;
            color: #64748b;
            padding: 8px 14px;
            background: #f8fafc;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        /* ── Signatures ──────────────────────────────────────── */
        .sig-section {
            margin: 0 32px 8px;
        }

        .sig-section-title {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
            margin-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 6px;
        }

        /* Remplacement flex par table pour les 2 colonnes de signature */
        .sig-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 20px 0;
        }

        .sig-table td {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }

        .sig-box {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .sig-box-head {
            background: #f8fafc;
            padding: 8px 14px;
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
        }

        .sig-box-body {
            padding: 12px 14px;
            min-height: 90px;
        }

        .sig-box-body .sig-name {
            font-size: 10.5px;
            font-weight: 600;
            color: #0f172a;
            margin-top: 8px;
        }

        .sig-box-body .sig-date {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }

        .sig-placeholder {
            font-size: 10px;
            color: #94a3b8;
            font-style: italic;
            line-height: 1.8;
        }

        .sig-line {
            border-bottom: 1px dashed #cbd5e1;
            margin: 28px 0 4px;
        }

        .sig-line-label {
            font-size: 9px;
            color: #94a3b8;
        }

        /* ── CGV ─────────────────────────────────────────────── */
        .terms-section {
            margin: 20px 32px 0;
            border-top: 2px solid #e2e8f0;
            padding-top: 16px;
        }

        .terms-title {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #475569;
            margin-bottom: 10px;
        }

        .terms-text {
            font-size: 8.5px;
            color: #64748b;
            line-height: 1.65;
            white-space: pre-wrap;
        }

        /* ── Footer ──────────────────────────────────────────── */
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .footer-table td {
            padding: 10px 32px;
            font-size: 9px;
            color: #94a3b8;
        }

        .footer-table td:last-child {
            text-align: right;
        }
    </style>
</head>

<body>

    {{-- ── En-tête ──────────────────────────────────────────── --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="text-align:left;">
                    @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo" style="max-height:56px; max-width:200px;">
                    @else
                    <div class="brand-name">{{ $settings->get('quote_legal_name', $settings->get('brand_name',
                        config('app.name'))) }}</div>
                    <div class="brand-tagline">{{ $settings->get('brand_tagline', 'Conseil & Formation QHSE') }}</div>
                    @endif
                </td>
                <td style="text-align:right; width:200px;">
                    <div class="doc-title">Devis</div>
                    <div class="doc-ref">{{ $quote->reference }}</div>
                    <div class="doc-status">{{ match($quote->status) { 'draft' => 'Brouillon', 'sent' => 'Envoyé',
                        'accepted' => 'Accepté', 'rejected' => 'Refusé', default => ucfirst($quote->status) } }}</div>
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

    {{-- ── Parties ───────────────────────────────────────────── --}}
    <table class="parties-table">
        <tr>
            {{-- Colonne gauche : client --}}
            <td>
                <div class="party party-client">
                    <div class="party-head">Devis établi pour</div>
                    <div class="party-body">
                        <div class="party-name">{{ $quote->client_name }}</div>
                        @if($quote->client_company)<div class="party-detail">{{ $quote->client_company }}</div>@endif
                        @if($quote->client_job_title)<div class="party-detail">{{ $quote->client_job_title }}</div>
                        @endif
                        <div class="party-detail">{{ $quote->client_email }}</div>
                        @if($quote->client_phone)<div class="party-detail">{{ $quote->client_phone }}</div>@endif
                    </div>
                </div>
            </td>
            {{-- Colonne droite : source + référence + dates --}}
            <td>
                <div class="party party-emitter">
                    <div class="party-head">Source</div>
                    <div class="party-body">
                        <div class="party-name">{{ $settings->get('quote_legal_name', $settings->get('brand_name',
                            config('app.name'))) }}</div>
                        @if($settings->get('contact_address'))<div class="party-detail">{{
                            $settings->get('contact_address') }}</div>@endif
                        @if($settings->get('contact_email'))<div class="party-detail">{{ $settings->get('contact_email')
                            }}</div>@endif
                        @if($settings->get('contact_phone'))<div class="party-detail">{{ $settings->get('contact_phone')
                            }}</div>@endif
                        <div class="doc-info">
                            <table class="doc-info-table">
                                <tr>
                                    <td>Référence</td>
                                    <td>{{ $quote->reference }}</td>
                                </tr>
                                <tr>
                                    <td>Date d'émission</td>
                                    <td>{{ $quote->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @if($quote->valid_until)
                                <tr>
                                    <td>Valable jusqu'au</td>
                                    <td>{{ $quote->valid_until->format('d/m/Y') }}</td>
                                </tr>
                                @elseif($settings->get('quote_validity_days'))
                                <tr>
                                    <td>Validité</td>
                                    <td>{{ $settings->get('quote_validity_days') }} jours</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

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

    {{-- ── Totaux + Montant en lettres ───────────────────────── --}}
    <table class="totals-outer">
        <tr>
            <td class="spacer"></td>
            <td class="totals-cell">
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
                <div class="amount-words">
                    <div class="amount-words-label">Arrêté à la somme de</div>
                    <div class="amount-words-text">{{ $totalInWords }} TTC</div>
                </div>
            </td>
        </tr>
    </table>
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
        <div class="sig-section-title">Bon pour accord - Signatures</div>
        <table class="sig-table">
            <tr>
                {{-- Signature émetteur --}}
                <td>
                    <div class="sig-box">
                        <div class="sig-box-head">Pour {{ $settings->get('quote_legal_name',
                            $settings->get('brand_name', config('app.name'))) }}</div>
                        <div class="sig-box-body">
                            @if($signatureBase64)
                            <img src="{{ $signatureBase64 }}" alt="Signature" style="max-height:70px; max-width:180px;">
                            @else
                            <div class="sig-line"></div>
                            <div class="sig-line-label">Signature</div>
                            @endif
                            <div class="sig-name">{{ $settings->get('quote_legal_name', $settings->get('brand_name',
                                config('app.name'))) }}</div>
                            <div class="sig-date">Le {{ now()->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </td>
                {{-- Signature client --}}
                <td>
                    <div class="sig-box">
                        <div class="sig-box-head">Bon pour accord - {{ $quote->client_name }}</div>
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
                </td>
            </tr>
        </table>
    </div>

    {{-- ── Conditions générales de vente ─────────────────────── --}}
    @if($settings->get('quote_terms'))
    <div class="terms-section">
        <div class="terms-title">Conditions générales de vente</div>
        <div class="terms-text">{{ $settings->get('quote_terms') }}</div>
    </div>
    @endif

    {{-- ── Footer ──────────────────────────────────────────────── --}}
    <table class="footer-table">
        <tr>
            <td>
                {{ $settings->get('quote_legal_name', $settings->get('brand_name', config('app.name'))) }}
                @if($settings->get('quote_rccm')) - RCCM {{ $settings->get('quote_rccm') }}@endif
                @if($settings->get('quote_cc')) - CC {{ $settings->get('quote_cc') }}@endif
                @if($settings->get('quote_iban')) - IBAN : {{ $settings->get('quote_iban') }}@endif
                @if($settings->get('quote_bank_name')) ({{ $settings->get('quote_bank_name') }})@endif
            </td>
            <td>{{ $quote->reference }} · {{ now()->format('d/m/Y') }}</td>
        </tr>
    </table>

</body>

</html>