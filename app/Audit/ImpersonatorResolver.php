<?php

namespace App\Audit;

use OwenIt\Auditing\Contracts\{Auditable, Resolver};

class ImpersonatorResolver implements Resolver
{
    public static function resolve(Auditable $auditable)
    {
        return session('impersonator');
    }
}
