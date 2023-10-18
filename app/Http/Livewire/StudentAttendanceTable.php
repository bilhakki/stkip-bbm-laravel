<?php

namespace App\Http\Livewire;

use App\Enums\UserRole;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\StudentAttendance;
use Illuminate\Database\Eloquent\Builder;

class StudentAttendanceTable extends DataTableComponent
{
    protected $model = StudentAttendance::class;

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
                    'label' => '+ Absen',
                    'href' => route('student-attendance.create'),
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
        $studentAttendances = StudentAttendance::query()
            ->with(['student', 'student.major', 'student.major.faculty']) // Eager load anything
            // ->join() // Join some tables
            // ->select(); // Select some things
        ;

        $role = auth()->user()->role;
        if ($role === UserRole::ACADEMIC_FACULTY) {
            $faculty_id = auth()->user()->academic->academicable_id;
            $studentAttendances = $studentAttendances->whereHas('student.major.faculty', function ($query) use ($faculty_id) {
                $query->where('id', $faculty_id);
            });
        } else if ($role === UserRole::ACADEMIC_MAJOR) {
            $major_id = auth()->user()->academic->academicable_id;
            $studentAttendances = $studentAttendances->whereHas('student.major', function ($query) use ($major_id) {
                $query->where('id', $major_id);
            });
        }

        return $studentAttendances;
    }

    public function columns(): array
    {
        return [
            Column::make("No", "id")->sortable(),
            Column::make("Nama", "student.user.name")
                ->format(
                    function ($value, $row, Column $column) {
                        $model = 'student-attendance';
                        return view('components.table.column-name-with-action', compact('value', 'row', 'column', 'model'));
                    }
                )
                ->sortable()->searchable(),
    
            Column::make("Status", "status")->sortable(),
            Column::make("Kelas", "classroomSession.classroom.name")->sortable(),
            Column::make("Created at", "created_at")->sortable(),
            Column::make("Updated at", "updated_at")->sortable()->deselected(),
        ];
    }
}
