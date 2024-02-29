<?php

use App\Listeners\Auth\CreateValidationCode;
use App\Livewire\Auth\Register;
use App\Models\User;
use App\Notifications\Auth\ValidationCodeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\{Event, Notification};
use Livewire\Livewire;

use function PHPUnit\Framework\assertTrue;

beforeEach(function () {
    Notification::fake();
});

describe('after registration', function () {

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

        $user = User::factory()->create(['email_verified_at' => null, 'validation_code' => null]);

        $event    = new Registered($user);
        $listener = new CreateValidationCode();
        $listener->handle($event);

        Notification::assertSentTo($user, ValidationCodeNotification::class);
    });

    test('making sure that the listener to send the code is linked to the Registered event', function () {

        Event::fake();
        Event::assertListening(
            Registered::class,
            CreateValidationCode::class
        );
    });

});

describe('validation page', function () {

    it('should redirect to the validation page after registration', function () {
        Livewire::test(Register::class)
            ->set('name', 'Joe doe')
            ->set('email', 'joe@doe.com')
            ->set('email_confirmation', 'joe@doe.com')
            ->set('password', 'password')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect(route('auth.email-validation'));
    });

});
