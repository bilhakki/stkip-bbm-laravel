<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\ClassroomSession;

class ClassroomSessionTable extends DataTableComponent
{
    protected $model = ClassroomSession::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Start datetime", "start_datetime")
                ->sortable(),
            Column::make("End datetime", "end_datetime")
                ->sortable(),
            Column::make("Attendance code", "attendance_code")
                ->sortable(),
            Column::make("Topic", "topic")
                ->sortable(),
            Column::make("Classroom id", "classroom_id")
                ->sortable(),
            Column::make("Season id", "season_id")
                ->sortable(),
            Column::make("Lecturer id", "lecturer_id")
                ->sortable(),
            Column::make("Room id", "room_id")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
