<div class="py-12">
<x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestion des Utilisateurs') }}
            </h2>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- En-tête avec Titre et Bouton --}}
        <div class="flex justify-between items-center mb-8">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Les utilisateurs') }}
            </h2>
            <a href="{{ route('users.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest hover:bg-green-700 shadow-lg transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                Ajouter un utilisateur
            </a>
        </div>

        {{-- Appel du tableau de Rappasoft --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="p-6">
                <livewire:utilisateur.users-table />
            </div>
        </div>
    </div>
</div>
