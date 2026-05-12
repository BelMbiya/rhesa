<?php

namespace App\Livewire\utilisateur;

use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Livewire\Attributes\Layout; 

#[Layout('layouts.app')]
class UsersTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey("id");
        $this->setSearchEnabled();
        $this->setColumnSelectEnabled();
        $this->setPaginationEnabled();
        $this->setSortingEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),
            Column::make("Nom", "name")
                ->sortable()
                ->searchable(),
            Column::make("Email", "email")
                ->sortable()
                ->searchable(),
            Column::make("Statut", "status")
                ->sortable()
                ->format(function($value, $row, Column $column) {
                    $badgeClass = match($value) {
                        'actif' => 'bg-green-100 text-green-800',
                        'inactif' => 'bg-red-100 text-red-800',
                        'suspendu' => 'bg-yellow-100 text-yellow-800',
                        default => 'bg-gray-100 text-gray-800',
                    };
                    return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ' . $badgeClass . '">' . ucfirst($value) . '</span>';
                })
                ->html(),
                Column::make("Hôtel", "hotel.name")
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return $value ?: 'Non assigné';
                }),
            
            Column::make("Dernière connexion", "lastlogin")
                ->sortable()
                ->format(fn($value) => $value ? \Carbon\Carbon::parse($value)->format('d/m/Y H:i') : 'N/A'),
            Column::make("Créé le", "created_at")
                ->sortable()
                ->format(fn($value) => \Carbon\Carbon::parse($value)->format('d/m/Y H:i')),
            ButtonGroupColumn::make('Actions')
                ->attributes(function ($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons([
                    LinkColumn::make('Voir')
                        ->title(fn($row) => 'Voir')
                        ->location(fn($row) => route('users.show', ['user' => $row->id]))
                        ->attributes(function ($row) {
                            return [
                                'class' => 'underline text-blue-500 hover:no-underline',
                            ];
                        }),
                    LinkColumn::make('Modifier')
                        ->title(fn($row) => 'Modifier')
                        ->location(fn($row) => route('users.edit', ['user' => $row->id]))
                        ->attributes(function ($row) {
                            return [
                                'class' => 'underline text-green-500 hover:no-underline',
                            ];
                        }),
                    LinkColumn::make('Supprimer')
                        ->title(fn($row) => 'Supprimer')
                        ->location(fn($row) => route('users.destroy', ['user' => $row->id]))
                        ->attributes(fn($row) => [
                            'onclick' => "return confirm('Confirmer la suppression de l\'utilisateur ' . $row->name . ' ?')",
                            'class' => 'underline text-red-500 hover:no-underline',
                        ]),
                ]),
        ];
    }
    
}
