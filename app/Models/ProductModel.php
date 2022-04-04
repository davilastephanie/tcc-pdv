<?php

namespace App\Models;

use App\Traits\ProductTrait;

class ProductModel extends Model
{
    use ProductTrait;

    /**
     * Eloquent ORM
     *
     * https://laravel.com/docs/7.x/eloquent
     */

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'supplier_id',
        'barcode',
        'name',
        'description',
        'image',
        'price',
        'stock',
        'active',
    ];

    protected $casts = [
        'category_id'    => 'integer',
        'subcategory_id' => 'integer',
        'supplier_id' => 'integer',
        'barcode'        => 'string',
        'name'           => 'string',
        'description'    => 'string',
        'image'          => 'string',
        'price'          => 'float',
        'stock'          => 'integer',
        'active'         => 'boolean',
    ];

    /**
     * Relationships
     *
     * https://laravel.com/docs/7.x/eloquent-relationships
     */

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubcategoryModel::class, 'subcategory_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id', 'id');
    }

    public function stocks()
    {
        return $this->hasMany(StockModel::class, 'product_id', 'id');
    }

    public function orders()
    {
        return $this->belongsToMany(ProductModel::class, 'orders_products', 'order_id', 'product_id')
            ->withPivot('price', 'quantity', 'total')
            ->withTimestamps();
    }

    public function chargebacks()
    {
        return $this->hasMany(ChargebackModel::class, 'product_id', 'id');
    }

    /**
     * Accessors & Mutators
     *
     * https://laravel.com/docs/7.x/eloquent-mutators#accessors-and-mutators
     */

    public function getImageShowAttribute()
    {
        if (empty($this->image)) {
            $this->image = 'img/150x150.jpg';
        }

        return url($this->image);
    }

    public function getPriceShowAttribute()
    {
        return number_format($this->price, 2, ',', '.');
    }

    public function getPivotPriceShowAttribute()
    {
        return number_format($this->pivot->price, 2, ',', '.');
    }

    public function getPivotTotalShowAttribute()
    {
        return number_format($this->pivot->total, 2, ',', '.');
    }
}
