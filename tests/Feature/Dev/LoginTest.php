<?php

use App\Livewire\Dev\Login;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, assertAuthenticatedAs, get};

it('should be able to list all users of the system', function () {

    User::factory()->count(10)->create();

    $users = User::all();

    Livewire::test(Login::class)
        ->assertSet('users', $users)
        ->assertSee($users->first()->name);

});

it('should be able to login with any user', function () {

    $user = User::factory()->create();

    Livewire::test(Login::class)
        ->set('selectedUser', $user->id)
        ->call('login')
        ->assertMethodWired('login')
        ->assertRedirect(route('dashboard'));

    assertAuthenticatedAs($user);

});

it('should not load the livewire component on production environment', function () {

    $user = User::factory()->create();

    app()->detectEnvironment(fn () => 'production');

    actingAs($user);

    get(route('dashboard')) // app.blade.php
        ->assertDontSeeLivewire('dev.login');

    get(route('login')) // guest.blade.php
        ->assertDontSeeLivewire('dev.login');

});

it('should load the livewire component on non production environments', function () {

    $user = User::factory()->create();

    app()->detectEnvironment(fn () => 'local');

    actingAs($user);

    get(route('dashboard')) // app.blade.php
        ->assertSeeLivewire('dev.login');

    get(route('login')) // guest.blade.php
        ->assertSeeLivewire('dev.login');

});
