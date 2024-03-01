<?php

namespace App\Traits\Livewire;

use App\Support\Table\Header;
use Livewire\Attributes\Computed;

trait HasTable
{
    public ?string $search = null;

    public string $sortDirection = 'asc';

    public string $sortColumnBy = 'id';

    public int $perPage = 15;

    /** @return Header[] */
    abstract public function tableHeaders(): array;

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
}
