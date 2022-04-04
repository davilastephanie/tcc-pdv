<?php

namespace App\Models;

use App\Traits\SubcategoryTrait;

class SubcategoryModel extends Model
{
    use SubcategoryTrait;

    /**
     * Eloquent ORM
     *
     * https://laravel.com/docs/7.x/eloquent
     */

    protected $table = 'subcategories';

    protected $fillable = [
        'category_id',
        'name',
        'active',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'name'        => 'string',
        'active'      => 'boolean',
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

    public function products()
    {
        return $this->hasMany(ProductModel::class, 'subcategory_id', 'id');
    }
}
