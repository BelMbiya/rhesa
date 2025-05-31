<!-- filepath: d:\Dev\rhesa\resources\views\components\layouts\app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Rhesa | Enregistrement' }}</title>
    <link rel = "icon" href="{{ asset('images/Rhesa_white.png') }}" type="image/x-icon">

    <!-- Tailwind CSS via Vite (modifie selon ta config si besoin) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @livewireStyles
    @fluxAppearance
</head>
<body class="bg-gray-100 font-sans antialiased">
    <!-- Exemple d'affichage des images dans le layout -->
    {{ $slot }}
    @livewireScripts
    @fluxScripts
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('triggerFileInput', () => {
                document.querySelector('[x-ref="fileInput"]').click();
            });
        });
    </script>
</body>
</html>
