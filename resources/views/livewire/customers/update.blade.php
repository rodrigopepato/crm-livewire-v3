<x-drawer wire:model="modal" title="Updating Customer" class="w-1/3 p-4" right>
    <x-form wire:submit="save" id="update-customer-form">
        <hr class="my-5"/>
        <div class="space-y-2">
            <x-input label="Name" wire:model="form.name"/>
            <x-input label="Email" wire:model="form.email"/>
            <x-input label="Phone" wire:model="form.phone"/>
        </div>
        <x-slot:actions>
            <x-button label="Cancel" @click="$wire.modal = false"/>
            <x-button label="Save" type="submit" form="update-customer-form"/>
        </x-slot:actions>
    </x-form>
</x-drawer>
