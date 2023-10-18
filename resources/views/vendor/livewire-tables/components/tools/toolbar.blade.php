@aware(['component'])

@php
    $theme = $component->getTheme();
@endphp

@if ($component->hasConfigurableAreaFor('before-toolbar'))
    @include(
        $component->getConfigurableAreaFor('before-toolbar'),
        $component->getParametersForConfigurableArea('before-toolbar'))
@endif

<div class="mb-4 px-4 md:flex md:justify-between md:p-0">
    <div class="mb-4 w-full space-y-4 md:mb-0 md:flex md:w-2/4 md:space-x-2 md:space-y-0">
        @if ($component->hasConfigurableAreaFor('toolbar-left-start'))
            @include(
                $component->getConfigurableAreaFor('toolbar-left-start'),
                $component->getParametersForConfigurableArea('toolbar-left-start'))
        @endif

        @if ($component->reorderIsEnabled())
            <button
                class="inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition duration-150 ease-in-out hover:text-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 active:bg-gray-50 active:text-gray-800 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 md:w-auto"
                wire:click="{{ $component->currentlyReorderingIsEnabled() ? 'disableReordering' : 'enableReordering' }}"
                type="button"
            >
                @if ($component->currentlyReorderingIsEnabled())
                    @lang('Done Reordering')
                @else
                    @lang('Reorder')
                @endif
            </button>
        @endif

        @if ($component->searchIsEnabled() && $component->searchVisibilityIsEnabled())
            <div class="flex rounded-md shadow-sm">
                <input
                    class="@if ($component->hasSearch()) rounded-none rounded-l-md focus:ring-0 focus:border-gray-300 @else focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md @endif block w-full rounded-md border-gray-300 shadow-sm transition duration-150 ease-in-out dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm sm:leading-5"
                    wire:model{{ $component->getSearchOptions() }}="{{ $component->getTableName() }}.search"
                    placeholder="{{ __('Search') }}"
                    type="text"
                />

                @if ($component->hasSearch())
                    <span
                        class="inline-flex cursor-pointer items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-50 px-3 text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 sm:text-sm"
                        wire:click.prevent="clearSearch"
                    >
                        <svg
                            class="h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </span>
                @endif
            </div>
        @endif

        @if ($component->filtersAreEnabled() && $component->filtersVisibilityIsEnabled() && $component->hasVisibleFilters())
            <div
                class="relative block text-left md:inline-block"
                @if ($component->isFilterLayoutPopover()) x-data="{ open: false, childElementOpen: false  }"
                        x-on:keydown.escape.stop="if (!childElementOpen) { open = false }"
                        x-on:mousedown.away="if (!childElementOpen) { open = false }" @endif
            >
                <div>
                    <button
                        class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600"
                        type="button"
                        @if ($component->isFilterLayoutPopover()) x-on:click="open = !open"
                                aria-haspopup="true"
                                x-bind:aria-expanded="open"
                                aria-expanded="true" @endif
                        @if ($component->isFilterLayoutSlideDown()) x-on:click="filtersOpen = !filtersOpen" @endif
                    >
                        @lang('Filters')

                        @if ($count = $component->getFilterBadgeCount())
                            <span
                                class="ml-1 inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium capitalize leading-4 text-indigo-800 dark:bg-indigo-200 dark:text-indigo-900"
                            >
                                {{ $count }}
                            </span>
                        @endif

                        <svg
                            class="-mr-1 ml-2 h-5 w-5"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                            />
                        </svg>
                    </button>
                </div>

                @if ($component->isFilterLayoutPopover())
                    <div
                        class="absolute left-0 z-50 mt-2 w-full origin-top-left divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:divide-gray-600 dark:bg-gray-700 dark:text-white md:w-56"
                        x-cloak
                        x-show="open"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        role="menu"
                        aria-orientation="vertical"
                        aria-labelledby="filters-menu"
                    >
                        @foreach ($component->getVisibleFilters() as $filter)
                            <div
                                class="py-1"
                                role="none"
                            >
                                <div
                                    class="block space-y-1 px-4 py-2 text-sm text-gray-700"
                                    id="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}-wrapper"
                                    role="menuitem"
                                >
                                    {{ $filter->render($component) }}
                                </div>
                            </div>
                        @endforeach

                        @if ($component->hasAppliedVisibleFiltersWithValuesThatCanBeCleared())
                            <div
                                class="block px-4 py-3 text-sm text-gray-700 dark:text-white"
                                role="menuitem"
                            >
                                <button
                                    class="inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:border-gray-500"
                                    wire:click.prevent="setFilterDefaults"
                                    x-on:click="open = false"
                                    type="button"
                                >
                                    @lang('Clear')
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        @if ($component->hasConfigurableAreaFor('toolbar-left-end'))
            @include(
                $component->getConfigurableAreaFor('toolbar-left-end'),
                $component->getParametersForConfigurableArea('toolbar-left-end'))
        @endif
    </div>

    <div class="space-y-4 md:flex md:items-center md:space-x-2 md:space-y-0">
        @if ($component->hasConfigurableAreaFor('toolbar-right-start'))
            @include(
                $component->getConfigurableAreaFor('toolbar-right-start'),
                $component->getParametersForConfigurableArea('toolbar-right-start'))
        @endif

        @if ($component->showBulkActionsDropdownAlpine())
            <div
                class="mb-4 w-full md:mb-0 md:w-auto"
                x-cloak
                x-show="(selectedItems.length > 0 || alwaysShowBulkActions)"
            >
                <div
                    class="relative z-10 inline-block w-full text-left md:w-auto"
                    x-data="{ open: false, childElementOpen: false }"
                    @keydown.window.escape="if (!childElementOpen) { open = false }"
                    x-on:click.away="if (!childElementOpen) { open = false }"
                >
                    <div>
                        <span class="rounded-md shadow-sm">
                            <button
                                class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600"
                                x-on:click="open = !open"
                                type="button"
                                aria-haspopup="true"
                                x-bind:aria-expanded="open"
                                aria-expanded="true"
                            >
                                @lang('Bulk Actions')

                                <svg
                                    class="-mr-1 ml-2 h-5 w-5"
                                    x-description="Heroicon name: chevron-down"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </button>
                        </span>
                    </div>

                    <div
                        class="absolute right-0 z-50 mt-2 w-full origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none md:w-48"
                        x-cloak
                        x-show="open"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                    >
                        <div class="shadow-xs rounded-md bg-white dark:bg-gray-700 dark:text-white">
                            <div
                                class="py-1"
                                role="menu"
                                aria-orientation="vertical"
                            >
                                @foreach ($component->getBulkActions() as $action => $title)
                                    <button
                                        class="block flex w-full items-center space-x-2 px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900 focus:outline-none dark:text-white dark:hover:bg-gray-600"
                                        wire:click="{{ $action }}"
                                        wire:key="bulk-action-{{ $action }}-{{ $component->getTableName() }}"
                                        type="button"
                                        role="menuitem"
                                    >
                                        <span>{{ $title }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($component->columnSelectIsEnabled())
            <div
                class="@if ($component->getColumnSelectIsHiddenOnMobile()) hidden sm:block @elseif ($component->getColumnSelectIsHiddenOnTablet()) hidden md:block @endif mb-4 w-full md:mb-0 md:ml-2 md:w-auto">
                <div
                    class="relative inline-block w-full text-left md:w-auto"
                    x-data="{ open: false, childElementOpen: false }"
                    @keydown.window.escape="if (!childElementOpen) { open = false }"
                    x-on:click.away="if (!childElementOpen) { open = false }"
                    wire:key="column-select-button-{{ $component->getTableName() }}"
                >
                    <div>
                        <span class="rounded-md shadow-sm">
                            <button
                                class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600"
                                x-on:click="open = !open"
                                type="button"
                                aria-haspopup="true"
                                x-bind:aria-expanded="open"
                                aria-expanded="true"
                            >
                                @lang('Columns')

                                <svg
                                    class="-mr-1 ml-2 h-5 w-5"
                                    x-description="Heroicon name: chevron-down"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </button>
                        </span>
                    </div>

                    <div
                        class="absolute right-0 z-50 mt-2 w-full origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none md:w-48"
                        x-cloak
                        x-show="open"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                    >
                        <div class="shadow-xs rounded-md bg-white dark:bg-gray-700 dark:text-white">
                            <div
                                class="p-2"
                                role="menu"
                                aria-orientation="vertical"
                                aria-labelledby="column-select-menu"
                            >
                                <div>
                                    <label
                                        class="inline-flex items-center px-2 py-1 disabled:cursor-wait disabled:opacity-50"
                                        wire:loading.attr="disabled"
                                    >
                                        <input
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm transition duration-150 ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:cursor-wait disabled:opacity-50 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-600 dark:focus:bg-gray-600"
                                            @if ($component->allDefaultVisibleColumnsAreSelected()) checked
                                                    wire:click="deselectAllColumns"
                                                @else
                                                    unchecked
                                                    wire:click="selectAllColumns" @endif
                                            wire:loading.attr="disabled"
                                            type="checkbox"
                                        />
                                        <span class="ml-2">{{ __('All Columns') }}</span>
                                    </label>
                                </div>
                                @foreach ($component->getColumns() as $column)
                                    @if ($column->isVisible() && $column->isSelectable())
                                        <div
                                            wire:key="columnSelect-{{ $loop->index }}-{{ $component->getTableName() }}">
                                            <label
                                                class="inline-flex items-center px-2 py-1 disabled:cursor-wait disabled:opacity-50"
                                                wire:loading.attr="disabled"
                                                wire:target="selectedColumns"
                                            >
                                                <input
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm transition duration-150 ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:cursor-wait disabled:opacity-50 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-600 dark:focus:bg-gray-600"
                                                    wire:model="selectedColumns"
                                                    wire:target="selectedColumns"
                                                    wire:loading.attr="disabled"
                                                    type="checkbox"
                                                    value="{{ $column->getSlug() }}"
                                                />
                                                <span class="ml-2">{{ $column->getTitle() }}</span>
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($component->paginationIsEnabled() && $component->perPageVisibilityIsEnabled())
            <div>
                <select
                    class="block w-full rounded-md border-gray-300 shadow-sm transition duration-150 ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm sm:leading-5"
                    id="perPage"
                    wire:model="perPage"
                >
                    @foreach ($component->getPerPageAccepted() as $item)
                        <option
                            value="{{ $item }}"
                            wire:key="per-page-{{ $item }}-{{ $component->getTableName() }}"
                        >
                            {{ $item === -1 ? __('All') : $item }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        @if ($component->hasConfigurableAreaFor('toolbar-right-end'))
            @include(
                $component->getConfigurableAreaFor('toolbar-right-end'),
                $component->getParametersForConfigurableArea('toolbar-right-end'))
        @endif
    </div>
</div>

@if (
    $component->filtersAreEnabled() &&
        $component->filtersVisibilityIsEnabled() &&
        $component->hasVisibleFilters() &&
        $component->isFilterLayoutSlideDown())
    <div
        x-cloak
        x-show="filtersOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0"
        x-transition:enter-end="transform opacity-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100"
        x-transition:leave-end="transform opacity-0"
    >

        @foreach ($component->getFiltersByRow() as $filterRowIndex => $filterRow)
            <div
                class="mb-6 grid grid-cols-12 gap-6 px-4 md:p-0"
                row="{{ $filterRowIndex }}"
                @class([
                    'col-span-12  sm:col-span-12 sm:col-span-6 sm:col-span-3 sm:col-span-1 md:col-span-12 md:col-span-6 md:col-span-3 md:col-span-1 lg:col-span-12 lg:col-span-6 lg:col-span-3 lg:col-span-1 row-start-1 row-start-2 row-start-3 row-start-4 row-start-5 row-start-6 row-start-7 row-start-8 row-start9' =>
                        true == false,
                ])
            >
                @foreach ($filterRow as $filter)
                    <div
                        id="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}-wrapper"
                        @class([
                            'space-y-1 col-span-12',
                            'sm:col-span-6 md:col-span-4 lg:col-span-2' => !$filter->hasFilterSlidedownColspan(),
                            'sm:col-span-12 md:col-span-8 lg:col-span-4' =>
                                $filter->hasFilterSlidedownColspan() &&
                                $filter->getFilterSlidedownColspan() == 2,
                            'sm:col-span-9 md:col-span-4 lg:col-span-3' =>
                                $filter->hasFilterSlidedownColspan() &&
                                $filter->getFilterSlidedownColspan() == 3,
                        ])
                    >
                        {{ $filter->render($component) }}
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endif


@if ($component->hasConfigurableAreaFor('after-toolbar'))
    @include(
        $component->getConfigurableAreaFor('after-toolbar'),
        $component->getParametersForConfigurableArea('after-toolbar'))
@endif
