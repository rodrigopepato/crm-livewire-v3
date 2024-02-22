<?php

namespace App\Livewire\Dev;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Login extends Component
{
    public ?int $selectedUser = null;

    public function render(): View
    {
        return view('livewire.dev.login');
    }

    #[Computed]
    public function users(): Collection
    {
        return User::all();
    }
}
