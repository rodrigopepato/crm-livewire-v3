<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Update extends Component
{
    public Customer $customer;

    public bool $modal = false;

    public function rules(): array
    {
        return [
            'customer.name'  => ['required', 'min:3', 'max:255'],
            'customer.email' => ['required_without:phone', 'email', 'unique:customers,email'],
            'customer.phone' => ['required_without:email', 'unique:customers,phone'],
        ];
    }
    public function render(): View
    {
        return view('livewire.customers.update');
    }

    public function save(): void
    {
        $this->validate();

        $this->customer->update();

    }
}
