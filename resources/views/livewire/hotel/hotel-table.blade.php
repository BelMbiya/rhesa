<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Les hotels') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('hotel-registration') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded text-center shadow mb-4 inline-block">Ajouter un hôtel</a>
            <livewire:hotel.hotels-table />
        </div>
    </div>
</x-app-layout>
