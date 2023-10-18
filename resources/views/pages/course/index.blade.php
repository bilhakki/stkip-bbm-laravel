@push('head')
    @vite(['resources/js/alpine/pages/dashboard/course/index.js'])
@endpush

<x-app-layout>

    <div
        x-data="pageDashboard($el)"
        x-init="pageDashboard"
        
    >
        <div class="py-1 sm:px-6 lg:px-0">
            <div class="overflow-hidden card">
                <div class="table-wrapper p-4">
                    <livewire:course-table />
                </div>
            </div>
        </div>

        <x-pages.dashboard.course.modal
            type="create"
            title="Tambah mata kuliah baru"
            buttonLabel="Tambah"
            x-cloak
        />
        <x-pages.dashboard.course.modal
            type="edit"
            title="Edit mata kuliah"
            buttonLabel="Simpan"
            x-cloak
        />
    </div>
</x-app-layout>
