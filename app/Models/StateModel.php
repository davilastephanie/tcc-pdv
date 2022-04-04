<?php

namespace App\Models;

use App\Traits\CategoryTrait;

class StateModel extends Model
{
    /**
     * Eloquent ORM
     *
     * https://laravel.com/docs/7.x/eloquent
     */

    protected $table = 'states';

    public static function listHtmlSelect()
    {
        return self::orderBy('name')->pluck('name', 'uf')->toArray();
    }
}
