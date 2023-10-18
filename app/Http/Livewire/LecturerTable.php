<?php

namespace App\Http\Livewire;

use App\Enums\LecturerStatus;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class LecturerTable extends DataTableComponent
{
    protected $model = Lecturer::class;

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
                    'label' => '+ Dosen',
                    'href' => route('lecturer.create'),
                    'modal' => 'create-modal',
                ],
            ],
        ]);
    }

    public function filters(): array
    {
        $status = [
            "" => "SEMUA",
        ];
        foreach (LecturerStatus::values() as $key => $value) {
            $status[$value] = strtoupper($value);
        }

        return [
            SelectFilter::make('Status')
                ->options($status)->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('status', $value);
                    }
                }),
       
        ];
    }

    public function refreshTable()
    {
        return $this->emit('refreshDatatable');
    }

    public function columns(): array
    {
        return [
            Column::make("No", "id")->sortable(),
            Column::make("Nama", "user.name")
                ->format(
                    function ($value, $row, Column $column) {
                        $model = 'lecturer';
                        return view('components.table.column-name-with-action', compact('value', 'row', 'column', 'model'));
                    }
                )
                ->sortable()->searchable(),
            Column::make("Status", "status")->sortable(),
            Column::make("Posisi", "position")->sortable()->collapseOnTablet()->deselected(),
            Column::make("Spesialisasi", "specialization")->sortable()->collapseOnTablet()->deselected(),
            Column::make("Nomor HP", "phone_number")->sortable()->collapseOnTablet()->deselected(),
            Column::make("Created at", "created_at")->sortable()->collapseOnTablet()->deselected(),
            Column::make("Updated at", "updated_at")->sortable()->collapseOnTablet()->deselected(),
        ];
    }
}
