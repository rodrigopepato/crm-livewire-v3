<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Notifications\UserDeletedNotification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{On, Rule};
use Livewire\Component;

class Delete extends Component
{
    public ?User $user = null;

    public bool $modal = false;

    #[Rule(['required', 'confirmed'])]
    public string $confirmation = 'DART VADER';

    public ?string $confirmation_confirmation = null;

    public function render(): View
    {
        return view('livewire.admin.users.delete');
    }

    #[On('user::deletion')]
    public function openConfirmationFor(int $userId): void
    {
        $this->user  = User::select('id', 'name')->find($userId);
        $this->modal = true;
    }

    public function destroy(): void
    {

        $this->validate();

        $this->user->delete();

        $this->user->notify(new UserDeletedNotification());

        $this->dispatch('user::deleted');

        $this->reset('modal');
    }
}
