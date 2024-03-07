<?php

namespace App\Livewire\Customers;

use App\Livewire\Forms\Form;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    public Form $form;

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

    #[On('customer::update')]
    public function load(int $id): void
    {
        $customer = Customer::find($id);
        $this->form->setCustomer($customer);

        $this->form->resetErrorBag();
        $this->modal = true;
    }

    public function save(): void
    {
        $this->form->update();

        $this->modal = false;
        $this->dispatch('customer::reload')->to('customers.index');

    }
}
