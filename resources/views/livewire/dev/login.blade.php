<div class="flex items-center space-x-2">
    <x-select class="select-sm" icon="o-user" :options="$this->users" wire:model="selectedUser"
              placeholder="Select an user"/>

    <x-button class="btn-sm" wire:click="login">Login</x-button>
</div>
