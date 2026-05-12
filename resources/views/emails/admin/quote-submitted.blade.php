<x-emails.partials.layout headerColor="#0f172a" headerSubColor="#94a3b8">
<p>Une nouvelle demande de devis vient d'être soumise via le site.</p>
<div class="meta">
  <table>
    <tr><td>Référence</td><td><strong>{{ $quote->reference }}</strong></td></tr>
    <tr><td>Client</td><td>{{ $quote->client_name }}</td></tr>
    <tr><td>Email</td><td><a href="mailto:{{ $quote->client_email }}" style="color:#1a7a4a">{{ $quote->client_email }}</a></td></tr>
    @if($quote->client_company)<tr><td>Société</td><td>{{ $quote->client_company }}</td></tr>@endif
    <tr><td>Prestation</td><td>{{ match($quote->service_type) { 'strategic'=>'Accompagnement stratégique','audit'=>'Audit','qhse'=>'Conseil QHSE','training'=>'Formation',default=>'Autre' } }}</td></tr>
    @if($quote->sector)<tr><td>Secteur</td><td>{{ $quote->sector }}</td></tr>@endif
  </table>
</div>
@if($quote->description)
<div class="alert alert-info">
  <strong>Description :</strong><br>{{ $quote->description }}
</div>
@endif
<p style="margin-top:20px">
  <a href="{{ url('/admin/quotes') }}" class="btn">Gérer le devis</a>
</p>
</x-emails.partials.layout>
