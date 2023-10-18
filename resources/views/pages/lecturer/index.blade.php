@push('head')
    @vite(['resources/js/alpine/pages/dashboard/lecturer/index.js'])
@endpush

<x-app-layout>

    <div
        x-data="pageDashboard($el)"
        x-init="pageDashboard"
        
    >
        <div class="py-1 sm:px-6 lg:px-0">
            <div class="overflow-hidden card">
                <div class="table-wrapper p-4">
                    <livewire:lecturer-table />
                </div>
            </div>
        </div>

        <x-pages.dashboard.lecturer.modal
            type="create"
            title="Tambah dosen baru"
            buttonLabel="Tambah"
            x-cloak
        />
        <x-pages.dashboard.lecturer.modal
            type="edit"
            title="Edit dosen"
            buttonLabel="Simpan"
            x-cloak
        />
    </div>
</x-app-layout>
