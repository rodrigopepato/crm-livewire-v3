<?php

namespace App\Livewire\Admin\Users;

use App\Models\{Can, User};
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\{Builder, Collection};
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read Collection|User[] $users
 * @property-read array $headers
 */
class Index extends Component
{
    public ?string $search = null;

    public function mount(): void
    {

        $this->authorize(Can::BE_AN_ADMIN->value);

    }

    public function render(): View
    {
        return view('livewire.admin.users.index');
    }

    #[Computed()]
    public function users(): Collection
    {
        return User::query()
            ->when(
                $this->search,
                fn (Builder $q) => $q
                    ->where(
                        DB::raw('lower(name)'),
                        'like',
                        '%' . strtolower($this->search) . '%'
                    )
                    ->orWhere(
                        'email',
                        'like',
                        '%' . strtolower($this->search) . '%'
                    )
            )
            ->get();
    }

    #[Computed()]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'permissions', 'label' => 'Permissions'],
        ];
    }
}
