<?php

namespace App\Livewire\Admin;

use App\Models\Can;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public function mount(): void
    {
        $this->authorize(Can::BE_AN_ADMIN->value);
    }

    public function render(): View
    {
        return view('livewire.admin.dashboard');
    }
}
