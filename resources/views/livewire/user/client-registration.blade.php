@php
    $isPdfMode = isset($isPdf) && $isPdf;
    $fontDir = public_path('fonts');
    $fontFiles = [];
    if (is_dir($fontDir)) {
        foreach (scandir($fontDir) as $file) {
            if (preg_match('/\.(ttf|otf|woff|woff2)$/i', $file)) {
                $fontFiles[] = $file;
            }
        }
    }
    $pickFont = function (array $files, array $keywords) {
        foreach ($files as $file) {
            $normalized = strtolower(preg_replace('/[^a-z0-9]/', '', $file));
            $matched = true;
            foreach ($keywords as $keyword) {
                if (strpos($normalized, strtolower($keyword)) === false) {
                    $matched = false;
                    break;
                }
            }
            if ($matched) {
                return $file;
            }
        }
        return null;
    };
    $regularFont = $pickFont($fontFiles, ['cooper', 'hewitt', 'book'])
        ?? $pickFont($fontFiles, ['cooper', 'hewitt', 'regular'])
        ?? $pickFont($fontFiles, ['cooper', 'hewitt', 'medium'])
        ?? $pickFont($fontFiles, ['cooper', 'hewitt']);
    $mediumFont = $pickFont($fontFiles, ['cooper', 'hewitt', 'medium']) ?? $regularFont;
    $boldFont = $pickFont($fontFiles, ['cooper', 'hewitt', 'bold']) ?? $regularFont;
    $heavyFont = $pickFont($fontFiles, ['cooper', 'hewitt', 'heavy']) ?? $boldFont;

    $resolveStaticImage = function (string $name) use ($isPdfMode) {
        return $isPdfMode ? public_path('images/' . $name) : asset('images/' . $name);
    };

    $resolveDynamicImage = function (?string $value, string $type) use ($isPdfMode) {
        if (empty($value)) {
            return '';
        }

        $clean = str_replace('\\', '/', trim($value, '/'));

        if (str_starts_with($clean, 'http://') || str_starts_with($clean, 'https://')) {
            return $clean;
        }

        if (str_starts_with($clean, 'storage/')) {
            $relative = preg_replace('/^storage\//', '', $clean);
            return $isPdfMode ? public_path('storage/' . $relative) : asset('storage/' . $relative);
        }

        if (str_starts_with($clean, 'images/')) {
            return $isPdfMode ? public_path('storage/' . $clean) : asset('storage/' . $clean);
        }

        return $isPdfMode
            ? public_path('storage/images/' . $type . '/' . $clean)
            : asset('storage/images/' . $type . '/' . $clean);
    };

    $logoRhesa = $resolveStaticImage('Rhesa_black.png');
    $logoMinistere = $resolveStaticImage('logomin.png');
    $identityImage = $resolveDynamicImage($client->identity_image ?? null, 'identity');
    $selfiImage = $resolveDynamicImage($client->selfi ?? null, 'selfie');
    $fontClass = $isPdfMode ? 'pdf-font' : 'web-font';
    $fullName = trim(($client->first_name ?? '') . ' ' . ($client->last_name ?? ''));
    $documentDate = trim(($reg_date ?? '') . ' ' . ($reg_time ?? ''));
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche d'enregistrement</title>
    <style>
        @php
            $fontFormat = function ($file) {
                $ext = strtolower(pathinfo((string) $file, PATHINFO_EXTENSION));
                return match ($ext) {
                    'otf' => 'opentype',
                    'woff' => 'woff',
                    'woff2' => 'woff2',
                    default => 'truetype',
                };
            };
        @endphp
        @if($regularFont)
        @font-face {
            font-family: 'Cooper Hewitt';
            src: url('{{ asset('fonts/' . $regularFont) }}') format('{{ $fontFormat($regularFont) }}');
            font-style: normal;
            font-weight: 400;
            font-display: swap;
        }
        @endif
        @if($mediumFont)
        @font-face {
            font-family: 'Cooper Hewitt';
            src: url('{{ asset('fonts/' . $mediumFont) }}') format('{{ $fontFormat($mediumFont) }}');
            font-style: normal;
            font-weight: 500;
            font-display: swap;
        }
        @endif
        @if($boldFont)
        @font-face {
            font-family: 'Cooper Hewitt';
            src: url('{{ asset('fonts/' . $boldFont) }}') format('{{ $fontFormat($boldFont) }}');
            font-style: normal;
            font-weight: 700;
            font-display: swap;
        }
        @endif
        @if($heavyFont)
        @font-face {
            font-family: 'Cooper Hewitt';
            src: url('{{ asset('fonts/' . $heavyFont) }}') format('{{ $fontFormat($heavyFont) }}');
            font-style: normal;
            font-weight: 800;
            font-display: swap;
        }
        @endif

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Cooper Hewitt', Arial, sans-serif;
            margin: 0;
            padding: 24px 14px;
            background: #f3f4f6;
            color: #1f2937;
        }

        .page {
            background: #ffffff;
            max-width: 980px;
            margin: auto;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            overflow: hidden;
        }

        .text-center {
            text-align: center;
        }

        .header-bar {
            background: #083f8c;
            color: #ffffff;
            padding: 14px 18px;
        }
        .logo-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin-bottom: 8px;
        }
        .logo-row img {
            height: 42px;
            width: auto;
        }
        .header-title {
            text-align: center;
        }
        .header-title h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            font-family: 'Cooper Hewitt', Arial, sans-serif !important;
        }
        .header-title p {
            margin: 4px 0 0;
            font-size: 13px;
            font-family: 'Cooper Hewitt', Arial, sans-serif !important;
        }

        .logo-wrap,
        .doc-meta,
        .main-grid,
        .data-table,
        .status-table,
        .images-table,
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .logo-wrap td {
            vertical-align: middle;
        }

        .logo-left img,
        .logo-right img {
            height: 46px;
            width: auto;
        }

        .logo-center {
            text-align: center;
        }

        .logo-center h1 {
            margin: 0;
            font-size: 20px;
        }

        .logo-center p {
            margin: 4px 0 0;
            font-size: 13px;
            opacity: 0.9;
        }

        .doc-meta {
            margin-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 12px;
        }

        .doc-meta td {
            padding-top: 8px;
        }

        .doc-meta .meta-right {
            text-align: right;
        }

        .content {
            padding: 18px;
        }

        .main-grid {
            border-collapse: separate;
            border-spacing: 16px;
        }

        .main-grid td {
            vertical-align: top;
        }

        .card {
            border: 1px solid #dbe2ea;
            border-radius: 10px;
            background: #ffffff;
            overflow: hidden;
        }

        .card-title {
            margin: 0;
            padding: 10px 14px;
            background: #e6f0ff;
            border-bottom: 1px solid #d3dfea;
            color: #0d3b82;
            font-size: 15px;
            font-weight: bold;
        }

        .card-body {
            padding: 12px 14px 14px;
        }

        .nif-box {
            border: 1px dashed #9fbbe7;
            background: #f5f9ff;
            text-align: center;
            padding: 14px 12px;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .nif-label {
            display: block;
            font-size: 12px;
            color: #4b5563;
            margin-bottom: 6px;
        }

        .nif-value {
            font-size: 26px;
            letter-spacing: 1px;
            color: #083f8c;
            font-weight: 700;
            margin: 0;
        }

        .nif-note {
            margin: 6px 0 0;
            font-size: 11px;
            color: #6b7280;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #e5e7eb;
            padding: 8px 10px;
            text-align: left;
            font-family: 'Cooper Hewitt', Arial, sans-serif !important;
        }

        .data-table th {
            width: 42%;
            background: #f8fafc;
            color: #374151;
            font-weight: 600;
        }

        .status-table td {
            border-bottom: 1px solid #e5e7eb;
            padding: 8px 4px;
            font-size: 13px;
            font-family: 'Cooper Hewitt', Arial, sans-serif !important;
        }

        .status-table td:last-child {
            text-align: right;
            font-weight: 600;
            color: #0b4a9e;
        }

        .images-table {
            border-collapse: separate;
            border-spacing: 8px;
        }

        .images-table td {
            width: 50%;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px;
            text-align: center;
            background: #fafafa;
        }

        .image-title {
            margin: 0 0 6px;
            font-size: 12px;
            color: #374151;
            font-weight: 600;
        }

        img.id-image,
        img.selfie-image {
            max-width: 100%;
            max-height: 170px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            object-fit: cover;
        }

        .verify-code {
            margin: 0;
            font-size: 20px;
            letter-spacing: 6px;
            text-align: center;
            font-weight: 700;
            color: #0d3b82;
        }

        .features {
            margin: 0;
            padding-left: 18px;
            font-size: 13px;
            line-height: 1.55;
            color: #374151;
        }

        .features li {
            margin-bottom: 8px;
        }

        .footer {
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
            padding: 10px 16px;
            font-size: 12px;
            color: #4b5563;
        }

        .btn:hover {
            background-color: #0a4fa9;
        }

        .btn {
            display: inline-block;
            margin-top: 4px;
            padding: 11px 22px;
            background-color: #083f8c;
            color: #ffffff;
            border: 1px solid #083f8c;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: 0.2s ease;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
                background: #ffffff;
            }

            .logo-wrap,
            .logo-wrap tbody,
            .logo-wrap tr,
            .logo-wrap td,
            .main-grid,
            .main-grid tbody,
            .main-grid tr,
            .main-grid td,
            .images-table,
            .images-table tbody,
            .images-table tr,
            .images-table td,
            .footer-table,
            .footer-table tbody,
            .footer-table tr,
            .footer-table td {
                display: block;
                width: 100% !important;
            }

            .logo-center,
            .logo-left,
            .logo-right,
            .doc-meta td,
            .meta-right {
                text-align: center !important;
            }
            .logo-row {
                justify-content: center;
                gap: 10px;
                margin-bottom: 10px;
            }
            .logo-row img {
                height: 36px;
            }
            .header-title h1 {
                font-size: 17px;
            }

            .main-grid {
                border-spacing: 0;
            }

            .main-grid td {
                padding-bottom: 14px;
            }

            .nif-value {
                font-size: 21px;
                letter-spacing: 0.5px;
            }
        }
    </style>
</head>
<body>

<div class="{{ $fontClass }} page">
    <div class="header-bar">
        <div class="logo-row">
            <img src="{{ $logoRhesa }}" alt="Logo Rhesa">
            <img src="{{ $logoMinistere }}" alt="Logo Ministère">
        </div>
        <div class="header-title">
            <h1>FICHE D'ENREGISTREMENT CLIENT</h1>
            <p>{{ $hotel_name ?? 'Hôtel' }} - {{ $documentDate }}</p>
        </div>
        <table class="doc-meta">
            <tr>
                <td>Numéro d'identité: <strong>{{ $client->identity_number ?? '' }}</strong></td>
                <td class="meta-right">Origine: <strong>{{ $client->origin ?? '' }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="content">
        <table class="main-grid">
            <tr>
                <td style="width:68%;">
                    <div class="card">
                        <h2 class="card-title">INFORMATIONS DU CLIENT</h2>
                        <div class="card-body">
                            <div class="nif-box">
                                <span class="nif-label">Client enregistré</span>
                                <p class="nif-value">{{ $fullName }}</p>
                                <p class="nif-note">Dossier généré le {{ $documentDate }}</p>
                            </div>

                            <table class="data-table">
                                <tr><th>Nom</th><td>{{ $client->first_name }}</td></tr>
                                <tr><th>Postnom</th><td>{{ $client->last_name }}</td></tr>
                                <tr><th>Date de naissance</th><td>{{ $client->birth_date }}</td></tr>
                                <tr><th>Lieu de naissance</th><td>{{ $client->birth_place }}</td></tr>
                                <tr><th>Nationalité</th><td>{{ $client->nationality }}</td></tr>
                                <tr><th>Adresse</th><td>{{ $client->permanent_address }}</td></tr>
                                <tr><th>Téléphone</th><td>{{ $client->phone }}</td></tr>
                                <tr><th>Email</th><td>{{ $client->email }}</td></tr>
                                <tr><th>Profession</th><td>{{ $client->profession }}</td></tr>
                                <tr><th>Nom du père</th><td>{{ $client->father_name }}</td></tr>
                                <tr><th>Nom de la mère</th><td>{{ $client->mother_name }}</td></tr>
                                <tr><th>Enfant(s) de moins de 15 ans</th><td>{{ $client->children_under_15 }}</td></tr>
                            </table>
                        </div>
                    </div>
                </td>

                <td style="width:32%;">
                    <div class="card">
                        <h2 class="card-title">ÉTAT DU DOSSIER</h2>
                        <div class="card-body">
                            <table class="status-table">
                                <tr><td>Hôtel</td><td>{{ $hotel_name ?? '' }}</td></tr>
                                <tr><td>Date d'enregistrement</td><td>{{ $reg_date ?? '' }}</td></tr>
                                <tr><td>Heure d'enregistrement</td><td>{{ $reg_time ?? '' }}</td></tr>
                                <tr><td>Statut</td><td>Validé</td></tr>
                            </table>
                            <p class="verify-code">{{ $client->identity_number ?? '' }}</p>
                            <p style="margin:6px 0 0; text-align:center; font-size:12px; color:#6b7280;">Code dossier</p>
                        </div>
                    </div>

                    <div style="height:12px;"></div>

                    <div class="card">
                        <h2 class="card-title">IDENTITÉ VISUELLE</h2>
                        <div class="card-body">
                            <table class="images-table">
                                <tr>
                                    <td>
                                        <p class="image-title">Pièce d'identité</p>
                                        <img src="{{ $identityImage }}" alt="Pièce d'identité" class="id-image">
                                    </td>
                                    <td>
                                        <p class="image-title">Selfie</p>
                                        <img src="{{ $selfiImage }}" alt="Selfie" class="selfie-image">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="card">
                        <h2 class="card-title">SÉCURITÉ ET VÉRIFICATION</h2>
                        <div class="card-body">
                            <ul class="features">
                                <li><strong>Contrôle visuel:</strong> vérification directe des pièces d'identité et du selfie.</li>
                                <li><strong>Traçabilité:</strong> chaque fiche conserve la date, l'heure et l'hôtel d'enregistrement.</li>
                                <li><strong>Archivage:</strong> les informations restent exploitables pour audit et contrôle interne.</li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        @if(empty($isPdf))
            <div class="text-center">
                <a class="btn" href="{{ route('client-registration.download', $client->id) }}" target="_blank">Télécharger le PDF</a>
            </div>
        @endif
    </div>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>Document de suivi client</td>
                <td class="text-center">Page 1 sur 1</td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>

