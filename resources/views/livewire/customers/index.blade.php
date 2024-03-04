<div>
    <livewire:customers.archive/>
    <x-header title="Customers" separator/>
    <div class="mb-4 flex space-x-4">
        <div class="w-1/3">
            <x-input
                label="Search by email or name"
                icon="o-magnifying-glass"
                wire:model.live="search"
            />
        </div>
        <x-select
            wire:model.live="perPage"
            :options="[['id'=>5,'name'=>5], ['id'=>15,'name'=>15], ['id'=>25,'name'=>25], ['id'=>50,'name'=>50]]"
            label="Records Per Page"
        />

        <x-checkbox
            label="Show Archived Customers"
            wire:model.live="search_trash"
            class="checkbox-primary"
            right tight/>
    </div>

    <x-table :headers="$this->headers" :rows="$this->items">

        @scope('header_id', $header)
        <x-table.th :$header name="id"/>
        @endscope

        @scope('header_name', $header)
        <x-table.th :$header name="name"/>
        @endscope

        @scope('header_email', $header)
        <x-table.th :$header name="email"/>
        @endscope

        @scope('actions', $customer)
        <div class="flex items-center space-x-2">
            <x-button
                id="archive-btn-{{ $customer->id }}"
                wire:key="archive-btn-{{ $customer->id }}"
                icon="o-trash"
                @click="$dispatch('customer::archive', { id: {{ $customer->id }}})"
                spinner class="btn-sm"
            />
        </div>
        @endscope
        
    </x-table>
    {{ $this->items->links(data: ['scrollTo' => false]) }}
</div>
