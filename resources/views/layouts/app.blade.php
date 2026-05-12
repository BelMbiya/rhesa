<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rhesa App') }}</title>

        @php
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
        @endphp
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

            html, body, body * {
                font-family: 'Cooper Hewitt', Arial, sans-serif;
            }
        </style>
        <link rel = "icon" href="{{ asset('images/Rhesa_white.png') }}" type="image/x-icon">
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
