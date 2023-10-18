@props(['name', 'label', 'error' => null])

<div>
    <x-label
        for="{{ $name }}"
        value="{{ __($label) }}"
    />

    <x-input
        class="w-full"
        name="{{ $name }}"
        placeholder="{{ __($label) }}"
        {{ $attributes }}
    />

    <x-input-error
        class="mt-2"
        ::messages="{{ $error }}"
        for="{{ $name }}"
    />
</div>
