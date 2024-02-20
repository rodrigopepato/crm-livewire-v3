<div>
    <x-header title="Users" separator/>


    <div class="mb-4 flex space-x-4">
        <div class="w-1/3">
            <x-input
                label="Search by email or name"
                icon="o-magnifying-glass"
                wire:model.live="search"
            />
        </div>
        
        <x-choices
            Label="Search by permissions"
            wire:model.live="search_permissions"
            :options="$permissionsToSearch"
            option-label="key"
            search-function="filterPermissions"
            searchable
            no-result-text="Nothing here"
        />

        <x-checkbox
            label="Show Deleted Users"
            wire:model.live="search_trash"
            class="checkbox-primary"
            right tight/>

        <x-select
            wire:model.live="perPage"
            :options="[['id'=>5,'name'=>5], ['id'=>15,'name'=>15], ['id'=>25,'name'=>25], ['id'=>50,'name'=>50]]"
            label="Records Per Page"
        />

    </div>

    <x-table :headers="$this->headers" :rows="$this->users">

        @scope('header_id', $header)
        <x-table.th :$header name="id"/>
        @endscope

        @scope('header_name', $header)
        <x-table.th :$header name="name"/>
        @endscope

        @scope('header_email', $header)
        <x-table.th :$header name="email"/>
        @endscope
        
        @scope('cell_permissions', $user)

            @foreach($user->permissions as $permission)
                <x-badge :value="$permission->key" class="badge-primary"/>
            @endforeach
        @endscope

        @scope('actions', $user)
        @can(App\Models\Can::BE_AN_ADMIN->value)
            @unless($user->trashed())
                <livewire:admin.users.delete
                    :$user wire:key="delete-btn-{{ $user->id }}"
                />
            @else
                <x-button icon="o-arrow-path-rounded-square" wire:click="restore({{ $user->id }})" spinner
                          class="btn-sm btn-success btn-ghost"/>
            @endunless
        @endcan
        @endscope

    </x-table>

    {{ $this->users->links() }}
    
</div>
