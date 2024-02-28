<?php

use App\Listeners\Auth\CreateValidationCode;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

use function PHPUnit\Framework\assertTrue;

it("should create a new validation code and save in the users table", function () {
    $user = User::factory()->create(['email_verified_at' => null, 'validation_code' => null]);

    $event    = new Registered($user);
    $listener = new CreateValidationCode();
    $listener->handle($event);

    $user->refresh();

    expect($user)->validation_code->not->toBeNull()
        ->and($user)->validation_code->toBeNumeric();

    assertTrue(str($user->validation_code)->length() == 6);

});

it('should send that new code to the user via email', function () {

})->todo();

test('making sure that the listener to send the code is linked to the Registered event', function () {

})->todo();
