<?php

namespace App\Models;

use App\Models\Role;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Passwords\CanResetPassword as CanPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['registration_index', 'name', 'email', 'password', 'role_id', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, CanPassword, HasUuids;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    protected static function booted(): void
{
    static::updating(function (User $user) {
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    });

    static::updated(function (User $user) {
        if ($user->wasChanged('email')) {
            event(new Registered($user));
        }
    });
}
}
