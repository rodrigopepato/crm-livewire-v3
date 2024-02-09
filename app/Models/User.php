<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function permissions(): BelongsToMany
    {

        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(string $key): void
    {

        $this->permissions()->firstOrCreate(compact('key'));
    }

    public function hasPermissionTo(string $key): bool
    {

        return $this->permissions()->where(compact('key'))->exists();
    }
}
