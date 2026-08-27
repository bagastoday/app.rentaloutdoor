<?php

namespace App\Models;

use App\Notifications\CustomerResetPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements CanResetPasswordContract
{
    use CanResetPassword;

    protected $fillable = ['name', 'phone', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Override supaya email reset password mengarah ke halaman customer,
     * bukan halaman admin bawaan Breeze.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new CustomerResetPasswordNotification($token));
    }
}