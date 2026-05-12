<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Attestation de formation</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #1e293b; line-height: 1.6; }

  .header { background: #7c9131; color: #fff; padding: 28px 36px; margin-bottom: 36px; }
  .brand-name { font-size: 20px; font-weight: 700; }
  .brand-tagline { font-size: 11px; color: #e4edc5; margin-top: 2px; }
  .doc-type { text-align: right; font-size: 14px; font-weight: 700; letter-spacing: .03em; }

  .body { margin: 0 36px; }

  .title-block { text-align: center; margin-bottom: 36px; }
  .title-block h1 { font-size: 26px; font-weight: 700; color: #7c9131; text-transform: uppercase; letter-spacing: .08em; border-bottom: 3px solid #7c9131; display: inline-block; padding-bottom: 6px; }
  .title-block p { margin-top: 6px; font-size: 12px; color: #64748b; }

  .certifies { font-size: 14px; text-align: center; margin-bottom: 28px; color: #475569; }
  .certifies strong { color: #1e293b; }

  .participant-name { font-size: 22px; font-weight: 700; text-align: center; color: #7c9131; margin-bottom: 28px; padding: 16px; border: 2px solid #7c9131; border-radius: 4px; }

  .details-table { width: 100%; border-collapse: collapse; margin-bottom: 32px; }
  .details-table td { padding: 10px 14px; border-bottom: 1px solid #e2e8f0; }
  .details-table td:first-child { font-weight: 700; color: #475569; font-size: 11px; text-transform: uppercase; letter-spacing: .04em; width: 35%; background: #f8fafc; }
  .details-table td:last-child { color: #1e293b; }

  .objectives { margin-bottom: 32px; }
  .objectives h3 { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #64748b; margin-bottom: 10px; }
  .objectives p { font-size: 12px; color: #475569; }

  .signatures { display: flex; gap: 40px; margin-top: 48px; }
  .sig-block { flex: 1; }
  .sig-block p { font-size: 11px; color: #64748b; margin-bottom: 40px; }
  .sig-line { border-top: 1px solid #94a3b8; padding-top: 6px; font-size: 11px; color: #64748b; }

  .footer { margin-top: 48px; padding-top: 16px; border-top: 1px solid #e2e8f0; font-size: 10px; color: #94a3b8; text-align: center; }
  .stamp { border: 2px dashed #7c9131; border-radius: 50%; width: 80px; height: 80px; display: inline-flex; align-items: center; justify-content: center; text-align: center; font-size: 9px; font-weight: 700; color: #7c9131; padding: 8px; margin-top: 8px; }
</style>
</head>
<body>

<div class="header" style="display:flex; justify-content:space-between; align-items:flex-start;">
  <div>
    <div class="brand-name">{{ $settings['brand_name'] ?? config('app.name') }}</div>
    <div class="brand-tagline">{{ $settings['tagline'] ?? 'Excellence QHSE' }}</div>
  </div>
  <div class="doc-type">ATTESTATION DE FORMATION</div>
</div>

<div class="body">

  <div class="title-block">
    <h1>Attestation de Formation</h1>
    <p>Délivrée conformément aux articles L6353-1 et L6353-2 du Code du travail</p>
  </div>

  <p class="certifies">
    <strong>{{ $settings['brand_name'] ?? config('app.name') }}</strong> certifie que
  </p>

  <div class="participant-name">
    {{ $registration->user?->name ?? $registration->guest_name }}
  </div>

  @if($registration->user?->company ?? $registration->guest_company)
    <p style="text-align:center; margin-bottom:24px; color:#475569; font-size:13px;">
      représentant la société <strong>{{ $registration->user?->company ?? $registration->guest_company }}</strong>
    </p>
  @endif

  <p class="certifies" style="margin-bottom:28px;">
    a bien suivi et validé la formation suivante :
  </p>

  <table class="details-table">
    <tr>
      <td>Intitulé de la formation</td>
      <td><strong>{{ $formation->title }}</strong></td>
    </tr>
    <tr>
      <td>Date(s)</td>
      <td>
        {{ $session->start_date->format('d/m/Y') }}
        @if($session->end_date && ! $session->start_date->isSameDay($session->end_date))
          — {{ $session->end_date->format('d/m/Y') }}
        @endif
      </td>
    </tr>
    @if($session->city)
    <tr>
      <td>Lieu</td>
      <td>{{ $session->city }}</td>
    </tr>
    @endif
    @if($formation->duration_hours)
    <tr>
      <td>Durée</td>
      <td>{{ $formation->duration_hours }} heure(s)</td>
    </tr>
    @endif
    @if($formation->format)
    <tr>
      <td>Modalité</td>
      <td>{{ $formation->format }}</td>
    </tr>
    @endif
    <tr>
      <td>Numéro d'inscription</td>
      <td>#{{ $registration->id }}</td>
    </tr>
  </table>

  @if($formation->objectives)
  <div class="objectives">
    <h3>Objectifs de la formation</h3>
    <p>{{ strip_tags($formation->objectives) }}</p>
  </div>
  @endif

  <div class="signatures">
    <div class="sig-block">
      <p>Fait à ______________________, le {{ now()->format('d/m/Y') }}</p>
      <div class="sig-line">Signature du responsable de formation</div>
      <div style="margin-top:16px; text-align:center;">
        <div class="stamp">{{ mb_strtoupper(mb_substr($settings['brand_name'] ?? config('app.name'), 0, 8)) }}</div>
      </div>
    </div>
    <div class="sig-block">
      <p>Signature du(de la) participant(e)</p>
      <div class="sig-line">{{ $registration->user?->name ?? $registration->guest_name }}</div>
    </div>
  </div>

</div>

<div class="footer">
  <p>{{ $settings['brand_name'] ?? config('app.name') }} — {{ $settings['contact_email'] ?? config('mail.from.address') }}</p>
  @if($settings['address'] ?? null)<p>{{ $settings['address'] }}</p>@endif
</div>

</body>
</html>
