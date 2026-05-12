<x-emails.partials.layout>
<p>Bonjour {{ $registration->user?->name ?? $registration->guest_name }},</p>
<p>Nous avons le plaisir de vous adresser votre attestation de formation pour :</p>
<div class="meta">
  <table>
    <tr><td>Formation</td><td><strong>{{ $registration->session->formation->title }}</strong></td></tr>
    <tr><td>Dates</td><td>{{ $registration->session->start_date->format('d/m/Y') }}@if($registration->session->end_date && $registration->session->end_date != $registration->session->start_date) — {{ $registration->session->end_date->format('d/m/Y') }}@endif</td></tr>
    @if($registration->session->city)<tr><td>Lieu</td><td>{{ $registration->session->city }}</td></tr>@endif
  </table>
</div>
<p>Votre attestation de formation est jointe à ce message en format PDF.</p>
<p>Nous vous remercions de votre participation et espérons avoir répondu à vos attentes.</p>
<p>Cordialement,<br><strong>L'équipe {{ config('app.name') }}</strong></p>
</x-emails.partials.layout>
