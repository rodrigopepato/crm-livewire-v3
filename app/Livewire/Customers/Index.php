<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\{Attributes\Computed, Component, WithPagination};

/**
 * @property-read LengthAwarePaginator|Customer[] $customers
 * @property-read array $headers
 */
class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public string $sortDirection = 'asc';

    public string $sortColumnBy = 'id';

    public int $perPage = 15;

    public function render(): View
    {
        return view('livewire.customers.index');
    }

    #[Computed]
    public function customers(): LengthAwarePaginator
    {
        return Customer::query()
            ->when($this->search, fn (Builder $q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%"))
            ->orderBy($this->sortColumnBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
            ['key' => 'name', 'label' => 'Name', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
            ['key' => 'email', 'label' => 'Email', 'sortColumnBy' => $this->sortColumnBy, 'sortDirection' => $this->sortDirection],
        ];
    }
}
