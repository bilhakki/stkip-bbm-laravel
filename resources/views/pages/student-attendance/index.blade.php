@push('head')
    @vite(['resources/js/alpine/pages/dashboard/student-attendance/index.js'])
@endpush

<x-app-layout>

    <div
        x-data="pageDashboard($el)"
        x-init="pageDashboard"
        
    >
        <div class="py-1 sm:px-6 lg:px-0">
            <div class="overflow-hidden card">
                <div class="table-wrapper p-4">
                    <livewire:student-attendance-table />
                </div>
            </div>
        </div>

        <x-pages.dashboard.student-attendance.modal
            type="create"
            title="Tambah absen baru"
            buttonLabel="Tambah"
            x-cloak
        />
        <x-pages.dashboard.student-attendance.modal
            type="edit"
            title="Edit absen"
            buttonLabel="Simpan"
            x-cloak
        />
    </div>
</x-app-layout>
