<x-emails.partials.layout headerColor="#0f172a" headerSubColor="#94a3b8">
<p>Une nouvelle demande de rendez-vous vient d'être soumise.</p>
<div class="meta">
  <table>
    <tr><td>Client</td><td>{{ $appointment->client_name }}</td></tr>
    <tr><td>Email</td><td><a href="mailto:{{ $appointment->client_email }}" style="color:#1a7a4a">{{ $appointment->client_email }}</a></td></tr>
    @if($appointment->guest_company)<tr><td>Société</td><td>{{ $appointment->guest_company }}</td></tr>@endif
    <tr><td>Type</td><td>{{ $appointment->type === 'visio' ? 'Visioconférence' : 'Présentiel' }}</td></tr>
    <tr><td>Date souhaitée</td><td>{{ $appointment->requested_date?->format('d/m/Y à H:i') }}</td></tr>
    @if($appointment->subject)<tr><td>Objet</td><td>{{ $appointment->subject }}</td></tr>@endif
  </table>
</div>
<p style="margin-top:20px">
  <a href="{{ url('/admin/appointments') }}" class="btn">Gérer le rendez-vous</a>
</p>
</x-emails.partials.layout>
