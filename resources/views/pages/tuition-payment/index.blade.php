@push('head')
    @vite(['resources/js/alpine/pages/dashboard/tuition-payment/index.js'])
@endpush

<x-app-layout>

    <div
        x-data="pageDashboard($el)"
        x-init="pageDashboard"
        
    >
        <div class="py-1 sm:px-6 lg:px-0">
            <div class="overflow-hidden card">
                <div class="table-wrapper p-4">
                    <livewire:tuition-payment-table />
                </div>
            </div>
        </div>

        <x-pages.dashboard.tuition-payment.modal
            type="create"
            title="Tambah SPP baru"
            buttonLabel="Tambah"
            x-cloak
        />
        <x-pages.dashboard.tuition-payment.modal
            type="edit"
            title="Edit SPP"
            buttonLabel="Simpan"
            x-cloak
        />
    </div>
</x-app-layout>
