<?php

namespace App\Http\Livewire;

use App\Enums\UserRole;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\TuitionPayment;
use Illuminate\Database\Eloquent\Builder;

class TuitionPaymentTable extends DataTableComponent
{
    protected $model = TuitionPayment::class;

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
                    'label' => '+ Pembayaran SPP',
                    'href' => route('tuition-payment.create'),
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
        $tuitionPayments = TuitionPayment::query()
            ->with(['student.major', 'student.major.faculty']) // Eager load anything
            // ->join() // Join some tables
            // ->select(); // Select some things
        ;

        $role = auth()->user()->role;
        if ($role === UserRole::ACADEMIC_FACULTY) {
            $faculty_id = auth()->user()->academic->academicable_id;
            $tuitionPayments = $tuitionPayments->whereHas('student.major.faculty', function ($query) use ($faculty_id) {
                $query->where('id', $faculty_id);
            });
        } else if ($role === UserRole::ACADEMIC_MAJOR) {
            $major_id = auth()->user()->academic->academicable_id;
            $tuitionPayments = $tuitionPayments->whereHas('student.major', function ($query) use ($major_id) {
                $query->where('id', $major_id);
            });
        }

        return $tuitionPayments;
    }

    public function columns(): array
    {
        return [
            Column::make("No", "id")->sortable(),
            Column::make("Fak", "student.major.faculty.name")->sortable(),
            Column::make("Jur", "student.major.name")->sortable(),
            Column::make("Nama", "student.user.name")
                ->format(
                    function ($value, $row, Column $column) {
                        $model = 'tuition-payment';
                        return view('components.table.column-name-with-action', compact('value', 'row', 'column', 'model'));
                    }
                )
                ->sortable()->searchable(),
            Column::make("Semester", "season.name")->sortable(),
            Column::make("Tanggal", "payment_at")->sortable(),
            Column::make("Status", "status")->sortable(),
            Column::make("SPP", "amount")->format(function ($value, $row, Column $column) {
                return "Rp. " . number_format($value, 0, ',', '.');
            })->sortable()->deselected(),
            Column::make("Receipt number", "receipt_number")->sortable()->deselected(),

            Column::make("Created at", "created_at")->sortable()->deselected(),
            Column::make("Updated at", "updated_at")->sortable()->deselected(),
        ];
    }
}
