<?php

use App\Livewire\Customers;
use App\Models\{Customer, User};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertDatabaseHas};

beforeEach(function () {
    $user = User::factory()->create();
    actingAs($user);
});

it('should be able to create a customer', function () {

    Livewire::test(Customers\Create::class)
        ->set('name', 'John Doe')
        ->set('email', 'joe@doe.com')
        ->set('phone', '123456789')
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseHas('customers', [
        'name'  => 'John Doe',
        'email' => 'joe@doe.com',
        'phone' => '123456789',
        'type'  => 'customer',
    ]);
});

describe('validations', function () {

    test('name', function ($rule, $value) {

        Livewire::test(Customers\Create::class)
            ->set('name', $value)
            ->call('save')
            ->assertHasErrors(['name' => $rule]);
    })->with([
        'required' => ['required', ''],
        'min'      => ['min', 'Jo'],
        'max'      => ['max', str_repeat('a', 256)],
    ]);

    test('email should be required if we dont have a phone number', function () {

        Livewire::test(Customers\Create::class)
            ->set('email', '')
            ->set('phone', '')
            ->call('save')
            ->assertHasErrors(['email' => 'required_without']);

        Livewire::test(Customers\Create::class)
            ->set('email', '')
            ->set('phone', '1232132')
            ->call('save')
            ->assertHasNoErrors(['email' => 'required_without']);
    });

    test('email should be valid', function () {

        Livewire::test(Customers\Create::class)
            ->set('email', 'invalid-email')
            ->call('save')
            ->assertHasErrors(['email' => 'email']);

        Livewire::test(Customers\Create::class)
            ->set('email', 'joe@doe.com')
            ->call('save')
            ->assertHasNoErrors(['email' => 'email']);
    });

    test('email should be unique', function () {

        Customer::factory()->create(['email' => 'joe@doe.com']);

        Livewire::test(Customers\Create::class)
            ->set('email', 'joe@doe.com')
            ->call('save')
            ->assertHasErrors(['email' => 'unique']);
    });

    test('phone should be required if email is empty', function () {

        Livewire::test(Customers\Create::class)
            ->set('email', '')
            ->set('phone', '')
            ->call('save')
            ->assertHasErrors(['phone' => 'required_without']);

        Livewire::test(Customers\Create::class)
            ->set('email', 'joe@doe.com')
            ->set('phone', '')
            ->call('save')
            ->assertHasNoErrors(['phone' => 'required_without']);
    });

    test('phone should be unique', function () {

        Customer::factory()->create(['phone' => '123456789']);

        Livewire::test(Customers\Create::class)
            ->set('phone', '123456789')
            ->call('save')
            ->assertHasErrors(['phone' => 'unique']);

    });
});
