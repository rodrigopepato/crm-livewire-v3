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

    </div>

    <x-table :headers="$this->headers" :rows="$this->users">
        
        @scope('cell_permissions', $user)

            @foreach($user->permissions as $permission)
                <x-badge :value="$permission->key" class="badge-primary"/>
            @endforeach
        @endscope

        @scope('actions', $user)
            @unless($user->trashed())
                <x-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm"/>
            @else
                <x-button icon="o-arrow-path-rounded-square" wire:click="restore({{ $user->id }})" spinner
                      class="btn-sm btn-success btn-ghost"/>
            @endunless
        @endscope

    </x-table>
</div>
