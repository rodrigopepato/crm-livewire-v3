<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Livewire\{Attributes\Computed, Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public function render(): View
    {
        return view('livewire.customers.index');
    }

    #[Computed]
    public function customers(): LengthAwarePaginator
    {
        return Customer::query()->paginate();
    }
}
