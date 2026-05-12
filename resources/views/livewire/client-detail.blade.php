{{-- resources/views/livewire/client-detail.blade.php --}}
<div class="py-10">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- En-tête --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    Récapitulatif d'enregistrement
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ $hotel_name ?? 'Hôtel' }} —
                    {{ $reg_date ? \Carbon\Carbon::parse($reg_date)->format('d/m/Y') : '' }}
                    {{ $reg_time ? 'à ' . \Carbon\Carbon::parse($reg_time)->format('H:i') : '' }}
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('client-registration.download', $client->id) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Télécharger PDF
                </a>
                <a href="javascript:history.back()"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-colors dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    ← Retour
                </a>
            </div>
        </div>

        {{-- Statut --}}
        @if($registration)
        <div class="flex items-center gap-3 p-4 rounded-xl
            {{ $registration->status === 'confirmed' ? 'bg-green-50 border border-green-200 dark:bg-green-900/20 dark:border-green-800' :
               ($registration->status === 'cancelled' ? 'bg-red-50 border border-red-200 dark:bg-red-900/20 dark:border-red-800' :
                'bg-yellow-50 border border-yellow-200 dark:bg-yellow-900/20 dark:border-yellow-800') }}">
            @php
                $statusColor = match($registration->status ?? 'pending') {
                    'confirmed' => 'bg-green-500',
                    'cancelled' => 'bg-red-500',
                    default     => 'bg-yellow-400',
                };
                $statusLabel = match($registration->status ?? 'pending') {
                    'confirmed' => 'Enregistrement confirmé',
                    'cancelled' => 'Enregistrement annulé',
                    default     => 'En attente de validation',
                };
            @endphp
            <span class="h-3 w-3 rounded-full {{ $statusColor }} shrink-0"></span>
            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $statusLabel }}</span>
            @if($registration->reviewed_at)
                <span class="text-xs text-gray-400 ml-auto">
                    Traité le {{ \Carbon\Carbon::parse($registration->reviewed_at)->format('d/m/Y à H:i') }}
                </span>
            @endif
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Colonne gauche : infos client --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Identité --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-700 bg-indigo-50 dark:bg-indigo-900/30">
                        <h2 class="text-sm font-bold text-indigo-700 dark:text-indigo-300 uppercase tracking-wider">
                            Informations personnelles
                        </h2>
                    </div>
                    <div class="p-5">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Nom complet</dt>
                                <dd class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $client->first_name }} {{ $client->last_name }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">N° Identité</dt>
                                <dd class="text-sm font-mono font-bold text-indigo-600 dark:text-indigo-400">
                                    {{ $client->identity_number }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Date de naissance</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $client->birth_date ? \Carbon\Carbon::parse($client->birth_date)->format('d/m/Y') : '—' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Lieu de naissance</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $client->birth_place ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Nationalité</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $client->nationality ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Adresse</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $client->permanent_address ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Téléphone</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $client->phone ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Email</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $client->email ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Profession</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $client->profession ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Enfants -15 ans</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $client->children_under_15 ?? '0' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Nom du père</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $client->father_name ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Nom de la mère</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $client->mother_name ?? '—' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Séjour --}}
                @if($stay)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-700 bg-teal-50 dark:bg-teal-900/30">
                        <h2 class="text-sm font-bold text-teal-700 dark:text-teal-300 uppercase tracking-wider">
                            Détails du séjour
                        </h2>
                    </div>
                    <div class="p-5">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Chambre</dt>
                                <dd class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $stay->room_number ?? '—' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Motif du séjour</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $stay->purpose ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Arrivée pays</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $stay->arrival_country_date ? \Carbon\Carbon::parse($stay->arrival_country_date)->format('d/m/Y') : '—' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Départ pays</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $stay->departure_country_date ? \Carbon\Carbon::parse($stay->departure_country_date)->format('d/m/Y') : '—' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-400 uppercase tracking-wider mb-1">Prochaine destination</dt>
                                <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $stay->next_destination ?? '—' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
                @endif

            </div>

            {{-- Colonne droite : photos + enregistrement --}}
            <div class="space-y-6">

                {{-- Photos --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-700 bg-purple-50 dark:bg-purple-900/30">
                        <h2 class="text-sm font-bold text-purple-700 dark:text-purple-300 uppercase tracking-wider">
                            Identité visuelle
                        </h2>
                    </div>
                    <div class="p-5 space-y-4">
                        @if($client->identity_image)
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Pièce d'identité</p>
                                <a href="{{ asset('storage/' . $client->identity_image) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $client->identity_image) }}"
                                         class="w-full rounded-lg border border-gray-200 object-cover max-h-40 hover:opacity-90 transition-opacity"
                                         alt="Pièce d'identité" />
                                </a>
                            </div>
                        @endif
                        @if($client->selfi)
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Selfie</p>
                                <a href="{{ asset('storage/' . $client->selfi) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $client->selfi) }}"
                                         class="w-full rounded-lg border border-gray-200 object-cover max-h-40 hover:opacity-90 transition-opacity"
                                         alt="Selfie" />
                                </a>
                            </div>
                        @endif
                        @if($registration?->signature)
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Signature</p>
                                <a href="{{ asset('storage/' . $registration->signature) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $registration->signature) }}"
                                         class="w-full rounded-lg border border-gray-200 bg-white object-contain max-h-24 hover:opacity-90 transition-opacity"
                                         alt="Signature" />
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Enregistrement --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                        <h2 class="text-sm font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                            Enregistrement
                        </h2>
                    </div>
                    <div class="p-5 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Hôtel</span>
                            <span class="font-medium text-gray-800 dark:text-gray-100">{{ $hotel_name ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Date</span>
                            <span class="font-medium text-gray-800 dark:text-gray-100">
                                {{ $reg_date ? \Carbon\Carbon::parse($reg_date)->format('d/m/Y') : '—' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Heure</span>
                            <span class="font-medium text-gray-800 dark:text-gray-100">
                                {{ $reg_time ? \Carbon\Carbon::parse($reg_time)->format('H:i') : '—' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Origine</span>
                            <span class="font-medium text-gray-800 dark:text-gray-100">{{ $client->origin ?? '—' }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>