<?php

namespace App\Livewire\Customers;

use App\Livewire\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{On, Rule};
use Livewire\Component;

class Create extends Component
{
    public Form $form;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.customers.create');
    }

    #[On('customer::create')]
    public function open(): void
    {
        $this->resetErrorBag();
        $this->modal = true;
    }

    public function save(): void
    {
        $this->form->create();

        $this->modal = false;
    }
}
