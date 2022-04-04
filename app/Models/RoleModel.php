<?php

namespace App\Models;

class RoleModel extends Model
{
    /**
     * Eloquent ORM
     *
     * https://laravel.com/docs/7.x/eloquent
     */

    protected $table = 'roles';

    /**
     * Extend
     */

    public static function listHtmlSelect()
    {
        return self::orderBy('name')->pluck('name', 'id')->toArray();
    }
}
