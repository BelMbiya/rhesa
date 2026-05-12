<div class="max-w-2xl mx-auto mt-10 p-8 bg-white shadow-md rounded">

    <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Créer un Utilisateur</h2>

    @if(session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mt-4">
        <x-input label="Nom Complet" wire:model.defer="name" placeholder="Ex: John Doe"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500" />
        @error('name') <p class="text-red-500 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
    </div>

    <div class="mt-4">
        <x-input label="Adresse Email" type="email" wire:model.defer="email" placeholder="Ex: john.doe@example.com"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500" />
        @error('email') <p class="text-red-500 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
    </div>

    <div class="mt-4">
        <x-input label="Mot de Passe" type="password" wire:model.defer="password" placeholder="Minimum 8 caractères"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500" />
        @error('password') <p class="text-red-500 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
    </div>

    <div class="mt-4">
        <x-input label="Confirmer Mot de Passe" type="password" wire:model.defer="password_confirmation"
            placeholder="Répétez votre mot de passe"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500" />
        @error('password_confirmation') <p class="text-red-500 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
    </div>

    <div class="mt-4">
        <x-select label="Statut" placeholder="Choisissez un statut" wire:model.defer="status"
            class="w-[95%] mx-auto bg-white text-gray-900 border-gray-300 focus:ring-blue-500">
            <x-select.option value="actif" label="Actif" />
            <x-select.option value="inactif" label="Inactif" />
            <x-select.option value="suspendu" label="Suspendu" />
        </x-select>
        @error('status') <p class="text-red-500 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
    </div>

    {{-- Champ Hôtel avec recherche --}}
    <div class="mt-4 w-[95%] mx-auto relative" x-data="{
    open: false,
    search: '',
    selected: '',
    selectedId: @entangle('hotel_id'),
    hotels: {{ $hotels->map(fn($h) => ['id' => $h->id, 'name' => $h->name])->toJson() }},
    get filtered() {
        if (this.search === '') return this.hotels;
        return this.hotels.filter(h =>
            h.name.toLowerCase().includes(this.search.toLowerCase())
        );
    },
    select(hotel) {
        this.selected = hotel.name;
        this.selectedId = hotel.id;
        this.search = hotel.name;
        this.open = false;
    },
    clear() {
        this.selected = '';
        this.selectedId = '';
        this.search = '';
    }
}" x-init="
    if (selectedId) {
        let found = hotels.find(h => h.id == selectedId);
        if (found) { search = found.name; selected = found.name; }
    }
">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Hôtel Associé <span class="text-gray-400 text-xs">(Optionnel)</span>
        </label>

        <div class="relative">
            <input type="text" x-model="search" @focus="open = true" @click.outside="open = false" @input="open = true"
                placeholder="Rechercher un hôtel..."
                class="w-full bg-white text-gray-900 border border-gray-300 rounded px-3 py-2 pr-8 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" />

            {{-- Bouton clear --}}
            <button type="button" x-show="search !== ''" @click="clear()"
                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        {{-- Dropdown --}}
        <div x-show="open && filtered.length > 0" x-transition
            class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded shadow-lg max-h-52 overflow-y-auto">

            {{-- Option "Aucun hôtel" --}}
            <div @click="clear(); open = false"
                class="px-3 py-2 text-sm text-gray-400 italic hover:bg-gray-50 cursor-pointer border-b border-gray-100">
                Aucun hôtel
            </div>

            <template x-for="hotel in filtered" :key="hotel.id">
                <div @click="select(hotel)"
                    :class="selectedId == hotel.id ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-900 hover:bg-gray-50'"
                    class="px-3 py-2 text-sm cursor-pointer flex items-center justify-between">
                    <span x-text="hotel.name"></span>
                    <svg x-show="selectedId == hotel.id" class="h-4 w-4 text-blue-500" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </template>
        </div>

        {{-- Aucun résultat --}}
        <div x-show="open && filtered.length === 0"
            class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded shadow-lg px-3 py-2 text-sm text-gray-400 italic">
            Aucun hôtel trouvé
        </div>

        @error('hotel_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mt-6">
        <button wire:click="createUser"
            class="w-[95%] mx-auto flex justify-center bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded">
            Créer l'utilisateur
        </button>
    </div>

</div>