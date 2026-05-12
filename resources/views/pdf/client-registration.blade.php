{{-- resources/views/pdf/client-registration.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Certificat client</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #1f2937;
            background: #fff;
            padding: 16px;
        }
        table { width: 100%; border-collapse: collapse; }
        .header { 
        background: #083f8c; 
        color: #ffffff; 
        padding: 20px 25px; 
        margin-bottom: 20px; 
        text-align: center;
        border-radius: 4px; /* Optionnel : léger arrondi pour le style */
    }
    
    .header h1 { 
        font-size: 18px; 
        margin: 0 0 6px 0; 
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: bold;
    }
    
    .header p { 
        font-size: 12px; 
        margin: 0 0 15px 0; 
        opacity: 0.9;
        font-style: italic;
    }

    .logo-container {
        display: block;
        margin-top: 10px;
    }

    .logo-container img {
        height: 35px; /* Taille réduite pour les logos */
        margin: 0 12px;
        display: inline-block;
        vertical-align: middle;
        /* Si vos logos ont un fond blanc, ce filtre peut aider à les rendre plus propres sur fond bleu */
        filter: brightness(0) invert(1); 
    }
        .meta { margin-bottom: 10px; }
        .meta td {
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            background: #f8fafc;
            font-size: 11px;
        }
        .section-title {
            background: #e6f0ff;
            color: #0d3b82;
            font-weight: bold;
            padding: 6px 8px;
            border: 1px solid #c3d5f0;
            font-size: 11px;
        }
        .box { border: 1px solid #dbe2ea; margin-bottom: 10px; }
        .box-body { padding: 8px; }
        .info-table th,
        .info-table td {
            border: 1px solid #e5e7eb;
            padding: 5px 7px;
            text-align: left;
        }
        .info-table th {
            width: 42%;
            background: #f8fafc;
            font-weight: 600;
        }
        .two-col { width: 100%; border-collapse: separate; border-spacing: 8px 0; }
        .two-col td { vertical-align: top; width: 50%; }
        .footer { margin-top: 10px; }
        .footer td {
            border: 1px solid #d1d5db;
            background: #f9fafb;
            padding: 6px 8px;
            font-size: 10px;
        }
        .code-box {
            text-align: center;
            border: 1px dashed #9fbbe7;
            background: #f5f9ff;
            padding: 10px;
            margin-top: 8px;
            border-radius: 4px;
        }
        .code-box .code {
            font-size: 18px;
            font-weight: bold;
            color: #083f8c;
            letter-spacing: 3px;
        }
        .code-box .label { font-size: 10px; color: #6b7280; margin-top: 4px; }
    </style>
</head>
<body>
@php
    $stay        = $client->stays()->latest()->first();
    $fullName    = trim(($client->first_name ?? '') . ' ' . ($client->last_name ?? ''));
    $documentId  = 'CERT-' . now()->format('Ymd') . '-' . ($client->identity_number ?? 'N/A');
    $docDate     = ($reg_date ?? '') . ' ' . ($reg_time ?? '');
@endphp

{{-- En-tête --}}
<div class="header">

    
    <div class="logo-container">
        {{-- Logos en taille réduite --}}
        @if(file_exists(storage_path('app/public/logo/Rhesawhite.png')))
            <img src="{{ storage_path('app/public/logo/Rhesawhite.png') }}" alt="Logo">
        @endif
        @if(file_exists(storage_path('app/public/logo/logo_min.png')))
            <img src="{{ storage_path('app/public/logo/logo_min.png') }}" alt="Logo">
        @endif
        
    </div>
    <h1>Fiche d'Enregistrement Client</h1>
    <p>{{ $hotel_name ?? 'Hôtel Non Défini' }} &mdash; {{ $docDate }}</p>
</div>

{{-- Méta --}}

{{-- Deux colonnes --}}
<table class="two-col">
    <tr>
        {{-- Colonne gauche : infos client --}}
        <td>
            <div class="box">
                <div class="section-title">INFORMATIONS DU CLIENT</div>
                <div class="box-body">
                    <table class="info-table">
                        <tr><th>Nom complet</th><td>{{ $fullName }}</td></tr>
                        <tr><th>N° identité</th><td>{{ $client->identity_number ?? '' }}</td></tr>
                        <tr><th>Date de naissance</th><td>{{ $client->birth_date ?? '' }}</td></tr>
                        <tr><th>Lieu de naissance</th><td>{{ $client->birth_place ?? '' }}</td></tr>
                        <tr><th>Nationalité</th><td>{{ $client->nationality ?? '' }}</td></tr>
                        <tr><th>Adresse</th><td>{{ $client->permanent_address ?? '' }}</td></tr>
                        <tr><th>Téléphone</th><td>{{ $client->phone ?? '' }}</td></tr>
                        <tr><th>Email</th><td>{{ $client->email ?? '' }}</td></tr>
                        <tr><th>Profession</th><td>{{ $client->profession ?? '' }}</td></tr>
                        <tr><th>Nom du père</th><td>{{ $client->father_name ?? '' }}</td></tr>
                        <tr><th>Nom de la mère</th><td>{{ $client->mother_name ?? '' }}</td></tr>
                        <tr><th>Enfants -15 ans</th><td>{{ $client->children_under_15 ?? '0' }}</td></tr>
                    </table>
                </div>
            </div>
        </td>

        {{-- Colonne droite : séjour + code --}}
        <td>
            <div class="box">
                <div class="section-title">DÉTAILS DU SÉJOUR</div>
                <div class="box-body">
                    <table class="info-table">
                        <tr><th>Hôtel</th><td>{{ $hotel_name ?? '' }}</td></tr>
                        <tr><th>Date enregistrement</th><td>{{ $reg_date ?? '' }}</td></tr>
                        <tr><th>Heure enregistrement</th><td>{{ $reg_time ?? '' }}</td></tr>
                        <tr><th>Chambre</th><td>{{ $stay?->room_number ?? '' }}</td></tr>
                        <tr><th>Motif</th><td>{{ $stay?->purpose ?? '' }}</td></tr>
                        <tr><th>Prochaine destination</th><td>{{ $stay?->next_destination ?? '' }}</td></tr>
                    </table>
                </div>
            </div>

            <div class="code-box">
                <div class="code">{{ $client->identity_number ?? '' }}</div>
                <div class="label">Code dossier</div>
            </div>

            <div class="box" style="margin-top:10px;">
                <div class="section-title">SÉCURITÉ ET VÉRIFICATION</div>
                <div class="box-body" style="font-size:10px; line-height:1.6;">
                    <p>&#10003; Contrôle visuel des pièces effectué à l'accueil.</p>
                    <p>&#10003; Traçabilité : date, heure et hôtel conservés.</p>
                    <p>&#10003; Archivage pour audit et contrôle interne.</p>
                </div>
            </div>
        </td>
    </tr>
</table>

{{-- Pied de page --}}

</body>
</html>