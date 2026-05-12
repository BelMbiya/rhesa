{{-- resources/views/livewire/manager/hotel-dashboard.blade.php --}}
<div class="min-h-screen bg-gray-900 py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"></div>
<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- En-tête --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    Tableau de bord
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ $hotel->name }} — {{ now()->isoFormat('dddd D MMMM Y') }}
                </p>
            </div>
            <a href="{{ route('manager.clients') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Gérer les clients du jour
            </a>
        </div>

        {{-- Cartes stats du jour --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 border-l-4 border-indigo-500">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aujourd'hui
                </p>
                <p class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-1">{{ $todayCount }}</p>
                <p class="text-xs text-gray-400 mt-1">enregistrement(s)</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 border-l-4 border-yellow-400">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">En attente
                </p>
                <p class="text-3xl font-extrabold text-yellow-500 mt-1">{{ $todayPending }}</p>
                <p class="text-xs text-gray-400 mt-1">à valider</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 border-l-4 border-green-500">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Confirmés</p>
                <p class="text-3xl font-extrabold text-green-600 dark:text-green-400 mt-1">{{ $todayConfirmed }}</p>
                <p class="text-xs text-gray-400 mt-1">aujourd'hui</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 border-l-4 border-red-400">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Annulés</p>
                <p class="text-3xl font-extrabold text-red-500 mt-1">{{ $todayCancelled }}</p>
                <p class="text-xs text-gray-400 mt-1">aujourd'hui</p>
            </div>

        </div>

        {{-- Cartes stats globales --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 flex items-center gap-4">
                <div
                    class="h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center shrink-0">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-gray-800 dark:text-gray-100">{{ $totalClients }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Clients enregistrés (total)</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 flex items-center gap-4">
                <div
                    class="h-12 w-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center shrink-0">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-gray-800 dark:text-gray-100">{{ $currentGuests }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Clients présents actuellement</p>
                </div>
            </div>

        </div>

        {{-- Grille basse : En attente + Graphique --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- En attente de validation --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                        En attente de validation
                    </h2>
                    @if($todayPending > 0)
                        <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">
                            {{ $todayPending }}
                        </span>
                    @endif
                </div>

                <div class="divide-y divide-gray-50 dark:divide-gray-700">
                    @forelse($recentRegistrations as $reg)
                        @php $client = $reg->stay->client; @endphp
                        <div
                            class="px-5 py-3 flex items-center justify-between gap-3 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors">
                            <div class="flex items-center gap-3 min-w-0">
                                {{-- Avatar initiales --}}
                                <div
                                    class="h-9 w-9 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center shrink-0 text-indigo-700 dark:text-indigo-300 text-xs font-bold uppercase">
                                    {{ substr($client->first_name, 0, 1) }}{{ substr($client->last_name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                        {{ $client->first_name }} {{ $client->last_name }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        Ch. {{ $reg->stay->room_number ?? '—' }}
                                        · {{ \Carbon\Carbon::parse($reg->registration_time)->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('manager.clients') }}"
                                class="shrink-0 px-3 py-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 text-xs font-semibold rounded-lg transition-colors">
                                Traiter
                            </a>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center text-gray-400">
                            <svg class="mx-auto h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm">Aucune demande en attente</p>
                        </div>
                    @endforelse
                </div>

                @if($todayPending > 5)
                    <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ route('manager.clients') }}"
                            class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                            Voir les {{ $todayPending - 5 }} autres →
                        </a>
                    </div>
                @endif
            </div>

            {{-- Graphique 7 jours --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                        Confirmations — 7 derniers jours
                    </h2>
                </div>
                <div class="p-5">
                    @php
                        $counts = array_column($weeklyStats, 'count');
                        $maxVal = count($counts) > 0 ? max(max($counts), 1) : 1;
                    @endphp
                    <div class="flex items-end gap-2 h-32">
                        @foreach($weeklyStats as $day)
                            @php
                                $height = $day['count'] > 0
                                    ? max(8, (int) (($day['count'] / $maxVal) * 100))
                                    : 4;
                                $isToday = $loop->last;
                            @endphp
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <span class="text-xs font-semibold {{ $isToday ? 'text-indigo-600' : 'text-gray-400' }}">
                                    {{ $day['count'] > 0 ? $day['count'] : '' }}
                                </span>
                                <div class="w-full rounded-t transition-all duration-500
                                        {{ $isToday ? 'bg-indigo-500' : 'bg-indigo-200 dark:bg-indigo-800' }}"
                                    style="height: {{ $height }}%">
                                </div>
                                <span class="text-xs text-gray-400">{{ $day['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        {{-- Infos hôtel --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-4">Informations de l'hôtel</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Nom</p>
                    <p class="font-medium text-gray-800 dark:text-gray-100">{{ $hotel->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Adresse</p>
                    <p class="font-medium text-gray-800 dark:text-gray-100">{{ $hotel->address ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Téléphone</p>
                    <p class="font-medium text-gray-800 dark:text-gray-100">{{ $hotel->phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Statut</p>
                    <span
                        class="px-2 py-0.5 rounded-full text-xs font-semibold
                        {{ $hotel->status === 'actif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ ucfirst($hotel->status ?? '—') }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>