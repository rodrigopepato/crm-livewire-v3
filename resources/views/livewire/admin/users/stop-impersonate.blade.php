<div class="bg-yellow-300 px-4 p-1 text-sm text-yellow-900 hover:underline cursor-pointer" wire:click="stop">
    {{ __("You're impersonating :name, click here to stop the impersonation.", ['name' => $user->name]) }}
</div>
