<x-emails.partials.layout>
<p>Bonjour {{ $appointment->client_name }},</p>
<p>Votre demande de rendez-vous a bien été reçue. Nous confirmons votre réservation et vous recontacterons pour valider les détails.</p>
<div class="meta">
  <table>
    <tr><td>Type</td><td>{{ $appointment->type === 'visio' ? 'Visioconférence' : 'Présentiel' }}</td></tr>
    <tr><td>Date souhaitée</td><td>{{ $appointment->requested_date?->format('d/m/Y à H:i') }}</td></tr>
    @if($appointment->subject)<tr><td>Objet</td><td>{{ $appointment->subject }}</td></tr>@endif
    @if($appointment->confirmed_date)<tr><td>Date confirmée</td><td><strong>{{ $appointment->confirmed_date->format('d/m/Y à H:i') }}</strong></td></tr>@endif
    @if($appointment->meeting_link)<tr><td>Lien visio</td><td><a href="{{ $appointment->meeting_link }}" style="color:#1a7a4a">{{ $appointment->meeting_link }}</a></td></tr>@endif
    @if($appointment->location)<tr><td>Lieu</td><td>{{ $appointment->location }}</td></tr>@endif
  </table>
</div>
<p>Pour toute question ou modification, contactez-nous à <a href="mailto:{{ config('mail.from.address') }}" style="color:#1a7a4a">{{ config('mail.from.address') }}</a>.</p>
<p>Cordialement,<br><strong>L'équipe {{ config('app.name') }}</strong></p>
</x-emails.partials.layout>
