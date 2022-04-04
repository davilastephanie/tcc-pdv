<?php

namespace App\Models;

use App\Traits\CategoryTrait;

class CategoryModel extends Model
{
    use CategoryTrait;

    /**
     * Eloquent ORM
     *
     * https://laravel.com/docs/7.x/eloquent
     */

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'active',
    ];

    protected $casts = [
        'name'   => 'string',
        'active' => 'boolean',
    ];

    /**
     * Relationships
     *
     * https://laravel.com/docs/7.x/eloquent-relationships
     */

    public function products()
    {
        return $this->hasMany(ProductModel::class, 'category_id', 'id');
    }
}
