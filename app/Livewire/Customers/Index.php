<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Support\Table\Header;
use App\Traits\Livewire\HasTable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\{Attributes\Computed, Component, WithPagination};

class Index extends Component
{
    use WithPagination;
    use HasTable;

    public function render(): View
    {
        return view('livewire.customers.index');
    }

    public function query(): Builder
    {
        return Customer::query();
    }

    public function searchColumns(): array
    {
        return ['name', 'email'];
    }

    public function tableHeaders(): array
    {
        return [
            Header::make('id', '#'),
            Header::make('name', 'Name'),
            Header::make('email', 'Email'),
        ];
    }
}
