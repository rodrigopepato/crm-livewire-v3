<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Archive extends Component
{
    public Customer $customer;
    public function render(): View
    {
        return view('livewire.customers.archive');
    }

    public function archive(): void
    {
        $this->customer->delete();
    }

    #[On('customer::archive')]
    public function confirmAction(int $id): void
    {
        $this->customer = Customer::findOrFail($id);
        $this->archive();
    }

}
