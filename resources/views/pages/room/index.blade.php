@push('head')
    @vite(['resources/js/alpine/pages/dashboard/room/index.js'])
@endpush

<x-app-layout>

    <div
        x-data="pageDashboard($el)"
        x-init="pageDashboard"
        
    >
        <div class="py-1 sm:px-6 lg:px-0">
            <div class="overflow-hidden card">
                <div class="table-wrapper p-4">
                    <livewire:room-table />
                </div>
            </div>
        </div>

        <x-pages.dashboard.room.modal
            type="create"
            title="Tambah ruangan baru"
            buttonLabel="Tambah"
            x-cloak
        />
        <x-pages.dashboard.room.modal
            type="edit"
            title="Edit ruangan"
            buttonLabel="Simpan"
            x-cloak
        />
    </div>
</x-app-layout>
