<!-- filepath: d:\Dev\rhesa\resources\views\livewire\user\form-stepper.blade.php -->

<div class="max-w-2xl mx-auto mt-10 p-8 bg-white shadow-md rounded">
    <div class="flex justify-center items-center mb-4 space-x-6">
        <img src="{{ asset('images/Rhesa_black.png') }}" alt="Rhesa Black Logo" class="h-14 w-auto object-contain" />
        <img src="{{ asset('images/logomin.png') }}" alt="Logo Min" class="h-12 w-auto object-contain" />
    </div>
    <h2 class="text-2xl font-bold text-center mb-2">Enregistrement</h2>
    <p class="text-center text-gray-600 mb-8">Remplissez le formulaire, puis profitez de votre sejour !</p>

    <!-- Stepper UI avec barre de progression améliorée -->
    <div
        class="relative flex flex-col items-center justify-center mb-10 w-11/12 sm:w-full max-w-3xl mx-auto min-h-[120px]">
        <!-- Points d'étape avec barre de progression intégrée -->
        <div class="flex justify-center items-center w-full relative px-[5%] md:px-[18%]">
            <!-- Barre de progression en arrière-plan -->
            {{-- <div class="absolute top-4 left-[5%] right-[5%] md:left-[18%] md:right-[18%]">
                <div class="h-1 bg-gray-200 rounded-full">
                    <div class="h-full bg-green-500 rounded-full transition-all duration-500 ease-in-out"
                         style="width: {{ ($currentStep - 1) * 50 }}%">
                    </div>
                </div>
            </div> --}}

            <!-- Points d'étape avec espacement ajusté -->
            <div class="flex justify-between w-full relative z-10">
                @for ($i = 1; $i <= 3; $i++)
                    <div
                        class="flex flex-col items-center {{ $i === 2 ? '-translate-x-[10%] sm:-translate-x-[10%]' : '' }}">
                        <div
                            class="
                            w-7 h-7 rounded-full flex items-center justify-center
                            transition-all duration-300
                            {{ $currentStep == $i
                                ? 'bg-blue-600 text-white shadow-lg ring-2 ring-blue-300'
                                : ($currentStep > $i
                                    ? 'bg-green-500 text-white'
                                    : 'bg-gray-200 text-gray-600 border-2') }}">
                            @if ($currentStep > $i)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                {{ $i }}
                            @endif
                        </div>
                        <div class="mt-2 text-sm {{ $currentStep == $i ? 'font-semibold' : 'text-gray-500' }}">
                            @switch($i)
                                @case(1)
                                    Identification
                                @break

                                @case(2)
                                    Information
                                @break

                                @case(3)
                                    Séjour
                                @break
                            @endswitch
                        </div>
                    </div>
                    @if ($i < 3)
                        <!-- Trait gris entre les steps -->
                        <div class="flex-1 mx-2 mt-3"
                            style="border-top: 2px dotted #d1d5db; height: 2px; background-repeat: repeat-x; background-size: 6px 2px; margin-right: 25px">
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
    <!-- Contenu des étapes -->
    @if ($currentStep === 1)
        <x-input label="Numéro d'indentité" wire:model="identity_number" autofocus />
        <div class="flex flex-row justify-between mt-6 mb-6 gap-4">
            {{-- Selfi --}}
            <div class="w-full max-w-[42%] p-3 bg-white rounded-xl shadow-md border border-blue-200">
                <div class="flex flex-col items-center justify-center border-2 border-dashed border-blue-400 rounded-md h-32 cursor-pointer"
                    wire:click="$refs.selfiInput.click()" @click="$refs.selfiInput.click()">
                    @if (!$selfi)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 mb-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="text-sm text-gray-500">Prendre une photo</span>
                    @else
                        <img src="{{ $selfi->temporaryUrl() }}" alt="Preview"
                            class="object-cover h-full w-full rounded-md" />
                    @endif
                </div>

                @if ($selfi)
                    <div class="flex items-center mt-4 px-4 py-2 bg-gray-100 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                        </svg>
                        <span class="text-sm text-gray-600 truncate">{{ $selfi->getClientOriginalName() }}</span>
                    </div>
                @endif
            </div>
            <input type="file" wire:model="selfi" x-ref="selfiInput" class="hidden" accept="image/*" capture="user"
                key="{{ now() }}" />
            @error('selfi')
                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
            @enderror

            {{-- Carte d'identité --}}
            <div class="w-full max-w-[42%] p-3 bg-white rounded-xl shadow-md border border-blue-200">
                <div class="flex flex-col items-center justify-center border-2 border-dashed border-blue-400 rounded-md h-32 cursor-pointer"
                    wire:click="$refs.identity_imageInput.click()" @click="$refs.identity_imageInput.click()">
                    @if (!$identity_image)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 mb-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="text-sm text-gray-500">Carte d'identité</span>
                    @else
                        <img src="{{ $identity_image->temporaryUrl() }}" alt="Preview"
                            class="object-cover h-full w-full rounded-md" />
                    @endif
                </div>

                @if ($identity_image)
                    <div class="flex items-center mt-4 px-4 py-2 bg-gray-100 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                        </svg>
                        <span
                            class="text-sm text-gray-600 truncate">{{ $identity_image->getClientOriginalName() }}</span>
                    </div>
                @endif
            </div>

            <input type="file" wire:model="identity_image" x-ref="identity_imageInput" class="hidden"
                accept="image/*" capture="environement" key="{{ now() }}" />
            @error('identity_image')
                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
            @enderror
        </div>

        <x-select label="Moyen de l'enregistrement" wire:model="origin">
            <option value="">Sélectionner...</option>
            <option value="Manuel">Manuel</option>
            <option value="Autre">Autre</option>
        </x-select>
    @elseif ($currentStep === 2)
        <div>
            <x-input label="Votre nom" wire:model="Last_name" autofocus />
            <x-input label="Votre postom" wire:model="First_name"/>
            <x-select label="Genre" wire:model="gender_id">
                <option value="">Sélectionner...</option>
                @foreach ($genres_id as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
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
            <x-input label="Profession" wire:model="profession" />
            <x-input label="Nom du père" wire:model="father_name" />
            <x-input label="Nom de la mère" wire:model="mother_name" />
            <x-input label="Enfants de moins de 15ans" wire:model="children_under_15" />
        </div>
    @elseif ($currentStep === 3)
        <div class="min-h-[550px] md:min-h-[450px]">
            {{-- <x-input label="Client" wire:model="client_id" /> --}}
            <x-input label="Date d'arrivée" wire:model="date_arrivee" type="date" />
            <x-input label="Date de départ" wire:model="date_depart" type="date" />
            <x-input label="Motif" wire:model="motif" />
            @if ($nationalite != 'Congolaise')
            <div>
                <x-input label="Date d'arrivée au pays" wire:model="arrival_country_date" type="date"/>
                <x-input label="Date de depart du pays" wire:model="departure_country_date" type="date" />
            {{-- <x-input label="Lieu de séjour" wire:model="lieu_sejour" /> --}}
            </div>
            @endif
            <x-input label="Numero de de la chambre" wire:model="num_chambre" />
            {{-- <x-input label="Nombre de personnes" wire:model="nombre_personnes" type="number" /> --}}
        </div>
    
    @endif

    <!-- Navigation Buttons -->
    <div class="mt-6 flex justify-between">
        @if ($currentStep > 1)
            <button wire:click="decreaseStep" wire:loading.attr="disabled"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition-colors disabled:opacity-50">
                <span wire:loading.remove wire:target="decreaseStep">Précédent</span>
                <span wire:loading wire:target="decreaseStep" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Chargement...
                </span>
            </button>
        @endif

        @if ($currentStep < 4)
            <button wire:click="increaseStep" wire:loading.attr="disabled"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors disabled:opacity-50 ml-auto">
                <span wire:loading.remove wire:target="increaseStep">Suivant</span>
                <span wire:loading wire:target="increaseStep" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Chargement...
                </span>
            </button>
        @else
            <button wire:click="submit" wire:loading.attr="disabled"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors disabled:opacity-50 ml-auto">
                <span wire:loading.remove wire:target="submit">Terminer</span>
                <span wire:loading wire:target="submit" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Enregistrement...
                </span>
            </button>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="text-green-600 mt-4 text-center">{{ session('message') }}</div>
    @endif
</div>
