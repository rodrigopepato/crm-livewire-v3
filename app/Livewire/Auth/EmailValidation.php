<?php

namespace App\Livewire\Auth;

use App\Events\SendNewCode;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class EmailValidation extends Component
{
    public ?string $code = null;

    public ?string $sendNewCodeMessage = null;

    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.auth.email-validation');
    }

    public function handle(): void
    {
        $this->reset('sendNewCodeMessage');

        $this->validate([
            'code' => function (string $attribute, mixed $value, Closure $fail) {
                if ($value != auth()->user()->validation_code) {
                    $fail("Invalid code");
                }
            },
        ]);

        /** @var User $user */
        $user                    = auth()->user();
        $user->validation_code   = null;
        $user->email_verified_at = now();
        $user->save();

        $user->notify(new WelcomeNotification());
        $this->redirect(RouteServiceProvider::HOME);
    }

    public function sendNewCode(): void
    {
        SendNewCode::dispatch(
            auth()->user()
        );

        $this->sendNewCodeMessage = 'Code was sent to you. Check your mailbox.';
    }
}
