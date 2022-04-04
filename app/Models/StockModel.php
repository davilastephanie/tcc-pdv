<?php

namespace App\Models;

use App\Traits\StockTrait;

class StockModel extends Model
{
    use StockTrait;

    /**
     * Eloquent ORM
     *
     * https://laravel.com/docs/7.x/eloquent
     */

    protected $table = 'stocks';

    protected $fillable = [
        'product_id',
        'user_id',
        'action',
        'quantity',
        'description',
        'active',
    ];

    protected $casts = [
        'product_id'  => 'integer',
        'user_id'     => 'integer',
        'action'      => 'string',
        'quantity'    => 'integer',
        'description' => 'string',
        'active'      => 'boolean',
    ];

    /**
     * Relationships
     *
     * https://laravel.com/docs/7.x/eloquent-relationships
     */

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

    /**
     * Accessors & Mutators
     *
     * https://laravel.com/docs/7.x/eloquent-mutators#accessors-and-mutators
     */

    public function getActionShowAttribute()
    {
        return self::actions()[$this->action];
    }
}
