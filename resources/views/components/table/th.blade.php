@props([
    'header',
    'name'
])

<div wire:click="sortBy('{{ $name }}', '{{ $header['sortDirection'] == 'asc' ? 'desc' : 'asc' }}')"
     class="cursor-pointer">
    {{ $header['label'] }} @if($header['sortColumnBy'] == $name)
        <x-icon :name="$header['sortDirection'] == 'asc' ? 'o-chevron-up' : 'o-chevron-down'"
                class="h-3 w-3 ml-px"/>
    @endif
</div>
