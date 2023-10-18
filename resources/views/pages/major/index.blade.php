@push('head')
    @vite(['resources/js/alpine/pages/dashboard/major/index.js'])
@endpush

<x-app-layout>

    <div
        x-data="pageDashboard($el)"
        x-init="pageDashboard"
        
    >
        <div class="py-1 sm:px-6 lg:px-0">
            <div class="overflow-hidden card">
                <div class="table-wrapper p-4">
                    <livewire:major-table />
                </div>
            </div>
        </div>

        <x-pages.dashboard.major.modal
            type="create"
            title="Tambah jurusan baru"
            buttonLabel="Tambah"
            :faculties="$faculties"
            x-cloak
        />
        <x-pages.dashboard.major.modal
            type="edit"
            title="Edit jurusan"
            buttonLabel="Simpan"
            :faculties="$faculties"
            x-cloak
        />
    </div>
</x-app-layout>
