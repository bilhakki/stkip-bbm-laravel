<?php

namespace App\Http\Livewire;

use App\Enums\StudentStatus;
use App\Enums\UserRole;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\Student;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\StudentGrade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class StudentGradeTable extends DataTableComponent
{
    protected $model = StudentGrade::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setPerPageAccepted([5, 10, 25, 50, 100, 500]);

        $this->setFilterLayout('slide-down');
        $this->setFiltersVisibilityStatus(true);
        $this->setFilterPillsStatus(true);
        $this->setFilterSlideDownDefaultStatus(true);

        $this->setConfigurableAreas([
            'toolbar-left-start' => [
                'components.table.button-create-new', [
                    'label' => '+ Nilai',
                    'href' => route('student-grade.create'),
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
        $studentGrades = StudentGrade::query()
            ->with(['student', 'student.major', 'student.major.faculty']) // Eager load anything
            // ->join() // Join some tables
            // ->select(); // Select some things
        ;

        $role = auth()->user()->role;
        if ($role === UserRole::ACADEMIC_FACULTY) {
            $faculty_id = auth()->user()->academic->academicable_id;
            $studentGrades = $studentGrades->whereHas('student.major.faculty', function ($query) use ($faculty_id) {
                $query->where('id', $faculty_id);
            });
        } else if ($role === UserRole::ACADEMIC_MAJOR) {
            $major_id = auth()->user()->academic->academicable_id;
            $studentGrades = $studentGrades->whereHas('student.major', function ($query) use ($major_id) {
                $query->where('id', $major_id);
            });
        }

        return $studentGrades;
    }

    public function columns(): array
    {
        return [
            Column::make("No", "id")->sortable(),
            Column::make("Nama", "student.user.name")
                ->format(
                    function ($value, $row, Column $column) {
                        $model = 'student-grade';
                        return view('components.table.column-name-with-action', compact('value', 'row', 'column', 'model'));
                    }
                )
                ->sortable()->searchable(),
            // Column::make("Fak", "student.major.faculty.name")->sortable(),
            // Column::make("Jur", "student.major.name")->sortable(),
            Column::make("Nilai", "grade")->sortable(),
            Column::make("MK", "course.name")->sortable(),
            Column::make("Kelas", "classroom.name")->sortable(),
            Column::make("Season", "season.name")->sortable(),
            Column::make("Created at", "created_at")->sortable(),
            Column::make("Updated at", "updated_at")->sortable()->deselected(),
        ];
    }


    public function filters(): array
    {
        return [];
    }
}
