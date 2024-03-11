<?php

namespace App\Livewire\Opportunities;

use App\Models\Opportunity;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    public Form $form;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.opportunities.update');
    }

    #[On('opportunity::update')]
    public function load(int $id): void
    {
        $opportunity = Opportunity::find($id);
        $this->form->setOpportunity($opportunity);

        $this->form->resetErrorBag();
        $this->modal = true;
    }

    public function save(): void
    {
        $this->form->update();

        $this->modal = false;
        $this->dispatch('opportunity::reload')->to('opportunities.index');
    }
}
