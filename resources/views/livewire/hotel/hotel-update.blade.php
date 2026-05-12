<div class="max-w-2xl mx-auto mt-10 p-8 bg-white shadow-md rounded">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Modifier un hôtel</h2>

    {{-- Formulaire d'édition --}}
    <div class="mt-4">
        <x-input label="Nom de l'hôtel" wire:model="name" placeholder="Ex: Hôtel Bella Vista"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500"/>
    </div>

    <div class="mt-4">
        <x-input label="Adresse" wire:model="address" placeholder="Ex: 123 Avenue du Fleuve, Gombe"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500"/>
    </div>

    <div class="mt-4">
        <x-input label="Téléphone" wire:model="phone" placeholder="Ex: +243 89 000 0000"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500"/>
    </div>

    <div class="mt-4">
        <x-input label="Email" type="email" wire:model.defer="email" placeholder="Ex: exemple@exemple.com"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500"/>
    </div>

    <div class="mt-4">
        <x-input label="Nombre de chambres" type="number" wire:model="rooms_number" min="1"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500"/>
    </div>

    <div class="mt-4">
        <x-select label="Ville" wire:model.defer="city_id"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500">
            <option value="">Sélectionner une ville...</option>
            @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </x-select>
    </div>

    <div class="mt-4">
        <x-select label="Statut de l'hôtel" placeholder="Choisissez un statut" wire:model="status"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500">
            <x-select.option label="Choisissez un statut" />
            <x-select.option value="actif" label="Actif" />
            <x-select.option value="inactif" label="Inactif" />
            <x-select.option value="en_attente" label="En attente" />
            <x-select.option value="suspendu" label="Suspendu" />
            <x-select.option value="fermé_definitivement" label="Fermé définitivement" />
            <x-select.option value="en_maintenance" label="En maintenance" />
            <x-select.option value="archive" label="Archivé" />
            <x-select.option value="en_construction" label="En construction" />
            <x-select.option value="refusé" label="Refusé" />
            <x-select.option value="en_test" label="En test" />
        </x-select>
    </div>

    <div class="mt-4">
        <x-input label="Nom du manager" wire:model="manager" placeholder="Ex: Jean Ilunga"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500"/>
    </div>

    <div class="mt-4">
        <x-input label="Position géographique" wire:model="geo_position" placeholder="Ex: -4.325, 15.322"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500"/>
    </div>

    <div class="mt-6 w-[95%] mx-auto flex justify-between items-center">
    
        <a href="{{ route('hotels') }}"
            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded text-center shadow">
            Annuler et retourner
        </a>
    
        <x-primary-button wire:click="update"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded text-center">
            {{ __('Mettre à jour') }}
        </x-primary-button>
    
    </div>
    
</div>
