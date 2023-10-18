<?php

namespace App\Http\Livewire;

use App\Enums\UserRole;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Builder;

class ClassroomTable extends DataTableComponent
{
    protected $model = Classroom::class;

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
                    'label' => '+ Kelas',
                    'href' => route('classroom.create'),
                    'modal' => 'create-modal',
                ],
            ],
        ]);
    }

    public function refreshTable()
    {
        return $this->emit('refreshDatatable');
    }

    public function builder(): Builder
    {
        $classrooms = Classroom::query()
            ->with(['course.major', 'course.faculty']) // Eager load anything
            // ->join() // Join some tables
            // ->select(); // Select some things
        ;

        $role = auth()->user()->role;
        if ($role === UserRole::ACADEMIC_FACULTY) {
            $faculty_id = auth()->user()->academic->academicable_id;
            $classrooms = $classrooms->whereHas('course.faculty', function ($query) use ($faculty_id) {
                $query->where('id', $faculty_id);
            });
        } else if ($role === UserRole::ACADEMIC_MAJOR) {
            $major_id = auth()->user()->academic->academicable_id;
            $classrooms = $classrooms->whereHas('course.major', function ($query) use ($major_id) {
                $query->where('id', $major_id);
            });
        }

        return $classrooms;
    }


    public function columns(): array
    {
        return [
            Column::make("No", "id")->sortable(),
            // Column::make("Fak", "course.faculty.name")->sortable(),
            // Column::make("Jur", "course.major.name")->sortable(),
            Column::make("Nama", "name")
                ->format(
                    function ($value, $row, Column $column) {
                        $model = 'classroom';
                        return view('components.table.column-name-with-action', compact('value', 'row', 'column', 'model'));
                    }
                )
                ->sortable()->searchable(),
            Column::make("Mata Kuliah", "course.name")->sortable(),
            Column::make("Semester", "season.name")->sortable(),
            Column::make("SKS", "credits")->sortable(),
            Column::make("Kapasitas", "capacity")->sortable(),

            Column::make("Created at", "created_at")->sortable()->deselected(),
            Column::make("Updated at", "updated_at")->sortable()->deselected(),
        ];
    }
}
