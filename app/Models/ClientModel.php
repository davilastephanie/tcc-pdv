<?php

namespace App\Models;

use App\Traits\ClientTrait;
use Carbon\Carbon;

class ClientModel extends Model
{
    use ClientTrait;

    /**
     * Eloquent ORM
     *
     * https://laravel.com/docs/7.x/eloquent
     */

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'cpf',
        'rg',
        'birthday',
        'email',
        'phone',
        'cep',
        'address',
        'number',
        'neighborhood',
        'city',
        'uf',
        'active',
    ];

    protected $casts = [
        'name'         => 'string',
        'cpf'          => 'string',
        'rg'           => 'string',
        'birthday'     => 'date',
        'email'        => 'string',
        'phone'        => 'string',
        'cep'          => 'string',
        'address'      => 'string',
        'number'       => 'string',
        'neighborhood' => 'string',
        'city'         => 'string',
        'uf'           => 'string',
        'active'       => 'boolean',
    ];

    protected $dates = ['birthday'];

    /**
     * Relationships
     *
     * https://laravel.com/docs/7.x/eloquent-relationships
     */

    public function state()
    {
        return $this->belongsTo(StateModel::class, 'uf', 'uf');
    }

    public function orders()
    {
        return $this->hasMany(OrderModel::class, 'client_id', 'id');
    }

    public function chargebacks()
    {
        return $this->hasMany(ChargebackModel::class, 'client_id', 'id');
    }

    /**
     * Accessors & Mutators
     *
     * https://laravel.com/docs/7.x/eloquent-mutators#accessors-and-mutators
     */

    public function setBirthdayAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['birthday'] = Carbon::createFromFormat('d/m/Y', $value);
        }
    }

    public function getBirthdayAttribute()
    {
        if (empty($this->attributes['birthday'])) {
            return null;
        }

        $this->attributes['birthday'] = Carbon::parse($this->attributes['birthday'])->format('d/m/Y');

        return $this->attributes['birthday'];
    }
}
