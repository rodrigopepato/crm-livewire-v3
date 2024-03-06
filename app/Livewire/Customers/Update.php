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

    public function render(): View
    {
        return view('livewire.customers.update');
    }

    #[On('customer::update')]
    public function load(int $id): void
    {
        $customer = Customer::find($id);
        $this->form->setCustomer($customer);
        $this->resetErrorBag();
        $this->modal = true;
    }

    public function save(): void
    {
        $this->form->update();

        $this->modal = false;
    }
}
