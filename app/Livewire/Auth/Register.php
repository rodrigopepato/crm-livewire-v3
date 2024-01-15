<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Register extends Component
{
    public ?string $name;

    public ?string $email;

    public ?string $email_confimation;

    public ?string $password;

    public function render(): View
    {
        return view('livewire.auth.register');
    }

    public function submit(): void
    {
        User::query()->create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ]);

    }
}
