<?php

use App\Livewire\Customers;
use App\Models\Customer;
use Livewire\Livewire;

use function Pest\Laravel\assertNotSoftDeleted;

it('should be able to restore a customer', function () {
    $customer = Customer::factory()->deleted()->create();

    Livewire::test(Customers\Restore::class)
        ->set('customer', $customer)
        ->call('restore');

    assertNotSoftDeleted('customers', [
        'id' => $customer->id,
    ]);
});

test('when confirming we should load the customer and set modal to true', function () {
    $customer = Customer::factory()->deleted()->create();

    Livewire::test(Customers\Restore::class)
        ->call('confirmAction', $customer->id)
        ->assertSet('customer.id', $customer->id)
        ->assertSet('modal', true);
});

test('after restoring we should dispatch an event to tell the list to reload', function () {
    $customer = Customer::factory()->deleted()->create();

    Livewire::test(Customers\Restore::class)
        ->set('customer', $customer)
        ->call('restore')
        ->assertDispatched('customer::reload');
});

test('after restoring we should close the modal', function () {
    $customer = Customer::factory()->deleted()->create();

    Livewire::test(Customers\Restore::class)
        ->set('customer', $customer)
        ->call('restore')
        ->assertSet('modal', false);
});
