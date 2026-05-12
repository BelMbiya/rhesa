<?php

namespace App\Livewire\hotel;

use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Hotel;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class HotelsTable extends DataTableComponent
{
    protected $model = Hotel::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->removeDefaultSort();
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nom", "name")
                ->sortable(),
            Column::make("Téléphone", "phone")
                ->sortable(),
            Column::make("E-mail", "email")
                ->sortable(),
            Column::make("Commune ou Ville", "city.name")
                ->sortable(),
            Column::make("Province", "city.province.name")
                ->sortable(),
            /*ImageColumn::make('QR Code')
                ->location(
                    fn($row) => asset('qrcodes/' . Str::slug($row->name) . '.png')
                )
                ->attributes(fn($row) => [
                    'class' => 'h-48 w-96 object-scale-down ...',
                ]),*/
            ButtonGroupColumn::make('Actions')
                ->attributes(function ($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons([
                    LinkColumn::make('Voir') // make() has no effect in this case but needs to be set anyway
                        ->title(fn($row) => 'Voir')
                        ->location(fn($row) => route('hotel', Str::slug($row->name)))
                        ->attributes(function ($row) {
                            return [
                                'class' => 'underline text-blue-500 hover:no-underline',
                            ];
                        }),
                    LinkColumn::make('Supprimer')
                        ->title(fn($row) => 'Supprimer')
                        ->location(fn($row) => route('hotel-delete', ['id' => $row->id]))
                        ->attributes(fn($row) => [
                            'onclick' => "return confirm('Confirmer la suppression ?')",
                            'class' => 'underline text-red-500 hover:no-underline',
                        ]),
                    LinkColumn::make('Edit')
                        ->title(fn($row) => 'Edit')
                        ->location(fn($row) => route('hotel-update', ['id' => $row->id]))
                        ->attributes(function ($row) {
                            return [
                                'class' => 'underline text-green-500 hover:no-underline',
                            ];
                        }),
                ]),
        ];
    }
}
