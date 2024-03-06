<?php

namespace App\Livewire\Customers;

use App\Livewire\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Update extends Component
{
    public Form $form;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.customers.update');
    }

    public function save(): void
    {
        $this->form->update();

        $this->modal = false;
    }
}
