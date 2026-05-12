<div class="py-12">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Détails de l'Utilisateur : {{ $user->name }}
            </h2>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- En-tête --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-8 border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        Détails de l'Utilisateur : {{ $user->name }}
                    </h2>
                    <div class="flex space-x-4">
                        <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier
                        </a>
                        <button wire:click="deleteUser"
                                onclick="return confirm('Confirmer la suppression de {{ $user->name }} ?')"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Supprimer
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informations du Compte</h3>
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                            <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nom</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2 font-semibold">{{ $user->name }}</dd>
                            </div>
                            <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
                            </div>
                            <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Statut</dt>
                                <dd class="mt-1 sm:mt-0 sm:col-span-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $user->status === 'actif'
                                            ? 'bg-green-100 text-green-800'
                                            : ($user->status === 'inactif'
                                                ? 'bg-red-100 text-red-800'
                                                : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Hôtel Associé</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                    {{ $user->hotel->name ?? 'Non assigné' }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Historique</h3>
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                            <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dernière Connexion</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                    {{ $user->lastlogin ? \Carbon\Carbon::parse($user->lastlogin)->format('d/m/Y H:i') : 'N/A' }}
                                </dd>
                            </div>
                            <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Créé le</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}
                                </dd>
                            </div>
                            <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mis à jour le</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                    {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════
             SECTION RÔLES
        ══════════════════════════════ --}}
        @canany(['assign roles', 'revoke roles'])
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">Gestion des Rôles</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">
                    Un rôle attribue automatiquement un ensemble de permissions prédéfinies.
                </p>

                @if(session('role_success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg flex items-center gap-2 text-green-700 text-sm">
                        <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('role_success') }}
                    </div>
                @endif

                @if(session('role_error'))
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg flex items-center gap-2 text-red-700 text-sm">
                        <svg class="h-4 w-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('role_error') }}
                    </div>
                @endif

                {{-- Rôles actuels --}}
                <div class="mb-5">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rôles actuels :</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse($user->roles as $role)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                @switch($role->name)
                                    @case('Super Admin')    {{ 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' }} @break
                                    @case('Ministry Admin') {{ 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }} @break
                                    @case('Inspector')      {{ 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-200' }} @break
                                    @case('Hotel Manager')  {{ 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }} @break
                                    @case('Receptionist')   {{ 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }} @break
                                    @default                {{ 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}
                                @endswitch">
                                {{ $role->name }}
                                @can('revoke roles')
                                    <button wire:click="revokeRole('{{ $role->name }}')"
                                            wire:confirm="Révoquer le rôle « {{ $role->name }} » de {{ $user->name }} ?"
                                            class="ml-1 hover:text-red-600 transition-colors"
                                            title="Révoquer">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                @endcan
                            </span>
                        @empty
                            <span class="text-sm text-gray-400 italic">Aucun rôle assigné</span>
                        @endforelse
                    </div>
                </div>

                {{-- Assigner un nouveau rôle --}}
                @can('assign roles')
                <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Assigner un rôle :</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($allRoles as $role)
                            @php $hasRole = $user->hasRole($role->name); @endphp
                            <button
                                wire:click="assignRole('{{ $role->name }}')"
                                @disabled($hasRole)
                                class="flex items-center justify-between px-3 py-2 rounded-lg border text-sm font-medium transition-all
                                    {{ $hasRole
                                        ? 'border-gray-200 bg-gray-50 text-gray-400 cursor-not-allowed dark:border-gray-700 dark:bg-gray-800'
                                        : 'border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100 dark:border-blue-800 dark:bg-blue-900/30 dark:text-blue-300 dark:hover:bg-blue-900/50' }}">
                                <span>{{ $role->name }}</span>
                                @if($hasRole)
                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
                @endcan

            </div>
        </div>
        @endcanany

        {{-- ══════════════════════════════
             SECTION PERMISSIONS DIRECTES
        ══════════════════════════════ --}}
        @canany(['assign roles', 'revoke roles'])
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">Permissions Directes</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">
                    Permissions ajoutées individuellement, en supplément des rôles.
                    <span class="text-amber-600 dark:text-amber-400 font-medium">À utiliser avec parcimonie.</span>
                </p>

                @php
                    $permissionsViaRoles = $user->getPermissionsViaRoles()->pluck('name');
                    $directPermissions   = $user->getDirectPermissions()->pluck('name');
                    $grouped = $allPermissions->groupBy(function ($p) {
                        $parts = explode(' ', $p->name);
                        return ucfirst(end($parts));
                    })->sortKeys();
                @endphp

                <div class="space-y-5">
                    @foreach($grouped as $domain => $permissions)
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    {{ $domain }}
                                </span>
                                <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                @foreach($permissions as $permission)
                                    @php
                                        $hasViaRole = $permissionsViaRoles->contains($permission->name);
                                        $hasDirect  = $directPermissions->contains($permission->name);
                                    @endphp
                                    <div class="flex items-center justify-between px-3 py-2 rounded-lg border
                                        {{ $hasViaRole
                                            ? 'border-green-200 bg-green-50 dark:border-green-800 dark:bg-green-900/20'
                                            : ($hasDirect
                                                ? 'border-blue-200 bg-blue-50 dark:border-blue-800 dark:bg-blue-900/20'
                                                : 'border-gray-100 bg-gray-50 dark:border-gray-700 dark:bg-gray-900/20') }}">

                                        <div class="flex items-center gap-2 min-w-0">
                                            @if($hasViaRole)
                                                <span class="shrink-0 h-2 w-2 rounded-full bg-green-500" title="Via rôle"></span>
                                            @elseif($hasDirect)
                                                <span class="shrink-0 h-2 w-2 rounded-full bg-blue-500" title="Permission directe"></span>
                                            @else
                                                <span class="shrink-0 h-2 w-2 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                                            @endif
                                            <span class="text-xs text-gray-700 dark:text-gray-300 truncate" title="{{ $permission->name }}">
                                                {{ $permission->name }}
                                            </span>
                                        </div>

                                        <div class="shrink-0 ml-2">
                                            @if($hasViaRole)
                                                <span class="text-xs text-green-600 dark:text-green-400 font-medium">via rôle</span>
                                            @elseif($hasDirect)
                                                @can('revoke roles')
                                                    <button wire:click="revokePermission('{{ $permission->name }}')"
                                                            wire:confirm="Révoquer la permission « {{ $permission->name }} » ?"
                                                            class="text-red-500 hover:text-red-700 transition-colors">
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </button>
                                                @endcan
                                            @else
                                                @can('assign roles')
                                                    <button wire:click="givePermission('{{ $permission->name }}')"
                                                            class="text-blue-500 hover:text-blue-700 transition-colors">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                    </button>
                                                @endcan
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Légende --}}
                <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-700 flex flex-wrap gap-4 text-xs text-gray-500 dark:text-gray-400">
                    <span class="flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full bg-green-500"></span>
                        Accordée via rôle (non révocable ici)
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                        Permission directe
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full bg-gray-300"></span>
                        Non accordée
                    </span>
                </div>

            </div>
        </div>
        @endcanany

    </div>
</div>