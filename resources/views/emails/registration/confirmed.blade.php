<x-mail::message>
# Confirmation de votre Enregistrement

Bonjour **{{ $registration->client->first_name }} {{ $registration->client->last_name }}**,

Nous avons le plaisir de vous confirmer votre enregistrement à l'hôtel **{{ $registration->stay->hotel->name }}**.

**Détails de votre séjour :**
- **Date d'arrivée :** {{ \Carbon\Carbon::parse($registration->stay->check_in_date)->format('d/m/Y') }}
- **Date de départ :** {{ \Carbon\Carbon::parse($registration->stay->check_out_date)->format('d/m/Y') }}

Vous trouverez en pièce jointe un récapitulatif complet de votre enregistrement.

Nous vous remercions de votre confiance et nous réjouissons de vous accueillir.

Cordialement,  

L'équipe de {{ $registration->stay->hotel->name }}
</x-mail::message>
