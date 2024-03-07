<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Livewire\Attributes\{Rule, Validate};
use Livewire\Form as BaseForm;

class Form extends BaseForm
{
    public ?Customer $customer = null;

    #[Rule(['required', 'min:3', 'max:255'])]
    public string $name = '';

    #[Rule(['required_without:phone', 'email', 'unique:customers'])]
    public string $email = '';

    #[Rule(['required_without:email', 'unique:customers'])]
    public string $phone = '';

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;

        $this->name  = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
    }

    public function create(): void
    {
        $this->validate();

        Customer::create([
            'type'  => 'customer',
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
    }

    public function update(): void
    {
        $this->validate();

        $this->customer->name  = $this->name;
        $this->customer->email = $this->email;
        $this->customer->phone = $this->phone;

        $this->customer->update();
    }
}
