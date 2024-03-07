<div>
    <x-header title="Opportunities" separator/>

    <div class="mb-4 flex items-end justify-between">
        <div class="w-full flex space-x-4 items-end">
            <div class="w-1/3">
                <x-input
                    label="Search by title"
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
                label="Show Archived Opportunities"
                wire:model.live="search_trash"
                class="checkbox-primary"
                right tight/>
        </div>

        <x-button @click="$dispatch('opportunity::create')" label="New Customer" icon="o-plus"/>
    </div>

    <x-table :headers="$this->headers" :rows="$this->items">
        @scope('header_id', $header)
        <x-table.th :$header name="id"/>
        @endscope

        @scope('header_title', $header)
        <x-table.th :$header name="title"/>
        @endscope

        @scope('header_status', $header)
        <x-table.th :$header name="status"/>
        @endscope

        @scope('header_amount', $header)
        <x-table.th :$header name="amount"/>
        @endscope

        @scope('actions', $opportunity)
        <div class="flex items-center space-x-2">
            <x-button
                id="update-btn-{{ $opportunity->id }}"
                wire:key="update-btn-{{ $opportunity->id }}"
                icon="o-pencil"
                @click="$dispatch('opportunity::update', { id: {{ $opportunity->id }}})"
                spinner class="btn-sm"
            />

            @unless($opportunity->trashed())
                <x-button
                    id="archive-btn-{{ $opportunity->id }}"
                    wire:key="archive-btn-{{ $opportunity->id }}"
                    icon="o-trash"
                    @click="$dispatch('opportunity::archive', { id: {{ $opportunity->id }}})"
                    spinner class="btn-sm"
                />
            @else
                <x-button
                    id="restore-btn-{{ $opportunity->id }}"
                    wire:key="restore-btn-{{ $opportunity->id }}"
                    icon="o-arrow-uturn-left"
                    @click="$dispatch('opportunity::restore', { id: {{ $opportunity->id }}})"
                    spinner class="btn-sm"
                />
            @endunless
        </div>
        @endscope
    </x-table>

    {{ $this->items->links(data: ['scrollTo' => false]) }}

    <livewire:opportunities.create/>
    <livewire:opportunities.update/>
    <livewire:opportunities.archive/>
    <livewire:opportunities.restore/>
</div>
