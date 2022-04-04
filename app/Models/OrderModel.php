<?php

namespace App\Models;

use App\Traits\OrderTrait;

class OrderModel extends Model
{
    use OrderTrait;

    /**
     * Eloquent ORM
     *
     * https://laravel.com/docs/7.x/eloquent
     */

    protected $table = 'orders';

    protected $fillable = [
        'client_id',
        'user_id',
        'total',
        'payment_type',
        'status',
        'active',
    ];

    protected $casts = [
        'client_id'    => 'integer',
        'user_id'      => 'integer',
        'total'        => 'float',
        'payment_type' => 'string',
        'status'       => 'string',
        'active'       => 'boolean',
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

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(ProductModel::class, 'orders_products', 'order_id', 'product_id')
            ->withPivot('price', 'quantity', 'total')
            ->withTimestamps();
    }

    /**
     * Accessors & Mutators
     *
     * https://laravel.com/docs/7.x/eloquent-mutators#accessors-and-mutators
     */

    public function getIdShowAttribute()
    {
        return str_pad($this->id, 10, '0', STR_PAD_LEFT);
    }

    public function getTotalShowAttribute()
    {
        return number_format($this->total, 2, ',', '.');
    }

    public function getPaymentTypeShowAttribute()
    {
        if (empty($this->payment_type)) {
            return '-';
        }

        return self::paymentTypes()[$this->payment_type];
    }

    public function getStatusShowAttribute()
    {
        return self::status()[$this->status];
    }

    public function getStatusHtmlAttribute()
    {
        $text  = self::status()[$this->status];
        $color = self::statusByColor()[$this->status];

        return "<span class='badge badge-pill badge-{$color}'>{$text}</span>";
    }
}
