{{-- resources/views/livewire/hotel/hotel-client-management.blade.php --}}
<div class="min-h-screen bg-gray-900 py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"></div>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- En-tête --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                        Clients du jour
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ $hotel->name }} — {{ now()->format('d/m/Y') }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400">
                        {{ $registrations->total() }}
                    </span>
                    <p class="text-xs text-gray-400">enregistrement(s)</p>
                </div>
            </div>

            {{-- Flash messages --}}
            @if(session('success'))
                <div
                    class="p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm flex items-center gap-2">
                    <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('info'))
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg text-blue-700 text-sm flex items-center gap-2">
                    <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('info') }}
                </div>
            @endif

            {{-- Barre de recherche + Boutons de filtre --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 space-y-3">

                {{-- Recherche --}}
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
                    </svg>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        placeholder="Rechercher par nom ou numéro d'identité..."
                        class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>

                {{-- Boutons de filtre --}}
                <div class="flex flex-wrap gap-2">
                    <button wire:click="$set('filterStatus', 'all')"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                        {{ $filterStatus === 'all'
    ? 'bg-indigo-600 text-white shadow'
    : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        Tous
                    </button>
                    <button wire:click="$set('filterStatus', 'today')"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                        {{ $filterStatus === 'today'
    ? 'bg-indigo-600 text-white shadow'
    : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        Aujourd'hui
                    </button>
                    <button wire:click="$set('filterStatus', 'pending')"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                        {{ $filterStatus === 'pending'
    ? 'bg-yellow-500 text-white shadow'
    : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        En attente
                    </button>
                    <button wire:click="$set('filterStatus', 'confirmed')"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                        {{ $filterStatus === 'confirmed'
    ? 'bg-green-600 text-white shadow'
    : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        Confirmés
                    </button>
                    <button wire:click="$set('filterStatus', 'cancelled')"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                        {{ $filterStatus === 'cancelled'
    ? 'bg-red-600 text-white shadow'
    : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        Annulés
                    </button>
                </div>
            </div>

            {{-- Tableau --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">
                        Gestion des Enregistrements
                        @if($filterStatus !== 'all')
                            <span class="ml-2 text-sm font-normal text-gray-400">
                                — filtre :
                                @php
                                    echo match ($filterStatus) {
                                        'today' => "Aujourd'hui",
                                        'pending' => 'En attente',
                                        'confirmed' => 'Confirmés',
                                        'cancelled' => 'Annulés',
                                        default => '',
                                    };
                                @endphp
                            </span>
                        @endif
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Client</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Identité</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Chambre</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Heure</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Statut</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Photos</th>
                                <th
                                    class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($registrations as $reg)
                                @php $client = $reg->stay->client; @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">

                                    {{-- Client --}}
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-900 dark:text-gray-100 text-sm">
                                            {{ $client->first_name }} {{ $client->last_name }}
                                        </div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $client->email ?? '—' }}</div>
                                        <div class="text-xs text-gray-400">{{ $client->phone ?? '—' }}</div>
                                    </td>

                                    {{-- Identité --}}
                                    <td class="px-4 py-3">
                                        <span class="text-sm text-gray-700 dark:text-gray-300 font-mono">
                                            {{ $client->identity_number }}
                                        </span>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $client->nationality }}</div>
                                    </td>

                                    {{-- Chambre --}}
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $reg->stay->room_number ?? '—' }}
                                    </td>

                                    {{-- Heure --}}
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($reg->registration_time)->format('H:i') }}
                                    </td>

                                    {{-- Statut --}}
                                    <td class="px-4 py-3">
                                        @php
                                            $status = $reg->status ?? 'pending';
                                            $badge = match ($status) {
                                                'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            };
                                            $label = match ($status) {
                                                'confirmed' => 'Confirmé',
                                                'cancelled' => 'Annulé',
                                                default => 'En attente',
                                            };
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                            {{ $label }}
                                        </span>
                                    </td>

                                    {{-- Photos --}}
                                    <td class="px-4 py-3">
                                        <div class="flex gap-2">
                                            @if($client->identity_image)
                                                <a href="{{ asset('storage/' . $client->identity_image) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $client->identity_image) }}"
                                                        class="h-10 w-10 rounded object-cover border border-gray-200 hover:scale-150 transition-transform"
                                                        alt="Pièce d'identité" />
                                                </a>
                                            @endif
                                            @if($client->selfi)
                                                <a href="{{ asset('storage/' . $client->selfi) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $client->selfi) }}"
                                                        class="h-10 w-10 rounded object-cover border border-gray-200 hover:scale-150 transition-transform"
                                                        alt="Selfie" />
                                                </a>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-4 py-3 text-right">
                                        @if(($reg->status ?? 'pending') === 'pending')
                                            <div class="flex justify-end gap-2">

                                                {{-- Confirmer --}}
                                                @if($confirmingId === $reg->id)
                                                    <div class="flex items-center gap-1">
                                                        <span class="text-xs text-gray-500">Confirmer ?</span>
                                                        <button wire:click="confirmRegistration({{ $reg->id }})"
                                                            class="px-2 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded font-medium">
                                                            Oui
                                                        </button>
                                                        <button wire:click="$set('confirmingId', null)"
                                                            class="px-2 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs rounded font-medium">
                                                            Non
                                                        </button>
                                                    </div>
                                                @else
                                                    <button wire:click="$set('confirmingId', {{ $reg->id }})"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 text-xs font-semibold rounded-lg transition-colors">
                                                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Valider
                                                    </button>
                                                @endif

                                                {{-- Annuler --}}
                                                @if($cancellingId === $reg->id)
                                                    <div class="flex items-center gap-1">
                                                        <span class="text-xs text-red-500 font-medium">Supprimer ?</span>
                                                        <button wire:click="cancelRegistration({{ $reg->id }})"
                                                            class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded font-medium">
                                                            Oui
                                                        </button>
                                                        <button wire:click="$set('cancellingId', null)"
                                                            class="px-2 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs rounded font-medium">
                                                            Non
                                                        </button>
                                                    </div>
                                                @else
                                                    <button wire:click="$set('cancellingId', {{ $reg->id }})"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-semibold rounded-lg transition-colors">
                                                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Annuler
                                                    </button>
                                                @endif

                                                {{-- Voir --}}
                                                <a href="{{ route('manager.client-detail', $client->id) }}"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-xs font-semibold rounded-lg transition-colors">
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Voir
                                                </a>
                                            </div>

                                        @elseif(($reg->status ?? '') === 'confirmed')
                                            <div class="flex justify-end gap-2">
                                                <span class="text-xs text-green-600 font-medium">✓ Validé</span>
                                                <a href="{{ route('client-registration.download', $client->id) }}"
                                                    target="_blank"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-lg transition-colors">
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    PDF
                                                </a>
                                            </div>

                                        @else
                                            <span class="text-xs text-red-400 italic">Annulé</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center text-gray-400">
                                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-sm font-medium">Aucun enregistrement trouvé</p>
                                        @if(!empty(trim($search)))
                                            <p class="text-xs text-gray-400 mt-1">Aucun résultat pour « {{ $search }} »</p>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($registrations->hasPages())
                    <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
                        {{ $registrations->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
</div>