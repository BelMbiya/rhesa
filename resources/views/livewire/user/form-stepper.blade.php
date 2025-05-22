<!-- filepath: d:\Dev\rhesa\resources\views\livewire\user\form-stepper.blade.php -->

<div class="max-w-2xl mx-auto mt-10 p-8 bg-white shadow-md rounded">
    <div class="flex justify-center items-center mb-4 space-x-6">
        <img src="{{ asset('images/Rhesa_black.png') }}" alt="Rhesa Black Logo" class="h-14 w-auto object-contain" />
        <img src="{{ asset('images/logomin.png') }}" alt="Logo Min" class="h-12 w-auto object-contain" />
    </div>
    <h2 class="text-2xl font-bold text-center mb-2">Enregistrement</h2>
    <p class="text-center text-gray-600 mb-8">Remplissez le formulaire, puis profitez de votre sejour !</p>

    <!-- Stepper UI avec ligne dynamique -->
    <div class="relative flex justify-between items-center mb-10">
        @for ($i = 1; $i <= 3; $i++)
            <div class="flex-1 text-center relative z-10">
                <div class="flex items-center justify-center">
                    <div class="
                        w-8 h-8 rounded-full text-white text-sm font-bold flex items-center justify-center
                        transition
                        {{ $currentStep == $i 
                            ? 'bg-blue-600 shadow-lg ring-2 ring-blue-300' 
                            : ($currentStep > $i 
                                ? 'bg-green-500' 
                                : 'bg-gray-200 text-gray-600 border-2') 
                        }}
                    ">
                        {{ $i }}
                    </div>
                </div>
                <div class="mt-2 text-sm {{ $currentStep == $i ? 'font-semibold' : 'text-gray-500' }}">
                    @switch($i)
                        @case(1) Information personnelle @break
                        @case(2) Séjour @break
                        @case(3) Information supplémentaire @break
                    @endswitch
                </div>
            </div>

            @if ($i < 3)
                <div class="absolute top-4 left-[calc(16.66%+1rem)] right-[calc(16.66%+1rem)] h-1 bg-gray-300 z-0">
                    <div class="h-1 transition-all duration-500 {{ $currentStep > $i ? 'bg-green-500 w-full' : 'bg-blue-600 w-0' }}"></div>
                </div>
            @endif
        @endfor
    </div>

    <!-- Step Content -->
    @if ($currentStep === 1)
        <div>
            <x-input label="Nom" wire:model="name" />
            <x-input label="Postnom" wire:model="postnom" />
            <x-input label="Prenom" wire:model="prenom" />
            <x-select label="Genre" wire:model="genre">
                <option value="">Sélectionner...</option>
                <option value="Masculin">Masculin</option>
                <option value="Feminin">Feminin</option>
            </x-select>
            <x-input label="Date de naissance" wire:model="date_naissance" type="date" />
            <x-input label="Lieu de naissance" wire:model="lieu_naissance" />
            <x-select label="Nationalité" wire:model="nationalite">
                <option value="">Sélectionner...</option>
                <option value="Congolaise">Congolaise</option>
                <option value="Autre">Autre</option>
            </x-select>
            <x-input label="Adresse" wire:model="adresse" />
            <x-input label="Téléphone" wire:model="telephone" />
            <x-input label="Email" wire:model="email" type="email" />
            <x-select label="Etat civil" wire:model="etat_civil">
                <option value="">Sélectionner...</option>
                <option value="Célibataire">Célibataire</option>
                <option value="Marié(e)">Marié(e)</option>
                <option value="Divorcé(e)">Divorcé(e)</option>
                <option value="Veuf(ve)">Veuf(ve)</option>
                <option value="Séparé(e)">Séparé(e)</option>
                <option value="Pacsé(e)">Pacsé(e)</option>
                <option value="Union libre">Union libre</option>
            </x-select>
            <x-input label="Profession" wire:model="profession" />
            <x-input label="Nom du père" wire:model="father_name" />
            <x-input label="Nom de la mère" wire:model="mother_name"/>
            <x-input label="Enfants de moins de 15ans" wire:model="children_under_15" />

            {{-- Ajout du selfi et identite_image côte à côte --}}
            <div class="flex flex-wrap justify-between gap-4 mt-6 mb-6">
            {{-- Selfi --}}
            <div class="w-full md:w-[48%] p-6 bg-white rounded-xl shadow-md border border-blue-200">
                <div class="flex flex-col items-center justify-center border-2 border-dashed border-blue-400 rounded-md h-64 cursor-pointer"
                    wire:click="$refs.selfiInput.click()" @click="$refs.selfiInput.click()">
            @if (!$selfi)
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span class="text-gray-500">Prendre une photo</span>
            @else
                <img src="{{ $selfi->temporaryUrl() }}" alt="Preview" class="object-cover h-full w-full rounded-md" />
            @endif
        </div>

        @if ($selfi)
            <div class="flex items-center justify-between mt-4 px-4 py-2 bg-gray-100 rounded-md">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-4.414-4.414A1 1 0 0012.586 2H4z" />
                    </svg>
                    <span class="text-sm text-gray-600">{{ $selfi->getClientOriginalName() }}</span>
                </div>
                <button wire:click="removeSelfi" class="text-red-500 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 8a1 1 0 011 1v6a1 1 0 102 0V9a1 1 0 112 0v6a1 1 0 102 0V9a1 1 0 012 0v6a3 3 0 01-6 0V9a1 1 0 112 0v6a1 1 0 002 0V9a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        @endif

        <input type="file" wire:model="selfi" x-ref="selfiInput" class="hidden" accept="image/*" key="{{ now() }}" />
        @error('selfi') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
    </div>

    {{-- Carte d'identité --}}
    <div class="w-full md:w-[48%] p-6 bg-white rounded-xl shadow-md border border-blue-200">
        <div
            class="flex flex-col items-center justify-center border-2 border-dashed border-blue-400 rounded-md h-64 cursor-pointer"
            wire:click="$refs.identity_imageInput.click()" @click="$refs.identity_imageInput.click()"
        >
            @if (!$identity_image)
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span class="text-gray-500">Carte d'identité</span>
            @else
                <img src="{{ $identity_image->temporaryUrl() }}" alt="Preview" class="object-cover h-full w-full rounded-md" />
            @endif
        </div>

        @if ($identity_image)
            <div class="flex items-center justify-between mt-4 px-4 py-2 bg-gray-100 rounded-md">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V7.414a1 1 0 00-.293-.707l-4.414-4.414A1 1 0 0012.586 2H4z" />
                    </svg>
                    <span class="text-sm text-gray-600">{{ $identity_image->getClientOriginalName() }}</span>
                </div>
                <button wire:click="removeIdentity_image" class="text-red-500 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 8a1 1 0 011 1v6a1 1 0 102 0V9a1 1 0 112 0v6a1 1 0 102 0V9a1 1 0 012 0v6a3 3 0 01-6 0V9a1 1 0 112 0v6a1 1 0 002 0V9a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
                    @endif

                    <input type="file" wire:model="identity_image" x-ref="identity_imageInput" class="hidden" accept="image/*" key="{{ now() }}" />
                    @error('identity_image') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
                </div>
            </div>


            <x-select label="Origine de l'enregistrement" wire:model="origin">
                <option value="">Sélectionner...</option>
                <option value="Manuel">Manuel</option>
                <option value="Autre">Autre</option>
            </x-select>
        </div>
    @elseif ($currentStep === 2)
        <div class="min-h-[550px] md:min-h-[450px]">
            {{-- <x-input label="Client" wire:model="client_id" /> --}}
            <x-input label="Date d'arrivée" wire:model="date_arrivee" type="date" />
            <x-input label="Date de départ" wire:model="date_depart" type="date" />
            <x-input label="Motif" wire:model="motif" />
            <x-input label="Lieu de séjour" wire:model="lieu_sejour" />
            <x-input label="Type de chambre" wire:model="type_chambre" />
            <x-input label="Nombre de personnes" wire:model="nombre_personnes" type="number" />
        </div>
    @elseif ($currentStep === 3)
        <div>
            <x-input label="Date d'enregistrement" wire:model="date_enregistrement" type="date" />
            <x-input label="Numéro d'enregistrement" wire:model="numero_enregistrement" />
            <x-input label="Observations" wire:model="observations" />
        </div>
    @endif

    <!-- Navigation Buttons -->
    <div class="mt-6 flex justify-between">
        @if ($currentStep > 1)
            <button wire:click="decreaseStep" class="px-4 py-2 bg-gray-300 rounded">Précédent</button>
        @endif

        @if ($currentStep < 3)
            <button wire:click="increaseStep" class="px-4 py-2 bg-blue-600 text-white rounded">Suivant</button>
        @else
            <button wire:click="submit" class="px-4 py-2 bg-green-600 text-white rounded">Soumettre</button>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="text-green-600 mt-4 text-center">{{ session('message') }}</div>
    @endif
</div>
