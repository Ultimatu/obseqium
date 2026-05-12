<x-emails.partials.layout>
<p>Bonjour {{ $appointment->client_name }},</p>
<p>Nous vous rappelons que vous avez un rendez-vous <strong>demain</strong> avec {{ config('app.name') }}.</p>
<div class="meta">
  <table>
    <tr><td>Date</td><td><strong>{{ ($appointment->confirmed_date ?? $appointment->requested_date)?->format('d/m/Y à H:i') }}</strong></td></tr>
    <tr><td>Type</td><td>{{ $appointment->type === 'visio' ? 'Visioconférence' : 'Présentiel' }}</td></tr>
    @if($appointment->meeting_link)<tr><td>Lien visio</td><td><a href="{{ $appointment->meeting_link }}" style="color:#1a7a4a">Rejoindre la réunion</a></td></tr>@endif
    @if($appointment->location)<tr><td>Lieu</td><td>{{ $appointment->location }}</td></tr>@endif
    @if($appointment->subject)<tr><td>Objet</td><td>{{ $appointment->subject }}</td></tr>@endif
  </table>
</div>
@if($appointment->meeting_link)
<p style="text-align:center;margin:24px 0">
  <a href="{{ $appointment->meeting_link }}" class="btn">Rejoindre la réunion</a>
</p>
@endif
<p>En cas d'empêchement, merci de nous prévenir le plus tôt possible à <a href="mailto:{{ config('mail.from.address') }}" style="color:#1a7a4a">{{ config('mail.from.address') }}</a>.</p>
<p>À demain,<br><strong>L'équipe {{ config('app.name') }}</strong></p>
</x-emails.partials.layout>
