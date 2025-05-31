<div class="bg-gray-100 text-gray-800 print:bg-white print:text-black">
    <div class="text-center mb-12 mt-8 print:mt-4">
        <div class="flex justify-center items-center gap-8 flex-wrap mb-6">
            <img src="{{ asset('images/Rhesa_black.png') }}" alt="Logo Min" class="h-20 w-auto md:h-10 ">
            <img src="{{ asset('images/logomin.png') }}" alt="Logo Rhesa" class="h-20 w-auto md:h-10">
        </div>
        <h1 class="text-4xl font-bold text-gray-800">Fiches d'enregistrement</h1>
    </div>

    <div class="flex justify-center max-w-4xl mx-auto p-4 flex-col lg:flex-row gap-14">
        <section class="w-full space-y-6 print:w-full">

            <!-- Bloc Identification -->
            <div
                class="bg-white rounded-3xl shadow-md p-6 flex flex-col gap-6 transition hover:shadow-lg print:shadow-none print:border print:border-gray-300">
                <h1 class="text-xl font-semibold">Identification</h1>
                <p class="text-sm text-gray-600">Numéro d'identité : <b>{{ $client->identity_number }}</b></p>

                <!-- Images en flex responsive avec taille identique -->
                <div class="flex flex-col sm:flex-row justify-start items-start gap-8">
                    @php
                        $imageClasses = 'w-40 sm:w-48 md:w-56 h-auto mx-auto rounded shadow-sm border border-gray-200';
                    @endphp

                    <div class="text-center">
                        <h4 class="text-md font-medium mb-2">Pièce d'identité</h4>
                        <img src="{{ Storage::url($client->identity_image) }}" alt="Image d'identité"
                            class="{{ $imageClasses }}">
                    </div>

                    <div class="text-center">
                        <h4 class="text-md font-medium mb-2">Selfie</h4>
                        <img src="{{ Storage::url($client->selfi) }}" alt="Selfie" class="{{ $imageClasses }}">
                    </div>
                </div>

                <p class="text-sm text-gray-600">Moyen d'enregistrement : <b>{{ $client->origin }}</b></p>
            </div>


            <!-- Bloc Information -->
            <div
                class="bg-white rounded-3xl shadow-md p-6 flex flex-col gap-2 transition hover:shadow-lg print:shadow-none print:border print:border-gray-300">
                <h1 class="text-xl font-semibold mb-2">Information</h1>
                <p class="text-sm text-gray-600">Nom : <b>{{ $client->first_name }}</b></p>
                <p class="text-sm text-gray-600">Postom : <b>{{ $client->last_name }}</b></p>
                <p class="text-sm text-gray-600">Date de naissance : <b>{{ $client->birth_date }}</b></p>
                <p class="text-sm text-gray-600">Lieu de naissance : <b>{{ $client->birth_place }}</b></p>
                <p class="text-sm text-gray-600">Nationnalite : <b>{{ $client->nationality }}</b></p>
                <p class="text-sm text-gray-600">Adresse : <b>{{ $client->permanent_address }}</b></p>
                <p class="text-sm text-gray-600">Téléphone : <b>{{ $client->phone }}</b></p>
                <p class="text-sm text-gray-600">E-mail : <b>{{ $client->email }}</b></p>
                <p class="text-sm text-gray-600">Profession : <b>{{ $client->profession }}</b></p>
                <p class="text-sm text-gray-600">Nom du père : <b>{{ $client->father_name }}</b></p>
                <p class="text-sm text-gray-600">Nom de la mère : <b>{{ $client->mother_name }}</b></p>
                <p class="text-sm text-gray-600">Enfant de moins de 15 ans : <b>{{ $client->children_under_15 }}</b>
                </p>
            </div>
        </section>
    </div>
    <div class="flex justify-center mb-6">
        <button wire:click="exportToPdf" wire:loading.attr="disabled"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors disabled:opacity-50">
            <span wire:loading.remove wire:target="exportToPdf">Télécharger le PDF</span>
            <span wire:loading wire:target="exportToPdf" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Téléchargement...
            </span>
        </button>
    </div>    
</div>
