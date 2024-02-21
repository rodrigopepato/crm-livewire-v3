<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public ?User $user = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.users.show');
    }

    #[On('user::show')]
    public function loadUser(int $id): void
    {
        $this->user  = User::withTrashed()->find($id);
        $this->modal = true;

    }
}
