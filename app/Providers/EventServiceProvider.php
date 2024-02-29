<?php

namespace App\Providers;

use App\Events\SendNewCode;
use App\Listeners\Auth\CreateValidationCode;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            CreateValidationCode::class,
        ],
        SendNewCode::class => [
            CreateValidationCode::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
