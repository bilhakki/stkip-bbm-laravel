@props(['href', 'label', 'modal'])


<button
    class="inline-flex w-full min-w-fit justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600"
    type="button"
    x-data
    x-on:click.prevent="$dispatch('open-modal', '{{ $modal }}')"
>{{ __($label) }}</button>

<button
    class="inline-flex w-full min-w-fit justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600"
    type="button"
    wire:click="refreshTable"
    aria-label="Refresh Table"
><x-tni-refresh-alt-o class="w-5 h-5" /></button>
