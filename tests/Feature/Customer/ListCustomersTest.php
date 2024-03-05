<?php

use App\Livewire\Customers;
use App\Livewire\Customers\Index;
use App\Models\{Customer, User};
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};

it('should be able to access the route customers', function () {

    actingAs(User::factory()->create());

    get(route('customers'))
        ->assertOk();

});

test("let's create a livewire component to list all customers in the page", function () {

    actingAs(User::factory()->create());
    $customers = Customer::factory()->count(10)->create();

    $lw = Livewire::test(Index::class);
    $lw->assertSet('items', function ($items) {
        expect($items)
            ->toHaveCount(10);

        return true;
    });

    foreach ($customers as $user) {
        $lw->assertSee($user->name);
    }
});

test('check the table format', function () {

    actingAs(User::factory()->admin()->create());

    Livewire::test(Customers\Index::class)
        ->assertSet('headers', [
            ['key' => 'id', 'label' => '#', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'name', 'label' => 'Name', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'email', 'label' => 'Email', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
        ]);
});

it('should be able to filter by name and email', function () {

    $user  = User::factory()->create();
    $joe   = Customer::factory()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $mario = Customer::factory()->create(['name' => 'Mario', 'email' => 'little_guy@gmail.com']);

    actingAs($user);

    Livewire::test(Customers\Index::class)
        ->assertSet('items', function ($items) {
            expect($items)->toHaveCount(2);

            return true;
        })
        ->set('search', 'mar')
        ->assertPropertyWired('search')
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1)
                ->first()->name->toBe('Mario');

            return true;
        })
        ->set('search', 'guy')
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1)
                ->first()->name->toBe('Mario');

            return true;
        });
});

it('should be able to sort by name', function () {

    $user  = User::factory()->create();
    $joe   = Customer::factory()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $mario = Customer::factory()->create(['name' => 'Mario', 'email' => 'little_guy@gmail.com']);

    actingAs($user);

    Livewire::test(Customers\Index::class)
        ->set('sortDirection', 'asc')
        ->set('sortColumnBy', 'name')
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->name->toBe('Joe Doe')
                ->and($items)->last()->name->toBe('Mario');

            return true;
        })
        ->set('sortDirection', 'desc')
        ->set('sortColumnBy', 'name')
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->name->toBe('Mario')
                ->and($items)->last()->name->toBe('Joe Doe');

            return true;
        });
});

it('should be able to paginate the result', function () {

    $user = User::factory()->create();
    Customer::factory()->count(30)->create();

    actingAs($user);

    Livewire::test(Customers\Index::class)
        ->assertSet('items', function (LengthAwarePaginator $items) {
            expect($items)
                ->toHaveCount(15);

            return true;
        })
        ->set('perPage', 20)
        ->assertPropertyWired('perPage')
        ->assertSet('items', function (LengthAwarePaginator $items) {
            expect($items)
                ->toHaveCount(20);

            return true;
        });
});
