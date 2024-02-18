<div>
    <x-header title="Users" separator/>


    <div class="mb-4 flex space-x-4">
        <div class="w-1/3">
            <x-input
                icon="o-magnifying-glass"
                class="input-sm "
                placeholder="Search by email and name"
                wire:model.live="search"
            />
        </div>
        <x-select class="select-sm"> // Permission
            <option value="">asldkjasd</option>
        </x-select>
    </div>

    <x-table :headers="$this->headers" :rows="$this->users">
        @scope('cell_permissions', $user)
        @foreach($user->permissions as $permission)
            <x-badge :value="$permission->key" class="badge-primary"/>
        @endforeach
        @endscope
        @scope('actions', $user)
        <x-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm"/>
        @endscope
    </x-table>
</div>
