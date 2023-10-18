@props(['row', 'value', 'column', 'model'])

<div class="mb-2 w-full">
    {{ $value }}
</div>
<div class="flex items-center space-x-2 text-xs">
    <a
        href="{{ route("$model.edit", $row->id) }}"
        x-data
        x-on:click.prevent="
        $dispatch('open-modal', 'edit-modal')
        data_id = '$row->id'
        urlEdit = '{{ route("$model.edit", $row->id) }}'
        urlUpdate = '{{ route("$model.update", $row->id) }}'
        "
    >Edit</a>
    <span>|</span>
    <a
        href="{{ route("$model.destroy", $row->id) }}"
        onclick="deleteTableRow(event)"
    >Hapus</a>
</div>
