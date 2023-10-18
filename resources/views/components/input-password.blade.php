@props(['disabled' => false])

<div
    class="relative overflow-hidden rounded-md"
    x-data="{
        show: false
    }"
>
    <input
        {{ $disabled ? 'disabled' : '' }}
        :type="show ? 'text' : 'password'"
        {!! $attributes->merge([
            'class' =>
                'border-background-300 dark:border-background-700 dark:bg-background-900 dark:text-background-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm ',
        ]) !!}
    >
    <button
        class="absolute inset-y-0 right-0 flex items-center px-2 pr-3 opacity-80"
        type="button"
        x-on:click="show = !show"
    >
        <x-bx-show
            class="h-6 w-6"
            ::class="!show && 'hidden'"
        />
        <x-tni-eye-closed-o
            class="h-6 w-6"
            ::class="show && 'hidden'"
        />
    </button>
</div>
