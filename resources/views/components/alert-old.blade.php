@props(['variant' => 'default', 'message'])

@php
    $color = 'primary';
    switch ($variant) {
        case 'danger':
            $color = 'red';
            break;
    
        case 'warning':
            $color = 'yellow';
            break;
    
        default:
            $color = 'primary';
            break;
    }
@endphp


<div
    class="bg-{{ $color }}-50 text-{{ $color }}-800 dark:text-{{ $color }}-400 mb-4 flex items-center rounded-lg p-4 dark:bg-background-900"
    id=""
    role="alert"
>

    <svg
        class="h-4 w-4 flex-shrink-0"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="currentColor"
        viewBox="0 0 20 20"
    >
        <path
            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
        />
    </svg>
    <span class="sr-only">Info</span>
    <div
        class="ml-3 text-sm font-medium"
        x-data="{ message: @JS($message) }"
        x-text="message"
    ></div>

    <button
        class="bg-{{ $color }}-50 text-{{ $color }}-500 hover:bg-{{ $color }}-200 focus:ring-{{ $color }}-400 dark:text-{{ $color }}-400 -mx-1.5 -my-1.5 ml-auto inline-flex h-8 w-8 items-center justify-center rounded-lg p-1.5 focus:ring-2 dark:bg-background-800 dark:hover:bg-background-700"
        data-dismiss-target="#alert-2"
        type="button"
        aria-label="Close"
    >
        <span class="sr-only">Close</span>
        <svg
            class="h-3 w-3"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 14 14"
        >
            <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
            />
        </svg>
    </button>
</div>
