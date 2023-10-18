@aware(['component'])
@props(['filter'])
@php
    $theme = $component->getTheme();
@endphp

<span
    class="costum-pill inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium capitalize leading-4 text-indigo-800 dark:bg-indigo-200 dark:text-indigo-900"
    wire:key="{{ $component->getTableName() }}-filter-pill-{{ $filter->getKey() }}"
>
    {{ $filter->getFilterPillTitle() }} - ({{ $filter->getFilterPillValue($value) }})

    <button
        class="ml-0.5 inline-flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:bg-indigo-500 focus:text-white focus:outline-none"
        wire:click="resetFilter('{{ $filter->getKey() }}')"
        type="button"
    >
        <span class="sr-only">@lang('Remove filter option')</span>
        <svg
            class="h-2 w-2"
            stroke="currentColor"
            fill="none"
            viewBox="0 0 8 8"
        >
            <path
                stroke-linecap="round"
                stroke-width="1.5"
                d="M1 1l6 6m0-6L1 7"
            />
        </svg>
    </button>
</span>
