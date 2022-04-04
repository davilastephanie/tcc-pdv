<?php

namespace App\Models;

use App\Traits\SupplierTrait;
use Carbon\Carbon;

class SupplierModel extends Model
{
    use SupplierTrait;

    /**
     * Eloquent ORM
     *
     * https://laravel.com/docs/7.x/eloquent
     */

    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'company',
        'cnpj',
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
        'company'      => 'string',
        'cnpj'         => 'string',
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

    /**
     * Relationships
     *
     * https://laravel.com/docs/7.x/eloquent-relationships
     */

    public function state()
    {
        return $this->belongsTo(StateModel::class, 'uf', 'uf');
    }

    public function products()
    {
        return $this->hasMany(ProductModel::class, 'supplier_id', 'id');
    }
}
