<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Room;

class RoomTable extends DataTableComponent
{
    protected $model = Room::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setPerPageAccepted([5, 10, 25, 50, 100, 500]);
        $this->setFilterLayout('slide-down');
        $this->setConfigurableAreas([
            'toolbar-left-start' => [
                'components.table.button-create-new', [
                    'label' => '+ Ruangan',
                    'href' => route('room.create'),
                    'modal' => 'create-modal',
                ],
            ],
        ]);
    }

    public function refreshTable()
    {
        return $this->emit('refreshDatatable');
    }

    public function columns(): array
    {
        return [
            Column::make("No", "id")->sortable(),
            Column::make("Ruangan", "name")
                ->format(
                    function ($value, $row, Column $column) {
                        $model = 'room';
                        return view('components.table.column-name-with-action', compact('value', 'row', 'column', 'model'));
                    }
                )
                ->sortable()->searchable(),
            Column::make("Kapasitas", "capacity")->sortable(),
            Column::make("Created at", "created_at")->sortable()->deselected(),
            Column::make("Updated at", "updated_at")->sortable()->deselected(),
        ];
    }
}
