<?php

namespace App\Models;

use App\Traits\ChargebackTrait;

class ChargebackModel extends Model
{
    use ChargebackTrait;

    /**
     * Eloquent ORM
     *
     * https://laravel.com/docs/7.x/eloquent
     */

    protected $table = 'chargebacks';

    protected $fillable = [
        'client_id',
        'product_id',
        'user_id',
        'quantity',
        'note',
        'active',
    ];

    protected $casts = [
        'client_id'  => 'integer',
        'product_id' => 'integer',
        'user_id'    => 'integer',
        'quantity'   => 'integer',
        'note'       => 'string',
        'active'     => 'boolean',
    ];

    /**
     * Relationships
     *
     * https://laravel.com/docs/7.x/eloquent-relationships
     */

    public function client()
    {
        return $this->belongsTo(ClientModel::class, 'client_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }
}
