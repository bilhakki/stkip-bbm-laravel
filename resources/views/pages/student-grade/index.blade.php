@push('head')
    @vite(['resources/js/alpine/pages/dashboard/student-grade/index.js'])
@endpush

<x-app-layout>

    <div
        x-data="pageDashboard($el)"
        x-init="pageDashboard"
    >
        <div class="py-1 sm:px-6 lg:px-0">
            <div class="card overflow-hidden">
                <div class="table-wrapper p-4">
                    <livewire:student-grade-table />
                </div>
            </div>
        </div>

        <x-pages.dashboard.student-grade.modal
            type="create"
            title="Tambah nilai baru"
            buttonLabel="Tambah"
            x-cloak
        />
        <x-pages.dashboard.student-grade.modal
            type="edit"
            title="Edit nilai"
            buttonLabel="Simpan"
            x-cloak
        />
    </div>
</x-app-layout>
