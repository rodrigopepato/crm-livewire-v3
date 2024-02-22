<?php

use App\Livewire\Admin\Users\{Impersonate, StopImpersonate};
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};
use function PHPUnit\Framework\{assertSame, assertTrue};

it('should add a key impersonate to the session with the given user', function () {

    $admin = User::factory()->admin()->create();
    $user  = User::factory()->create();

    actingAs($admin);

    Livewire::test(Impersonate::class)
        ->call('impersonate', $user->id);

    assertTrue(session()->has('impersonate'));
    assertTrue(session()->has('impersonator'));

    assertSame(session()->get('impersonate'), $user->id);
    assertSame(session()->get('impersonator'), $admin->id);

});

it('should make sure that we are logged with the impersonated user', function () {

    $admin = User::factory()->admin()->create();
    $user  = User::factory()->create();

    actingAs($admin);

    expect(auth()->id())->toBe($admin->id);

    Livewire::test(Impersonate::class)
        ->call('impersonate', $user->id)
        ->assertRedirect(route('dashboard'));

    get(route('dashboard'))
        ->assertSee(__("You're impersonating :name, click here to stop the impersonation.", ['name' => $user->name]));

    expect(auth()->id())->toBe($user->id);

});

it('should be able to stop impersonation', function () {

    $admin = User::factory()->admin()->create();
    $user  = User::factory()->create();

    actingAs($admin);

    expect(auth()->id())->toBe($admin->id);

    Livewire::test(Impersonate::class)
        ->call('impersonate', $user->id)
        ->assertRedirect(route('dashboard'));

    Livewire::test(StopImpersonate::class)
        ->call('stop')
        ->assertRedirect(route('admin.users'));

    expect(session('impersonate'))->toBeNull();

    get(route('dashboard'))
        ->assertDontSee(__("You're impersonating :name, click here to stop the impersonation.", ['name' => $user->name]));

    expect(auth()->user()->id)->toBe($admin->id);
});

it('should have the correct permission to impersonate someone', function () {

    $admin    = User::factory()->admin()->create();
    $nonAdmin = User::factory()->create();
    $user     = User::factory()->create();

    actingAs($nonAdmin);

    Livewire::test(Impersonate::class)
        ->call('impersonate', $user->id)
        ->assertForbidden();

    actingAs($admin);

    Livewire::test(Impersonate::class)
        ->call('impersonate', $user->id)
        ->assertRedirect();

});

it('should not be possible to impersonate myself', function () {

    $admin = User::factory()->admin()->create();

    actingAs($admin);

    Livewire::test(Impersonate::class)
        ->call('impersonate', $admin->id);

})->throws(Exception::class);
