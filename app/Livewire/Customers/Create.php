<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{On, Rule};
use Livewire\Component;

class Create extends Component
{
    #[Rule(['required', 'min:3', 'max:255'])]
    public string $name = '';

    #[Rule(['required_without:phone', 'email', 'unique:customers'])]
    public string $email = '';

    #[Rule(['required_without:email', 'unique:customers'])]
    public string $phone = '';

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.customers.create');
    }

    #[On('customer::create')]
    public function open(): void
    {
        $this->resetErrorBag();
        $this->modal = true;
    }

    public function save(): void
    {
        $this->validate();

        Customer::create([
            'type'  => 'customer',
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
    }
}
