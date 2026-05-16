<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'phone', 'role', 'profile_picture', 'status', 'is_2fa_enabled', 'two_factor_code', 'two_factor_expires_at', 'verification_code'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /**
     * Default attributes for the model.
     * In MongoDB, 'role' will default to 'client'.
     */
    protected $attributes = [
        'role' => 'client',
        'status' => 'Inactive', // Accounts are inactive by default until verified
        'is_2fa_enabled' => false,
    ];

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            'is_2fa_enabled' => 'boolean',
            'two_factor_expires_at' => 'datetime',
        ];
    }

    /**
     * Get the profile associated with the user.
     * This provides access to extended profile details like bio and address.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
