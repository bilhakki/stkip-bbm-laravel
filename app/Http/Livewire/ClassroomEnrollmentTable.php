<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\ClassroomEnrollment;

class ClassroomEnrollmentTable extends DataTableComponent
{
    protected $model = ClassroomEnrollment::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Remarks", "remarks")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("Season id", "season_id")
                ->sortable(),
            Column::make("Classroom id", "classroom_id")
                ->sortable(),
            Column::make("Student id", "student_id")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
