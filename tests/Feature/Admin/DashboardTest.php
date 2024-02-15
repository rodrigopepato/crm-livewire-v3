<?php

use App\Livewire\Admin\Dashboard;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};

it('should block access to users without the permission _be an admin_', function () {

    $user = User::factory()->create();

    actingAs($user);

    Livewire::test(Dashboard::class)
        ->assertForbidden();

    get(route('admin.dashboard'))
        ->assertForbidden();

});
