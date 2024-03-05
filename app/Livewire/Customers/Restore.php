<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Restore extends Component
{
    public Customer $customer;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.customers.restore');
    }

    #[On('customer::restore')]
    public function confirmAction(int $id): void
    {
        $this->customer = Customer::query()->onlyTrashed()->findOrFail($id);
        $this->modal    = true;
    }

    public function restore(): void
    {
        $this->customer->restore();
        $this->modal = false;
        $this->dispatch('customer::reload')->to('customers.index');
    }
}
