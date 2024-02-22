<?php

use App\Livewire\Dev\Login;
use App\Models\User;
use Livewire\Livewire;

it('should be able to list all users of the system', function () {

    User::factory()->count(10)->create();

    $users = User::all();

    Livewire::test(Login::class)
        ->assertSet('users', $users)
        ->assertSee($users->first()->name);

});
