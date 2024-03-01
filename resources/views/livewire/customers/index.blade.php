<div>
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
    </div>

    <x-table :headers="$this->headers" :rows="$this->customers">
    </x-table>

    {{ $this->customers->links(data: ['scrollTo' => false]) }}
</div>
