<?php

use App\Livewire\Opportunities;
use App\Models\{Opportunity, User};
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};

it('should be able to access the route opportunities', function () {

    actingAs(User::factory()->create());

    get(route('opportunities'))
        ->assertOk();
});

test("let's create a livewire component to list all opportunities in the page", function () {

    actingAs(User::factory()->create());
    $opportunities = Opportunity::factory()->count(10)->create();

    $lw = Livewire::test(Opportunities\Index::class);
    $lw->assertSet('items', function ($items) {
        expect($items)
            ->toHaveCount(10);

        return true;
    });

    foreach ($opportunities as $opportunity) {
        $lw->assertSee($opportunity->title);
    }
});

test('check the table format', function () {

    actingAs(User::factory()->admin()->create());

    Livewire::test(Opportunities\Index::class)
        ->assertSet('headers', [
            ['key' => 'id', 'label' => '#', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'title', 'label' => 'Title', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'status', 'label' => 'Status', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
            ['key' => 'amount', 'label' => 'Amount', 'sortColumnBy' => 'id', 'sortDirection' => 'asc'],
        ]);
});

it('should be able to filter by title', function () {

    $user  = User::factory()->create();
    $joe   = Opportunity::factory()->create(['title' => 'Joe Doe']);
    $mario = Opportunity::factory()->create(['title' => 'Mario']);

    actingAs($user);
    Livewire::test(Opportunities\Index::class)
        ->assertSet('items', function ($items) {
            expect($items)->toHaveCount(2);

            return true;
        })
        ->set('search', 'mar')
        ->assertPropertyWired('search')
        ->assertSet('items', function ($items) {
            expect($items)
                ->toHaveCount(1)
                ->first()->title->toBe('Mario');

            return true;
        });
});

it('should be able to sort by title', function () {

    $user  = User::factory()->create();
    $joe   = Opportunity::factory()->create(['title' => 'Joe Doe']);
    $mario = Opportunity::factory()->create(['title' => 'Mario']);

    actingAs($user);
    Livewire::test(Opportunities\Index::class)
        ->set('sortDirection', 'asc')
        ->set('sortColumnBy', 'title')
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->title->toBe('Joe Doe')
                ->and($items)->last()->title->toBe('Mario');

            return true;
        })
        ->set('sortDirection', 'desc')
        ->set('sortColumnBy', 'title')
        ->assertSet('items', function ($items) {
            expect($items)
                ->first()->title->toBe('Mario')
                ->and($items)->last()->title->toBe('Joe Doe');

            return true;
        });
});

it('should be able to paginate the result', function () {

    $user = User::factory()->create();
    Opportunity::factory()->count(30)->create();

    actingAs($user);
    Livewire::test(Opportunities\Index::class)
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
