<?php

namespace App\Traits\Models;

use App\Models\{Can, Permission};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

trait HasPermissions
{
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
    public function givePermissionTo(Can|string $key): void
    {
        $pKey = $key instanceof Can ? $key->value : $key;
        $this->permissions()->firstOrCreate(['key' => $pKey]);
        Cache::forget($this->getPermissionCacheKey());
        Cache::rememberForever(
            $this->getPermissionCacheKey(),
            fn () => $this->permissions
        );
    }
    public function hasPermissionTo(Can|string $key): bool
    {
        $pKey = $key instanceof Can ? $key->value : $key;

        /** @var Collection $permissions */
        $permissions = Cache::get($this->getPermissionCacheKey(), fn () => $this->permissions);

        return $permissions
            ->where('key', '=', $pKey)
            ->isNotEmpty();
    }
    private function getPermissionCacheKey(): string
    {
        return "user::{$this->id}::permissions";
    }
}
