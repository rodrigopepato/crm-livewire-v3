<?php

namespace App\Traits\Livewire;

use App\Models\Customer;
use App\Support\Table\Header;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;

/**
 * @property-read LengthAwarePaginator|Customer[] $items
 * @property-read array $headers
 */
trait HasTable
{
    public ?string $search = null;

    public string $sortDirection = 'asc';

    public string $sortColumnBy = 'id';

    public int $perPage = 15;

    /** @return Header[] */
    abstract public function tableHeaders(): array;

    abstract public function query(): Builder;

    abstract public function searchColumns(): array;

    #[Computed]
    public function items(): LengthAwarePaginator
    {
        $query = $this->query();

        /** @phpstan-ignore-next-line */
        $query->search($this->search, $this->searchColumns());

        return $query
            ->orderBy($this->sortColumnBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    #[Computed]
    public function headers(): array
    {
        return collect($this->tableHeaders())
            ->map(function (Header $header) {
                return [
                    'key'           => $header->key,
                    'label'         => $header->label,
                    'sortColumnBy'  => $this->sortColumnBy,
                    'sortDirection' => $this->sortDirection,
                ];
            })->toArray();
    }

    public function sortBy(string $column, string $direction): void
    {
        $this->sortColumnBy  = $column;
        $this->sortDirection = $direction;
    }
}
