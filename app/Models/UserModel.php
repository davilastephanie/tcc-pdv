<?php

namespace App\Models;

use App\Traits\UserTrait;
use Illuminate\Support\Facades\Hash;

class UserModel extends Model
{
    use UserTrait;

    /**
     * Eloquent ORM
     *
     * https://laravel.com/docs/7.x/eloquent
     */

    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'phone',
        'active',
    ];

    protected $casts = [
        'role_id'           => 'integer',
        'name'              => 'string',
        'email'             => 'string',
        'email_verified_at' => 'datetime',
        'password'          => 'string',
        'phone'             => 'string',
        'active'            => 'boolean',
    ];

    /**
     * Relationships
     *
     * https://laravel.com/docs/7.x/eloquent-relationships
     */

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id', 'id');
    }

    public function stocks()
    {
        return $this->hasMany(StockModel::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(OrderModel::class, 'user_id', 'id');
    }

    public function chargebacks()
    {
        return $this->hasMany(ChargebackModel::class, 'user_id', 'id');
    }

    /**
     * Accessors & Mutators
     *
     * https://laravel.com/docs/7.x/eloquent-mutators#accessors-and-mutators
     */

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}
