@push('head')
    @vite(['resources/js/alpine/pages/dashboard/season/index.js'])
@endpush

<x-app-layout>

    <div
        x-data="pageDashboard($el)"
        x-init="pageDashboard"
        
    >
        <div class="py-1 sm:px-6 lg:px-0">
            <div class="overflow-hidden card">
                <div class="table-wrapper p-4">
                    <livewire:season-table />
                </div>
            </div>
        </div>

        <x-pages.dashboard.season.modal
            type="create"
            title="Tambah semester baru"
            buttonLabel="Tambah"
            x-cloak
        />
        <x-pages.dashboard.season.modal
            type="edit"
            title="Edit semester"
            buttonLabel="Simpan"
            x-cloak
        />
    </div>
</x-app-layout>
