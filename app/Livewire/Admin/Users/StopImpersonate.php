<?php

namespace App\Livewire\Admin\Users;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class StopImpersonate extends Component
{
    public function render(): View
    {
        return view('livewire.admin.users.stop-impersonate', [
            'user' => auth()->user(),
        ]);
    }

    public function stop(): void
    {
        session()->forget('impersonate');

        $this->redirect(route('admin.users'));
    }
}
