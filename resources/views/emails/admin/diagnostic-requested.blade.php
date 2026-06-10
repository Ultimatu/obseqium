<x-emails.partials.layout headerColor="#0f172a" headerSubColor="#94a3b8">
<p>Une nouvelle demande de diagnostic gratuit vient d'être soumise via le site. <strong>Une action est requise de votre part.</strong></p>
<div class="meta">
  <table>
    <tr><td>Référence</td><td><strong>{{ $diagnostic->reference }}</strong></td></tr>
    <tr><td>Client</td><td>{{ $diagnostic->client_name }}</td></tr>
    <tr><td>Email</td><td><a href="mailto:{{ $diagnostic->client_email }}" style="color:#1a7a4a">{{ $diagnostic->client_email }}</a></td></tr>
    @if($diagnostic->client_phone)<tr><td>Téléphone</td><td>{{ $diagnostic->client_phone }}</td></tr>@endif
    @if($diagnostic->client_company)<tr><td>Société</td><td>{{ $diagnostic->client_company }}</td></tr>@endif
    @if($diagnostic->sector)<tr><td>Secteur</td><td>{{ $diagnostic->sector }}</td></tr>@endif
    @if($diagnostic->company_size)<tr><td>Taille entreprise</td><td>{{ $diagnostic->company_size }}</td></tr>@endif
    @if($diagnostic->requested_standards)<tr><td>Normes souhaitées</td><td>{{ implode(', ', (array) $diagnostic->requested_standards) }}</td></tr>@endif
    @if($diagnostic->requested_date)<tr><td>Date souhaitée</td><td>{{ $diagnostic->requested_date->format('d/m/Y') }}</td></tr>@endif
  </table>
</div>
@if($diagnostic->notes)
<div class="alert alert-info">
  <strong>Notes :</strong><br>{{ $diagnostic->notes }}
</div>
@endif
<p style="margin-top:20px">
  <a href="{{ url('/admin/diagnostic-requests') }}" class="btn">Gérer le diagnostic</a>
</p>
</x-emails.partials.layout>
