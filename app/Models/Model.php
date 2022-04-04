<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\DB;

class Model extends EloquentModel
{
    protected $perPage = 10;

    /**
     * Accessors & Mutators
     *
     * https://laravel.com/docs/7.x/eloquent-mutators#accessors-and-mutators
     */

    public function getCreatedAtShowAttribute()
    {
        if (!$this->created_at) {
            return null;
        }

        return $this->created_at->format(__('d/m/Y H:i'));
    }

    public function getUpdatedAtShowAttribute()
    {
        if (!$this->updated_at) {
            return null;
        }

        return $this->updated_at->format(__('d/m/Y H:i'));
    }

    /**
     * Query Scopes
     *
     * https://laravel.com/docs/7.x/eloquent#query-scopes
     */

    public function scopeActivated($query, $table = null)
    {
        return $query->where(!empty($table) ? "{$table}.active" : "active", true);
    }

    public function scopeApplyOrderBy($query, $params = null)
    {
        $orderBy = with(new static)->orderBy;

        if (is_array($params)) {
            if (isset($params['order_by'])) {
                $orderBy = $params['order_by'];
            }
        } elseif (!empty($params)) {
            $orderBy = $params;
        }

        if (empty($orderBy)) {
            return $query;
        }

        $column    = ltrim($orderBy, '-');
        $direction = substr($orderBy, 0, 1) === '-' ? 'desc' : 'asc';

        return $query->orderBy($column, $direction);
    }

    public function scopeGetResult($query, $params = null)
    {
        $perPage = isset($params['per_page']) ? $params['per_page'] : null;

        if ($perPage == -1) {
            return $query->get();
        }

        return $query->paginate($perPage);
    }

    /**
     * Extends
     */

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function sqlDebug()
    {
        $queries = DB::getQueryLog();

        foreach ($queries as $query) {
            foreach ($query['bindings'] as $i => $binding) {
                if ($binding instanceof \DateTime) {
                    $value = $binding->format('\'Y-m-d H:i:s\'');
                } else {
                    if (is_bool($binding)) {
                        $binding = $binding ? 1 : 0;
                    }

                    $value = "'$binding'";
                }

                $query['bindings'][$i] = $value;
            }

            $boundSql = str_replace(['%', '?'], ['%%', '%s'], $query['query']);
            $boundSql = vsprintf($boundSql, $query['bindings']);

            echo PHP_EOL . $boundSql . PHP_EOL;
        }

        echo PHP_EOL;

        die('SQL DEBUG ENABLE');
    }
}