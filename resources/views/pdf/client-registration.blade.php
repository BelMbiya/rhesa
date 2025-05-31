<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrement Client</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 14px; 
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 60px;
            margin: 0 15px;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        .date {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
        }
        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }
        .full-width {
            grid-column: span 2;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-label {
            display: block;
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .input-field {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 14px;
        }
        .section-title {
            grid-column: span 2;
            margin-top: 20px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
            color: #333;
        }
        .images-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .image-box {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            width: 45%;
        }
        .image-box img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
        .image-box h3 {
            margin-top: 0;
            font-size: 16px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/Rhesa_black.png') }}" alt="Rhesa Black Logo">
        <img src="{{ public_path('images/logomin.png') }}" alt="Logo Min">
    </div>
    
    <div class="bg-gray-100 text-gray-800 print:bg-white print:text-black">
        <div class="text-center mb-12 mt-8 print:mt-4">
            <div class="flex justify-center items-center gap-8 flex-wrap mb-6">
                <img src="{{ asset('images/Rhesa_black.png') }}" alt="Logo Min" class="h-20 w-auto md:h-10">
                <img src="{{ asset('images/logomin.png') }}" alt="Logo Rhesa" class="h-20 w-auto md:h-10">
            </div>
            <h1 class="text-4xl font-bold text-gray-800">Fiches d'enregistrement</h1>
        </div>
    
        <div class="flex justify-center max-w-4xl mx-auto p-4 flex-col lg:flex-row gap-14">
            <section class="w-full space-y-6 print:w-full">
    
                <!-- Bloc Identification -->
                <div class="bg-white rounded-3xl shadow-md p-6 flex flex-col gap-6 transition hover:shadow-lg print:shadow-none print:border print:border-gray-300">
                    <h1 class="text-xl font-semibold">Identification</h1>
                    <p class="text-sm text-gray-600">Numéro d'identité : <b>{{ $data['identity_number'] ?? '' }}</b></p>
    
                    <div class="flex flex-col sm:flex-row justify-start items-start gap-8">
                        @php
                            $imageClasses = 'w-40 sm:w-48 md:w-56 h-auto mx-auto rounded shadow-sm border border-gray-200';
                        @endphp
    
                        <div class="text-center">
                            <h4 class="text-md font-medium mb-2">Pièce d'identité</h4>
                            <img src="{{ asset($data['identity_image']) }}" alt="Image d'identité" class="{{ $imageClasses }}">
                        </div>
    
                        <div class="text-center">
                            <h4 class="text-md font-medium mb-2">Selfie</h4>
                            <img src="{{ asset($data['selfi']) }}" alt="Selfie" class="{{ $imageClasses }}">
                        </div>
                    </div>
    
                    <p class="text-sm text-gray-600">Moyen d'enregistrement : <b>{{ $data['origin'] ?? '' }}</b></p>
                </div>
    
                <!-- Bloc Information -->
                <div class="bg-white rounded-3xl shadow-md p-6 flex flex-col gap-2 transition hover:shadow-lg print:shadow-none print:border print:border-gray-300">
                    <h1 class="text-xl font-semibold mb-2">Information</h1>
                    <p class="text-sm text-gray-600">Nom : <b>{{ $data['First_name'] ?? '' }}</b></p>
                    <p class="text-sm text-gray-600">Postnom : <b>{{ $data['Last_name'] ?? '' }}</b></p>
                    <p class="text-sm text-gray-600">Date de naissance : <b>{{ $data['date_naissance'] ?? '' }}</b></p>
                    <p class="text-sm text-gray-600">Lieu de naissance : <b>{{ $data['lieu_naissance'] ?? '' }}</b></p>
                    <p class="text-sm text-gray-600">Nationalité : <b>{{ $data['nationalite'] ?? '' }}</b></p>
                    <p class="text-sm text-gray-600">Adresse : <b>{{ $data['adresse'] ?? '' }}</b></p>
                    <p class="text-sm text-gray-600">Téléphone : <b>{{ $data['telephone'] ?? '' }}</b></p>
                    <p class="text-sm text-gray-600">E-mail : <b>{{ $data['email'] ?? '' }}</b></p>
                    <p class="text-sm text-gray-600">Profession : <b>{{ $data['profession'] ?? '' }}</b></p>
                    <p class="text-sm text-gray-600">Nom du père : <b>{{ $data['father_name'] ?? '' }}</b></p>
                    <p class="text-sm text-gray-600">Nom de la mère : <b>{{ $data['mother_name'] ?? '' }}</b></p>
                    <p class="text-sm text-gray-600">Enfants de moins de 15 ans : <b>{{ $data['children_under_15'] ?? '' }}</b></p>
                </div>
    
            </section>
        </div>
    </div>    
</body>
</html>
