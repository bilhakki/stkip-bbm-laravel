@php
    $theme = $component->getTheme();
    $filterLayout = $component->getFilterLayout();
    $tableName = $component->getTableName();
@endphp
<div>
    @if ($filter->hasCustomFilterLabel() && !$filter->hasCustomPosition())
        @include($filter->getCustomFilterLabel(), [
            'filter' => $filter,
            'theme' => $theme,
            'filterLayout' => $filterLayout,
            'tableName' => $tableName,
        ])
    @elseif(!$filter->hasCustomPosition())
        <x-livewire-tables::tools.filter-label
            :filter="$filter"
            :theme="$theme"
            :filterLayout="$filterLayout"
            :tableName="$tableName"
        />
    @endif
    <div class="rounded-md shadow-sm">
        <select
            class="block w-full rounded-md border-gray-300 shadow-sm transition duration-150 ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
            id="{{ $tableName }}-filter-{{ $filter->getKey() }}@if ($filter->hasCustomPosition()) -{{ $filter->getCustomPosition() }} @endif"
            multiple
            wire:model.stop="{{ $tableName }}.filters.{{ $filter->getKey() }}"
            wire:key="{{ $tableName }}-filter-{{ $filter->getKey() }}@if ($filter->hasCustomPosition()) -{{ $filter->getCustomPosition() }} @endif"
        >
            @if ($filter->getFirstOption() != '')
                <option
                    @if ($filter->isEmpty($this)) selected @endif
                    value="all"
                >{{ $filter->getFirstOption() }}</option>
            @endif
            @foreach ($filter->getOptions() as $key => $value)
                @if (is_iterable($value))
                    <optgroup label="{{ $key }}">
                        @foreach ($value as $optionKey => $optionValue)
                            <option value="{{ $optionKey }}">{{ $optionValue }}</option>
                        @endforeach
                    </optgroup>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
