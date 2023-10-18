<?php

namespace App\Http\Livewire;

use App\Enums\StudentStatus;
use App\Enums\UserRole;
use App\Models\Faculty;
use App\Models\Major;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Nette\Utils\Arrays;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectDropdownFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class StudentTable extends DataTableComponent
{
    protected $model = Student::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setPerPageAccepted([5, 10, 25, 50, 100, 500]);
        $this->setDefaultSort('id', 'desc');

        $this->setFilterLayout('slide-down');
        $this->setFiltersVisibilityStatus(true);
        $this->setFilterPillsStatus(true);
        $this->setFilterSlideDownDefaultStatus(true);

        $this->setConfigurableAreas([
            'toolbar-left-start' => [
                'components.table.button-create-new', [
                    'label' => '+ Mahasiswa',
                    'href' => route('student.create'),
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
        $students = Student::query()
            ->with(['user', 'major', 'major.faculty']) // Eager load anything
            // ->join() // Join some tables
            // ->select(); // Select some things
        ;

        $role = auth()->user()->role;
        if ($role === UserRole::ACADEMIC_FACULTY) {
            $faculty_id = auth()->user()->academic->academicable_id;
            $students = $students->whereHas('major.faculty', function ($query) use ($faculty_id) {
                $query->where('id', $faculty_id);
            });
        } else if ($role === UserRole::ACADEMIC_MAJOR) {
            $major_id = auth()->user()->academic->academicable_id;
            $students = $students->whereHas('major', function ($query) use ($major_id) {
                $query->where('id', $major_id);
            });
        }

        return $students;
    }

    public function columns(): array
    {
        return [
            Column::make("No", "id")->sortable(),
            // Column::make("User id", "user_id")->sortable(),
            Column::make("Nama", "user.name")
                ->format(
                    function ($value, $row, Column $column) {
                        $model = 'student';
                        return view('components.table.column-name-with-action', compact('value', 'row', 'column', 'model'));
                    }
                )
                ->sortable()->searchable(),
            // Column::make("User id", "user_id")->sortable(),
            Column::make("Fakultas", "major.faculty.name")->sortable()->collapseOnTablet(),
            Column::make("Jurusan", "major.name")->sortable()->collapseOnTablet(),
            Column::make("NIM", "user.username")->sortable()->deselected(),
            Column::make("SKS Tercapai", "current_credits")->sortable(),
            Column::make("Angkatan", "admission_year")->sortable(),
            Column::make("Tanggal Lahir", "date_of_birth")->sortable()->deselected(),
            Column::make("Jenis Kelamin", "gender")->sortable()->deselected(),
            Column::make("Status", "status")->sortable(),
            Column::make("Alamat", "address")->sortable()->collapseOnTablet()->deselected()->deselected(),
            Column::make("Nomor HP", "phone_number")->sortable()->deselected(),
            Column::make("Nama Wali", "guardian_name")->sortable()->deselected(),
            Column::make("Nomor HP Wali", "guardian_phone_number")->sortable()->deselected(),
            Column::make("Tipe Darah", "blood_type")->sortable()->deselected(),
            Column::make("Created at", "created_at")->sortable()->deselected(),
            Column::make("Updated at", "updated_at")->sortable()->deselected(),
        ];
    }
    public function filters(): array
    {
        return [
            $this->filter_faculty(),
            $this->filter_major(),
            $this->filter_status(),
            $this->filter_blood_type(),
            ...$this->filter_admission_year(),
            ...$this->filter_current_credits(),
        ];
    }

    public function filter_faculty()
    {
        $faculties = Faculty::query();

        $faculties = $faculties->with(["majors"]);

        $role = auth()->user()->role;
        if ($role === UserRole::ACADEMIC_FACULTY) {
            $faculty_id = auth()->user()->academic->academicable_id;
            $faculties = $faculties->where("id", $faculty_id);
        } else if ($role === UserRole::ACADEMIC_MAJOR) {
            $major_id = auth()->user()->academic->academicable_id;
            $faculties = $faculties->whereHas('majors', function ($query) use ($major_id) {
                $query->where('id', $major_id);
            });
        }


        $faculties = $faculties->orderBy('id');
        $faculties = $faculties->get();
        $faculties = $faculties->keyBy('id');
        $faculties = $faculties->map(fn ($faculty) => $faculty->name);
        $faculties = $faculties->toArray();

        return MultiSelectFilter::make('Fakultas', 'faculty')
            ->options($faculties)
            ->setFilterSlidedownColspan('2')
            ->filter(function (Builder $builder, $values) {
                $builder->whereIn('students.faculty_id', $values);
            });
    }
    public function filter_major()
    {
        $selectedFacultyIds = $_COOKIE["filter-student-faculty"] ?? "";

        $majors = Major::query();

        $majors = $majors->with(["faculty"]);

        $role = auth()->user()->role;
        if ($role === UserRole::ACADEMIC_FACULTY) {
            $major_id = auth()->user()->academic->academicable_id;
            $majors = $majors->whereHas('faculty', function ($query) use ($major_id) {
                $query->where('id', $major_id);
            });
        } else if ($role === UserRole::ACADEMIC_MAJOR) {
            $major_id = auth()->user()->academic->academicable_id;
            $majors = $majors->where("id", $major_id);
        }

        $majors = $majors->orderBy('id');
        $majors = $majors->get();
        $majors = $majors->keyBy('id');
        $majors = $majors->map(fn ($major) => $major->name);
        $majors = $majors->toArray();

        return MultiSelectFilter::make('Jurusan', 'major')
            ->options(
                $majors
            )
            ->setFilterSlidedownColspan('2')
            ->filter(function (Builder $builder, $value) {
                $builder->whereIn('students.major_id', $value);
            });
    }

    public function filter_status()
    {
        $status = [
            "" => "SEMUA",
        ];
        foreach (StudentStatus::values() as $key => $value) {
            $status[$value] = strtoupper($value);
        }

        return SelectFilter::make('Status')
            ->options($status)->filter(function (Builder $builder, string $value) {
                if ($value !== '') {
                    $builder->where('status', $value);
                }
            });
    }
    public function filter_blood_type()
    {
        $blood_type = [
            "" => "SEMUA",
            "A+" => "A+",
            "B+" => "B+",
            "AB+" => "AB+",
            "O+" => "O+",
            "A-" => "A-",
            "B-" => "B-",
            "AB-" => "AB-",
            "O-" => "O-",
        ];

        return SelectFilter::make('Tipe darah')
            ->options($blood_type)->filter(function (Builder $builder, string $value) {
                if ($value !== '') {
                    $builder->where('blood_type', $value);
                }
            });
    }

    public function filter_admission_year()
    {
        return [
            NumberFilter::make('MIN Angkatan', 'min-admission_year')->config([
                'min' => 1945,
                'max' => now()->year,
            ])
                ->setFilterDefaultValue('1945')
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('admission_year', '>=', $value);
                }),
            NumberFilter::make('MAX Angkatan', 'max-admission_year')->config([
                'min' => 1945,
                'max' => now()->year,
            ])
                ->setFilterDefaultValue(now()->year)
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('admission_year', '<=', $value);
                }),
        ];
    }
    public function filter_current_credits()
    {
        return [
            NumberFilter::make('MIN SKS', 'min-current_credits')->config([
                'min' => 0,
                'max' => 160,
            ])
                ->setFilterDefaultValue('0')
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('current_credits', '>=', $value);
                }),
            NumberFilter::make('MAX SKS', 'max-current_credits')->config([
                'min' => 0,
                'max' => 160,
            ])
                ->setFilterDefaultValue(160)
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('current_credits', '<=', $value);
                }),
        ];
    }
}
