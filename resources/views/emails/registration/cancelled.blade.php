<x-mail::message>
# Information sur votre demande d'enregistrement

Bonjour **{{ $registration->client->first_name }} {{ $registration->client->last_name }}**,

Nous vous informons que votre demande d'enregistrement pour l'hôtel **{{ $registration->stay->hotel->name }}** n'a pas pu être validée pour le moment.

Pour plus d'informations, nous vous invitons à contacter directement l'établissement.

Nous vous remercions de votre compréhension.

Cordialement,  

L'équipe de {{ $registration->stay->hotel->name }}
</x-mail::message>
