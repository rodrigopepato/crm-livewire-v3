<?php

namespace App\Livewire\Opportunities;

use App\Models\Opportunity;
use App\Support\Table\Header;
use App\Traits\Livewire\HasTable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;
    use HasTable;

    public bool $search_trash = false;

    #[On('opportunity::reload')]
    public function render(): View
    {
        return view('livewire.opportunities.index');
    }

    public function query(): Builder
    {
        return Opportunity::query()
            ->when($this->search_trash, fn (Builder $q) => $q->onlyTrashed());
    }

    public function searchColumns(): array
    {
        return ['title', 'status', 'amount'];
    }

    public function tableHeaders(): array
    {
        return [
            Header::make('id', '#'),
            Header::make('title', 'Title'),
            Header::make('status', 'Status'),
            Header::make('amount', 'Amount'),
        ];
    }
}
