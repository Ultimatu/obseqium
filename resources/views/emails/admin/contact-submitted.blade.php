<x-emails.partials.layout headerColor="#0f172a" headerSubColor="#94a3b8">
<p>Un nouveau message de contact vient d'être soumis.</p>
<div class="meta">
  <table>
    <tr><td>Nom</td><td>{{ $contact->name }}</td></tr>
    <tr><td>Email</td><td><a href="mailto:{{ $contact->email }}" style="color:#1a7a4a">{{ $contact->email }}</a></td></tr>
    @if($contact->phone)<tr><td>Téléphone</td><td>{{ $contact->phone }}</td></tr>@endif
    @if($contact->company)<tr><td>Société</td><td>{{ $contact->company }}</td></tr>@endif
    <tr><td>Sujet</td><td>{{ $contact->subject }}</td></tr>
  </table>
</div>
<div class="alert alert-info">
  <strong>Message :</strong><br>
  {{ $contact->message }}
</div>
<p style="margin-top:20px">
  <a href="{{ url('/admin/contacts') }}" class="btn">Voir dans l'admin</a>
</p>
</x-emails.partials.layout>
