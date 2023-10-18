@push('head')
    @vite(['resources/js/alpine/pages/dashboard/student/index.js'])
@endpush

<x-app-layout>
    <link
        href="https://unpkg.com/slim-select@latest/dist/slimselect.css"
        rel="stylesheet"
    >

    <div
        x-data="pagedashboardStudent($el)"
        x-init="pagedashboardStudent"
    >
        <div class="py-1 sm:px-6 lg:px-0">
            <div class="overflow-hidden card">
                <div class="table-wrapper p-4">
                    <livewire:student-table />
                </div>
            </div>
        </div>

        <x-pages.dashboard.student.modal
            type="create"
            title="Tambah mahasiswa baru"
            buttonLabel="Tambah"
            x-cloak
        />
        <x-pages.dashboard.student.modal
            type="edit"
            title="Edit mahasiswa"
            buttonLabel="Simpan"
            x-cloak
        />
    </div>
</x-app-layout>
