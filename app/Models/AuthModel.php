<?php

namespace App\Models;

use App\Mail\PasswordResetMail;
use App\Traits\AuthTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class AuthModel extends Authenticatable
{
    use Notifiable;
    use AuthTrait;

    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'phone',
        'active',
    ];

    public function sendPasswordResetNotification($token)
    {
        Mail::send(new PasswordResetMail($this, $token));
    }
}
