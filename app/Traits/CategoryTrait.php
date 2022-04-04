<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait CategoryTrait
{
    public static function validation(array $params = [])
    {
        $categoryId = isset($params['id']) ? $params['id'] : null;
        $nameUnique = Rule::unique(self::getTableName(), 'name')->ignore($categoryId);

        return [
            'rules'      => [
                'name'   => ['required', 'string', 'max:190', $nameUnique],
                'active' => ['nullable', 'boolean'],
            ],
            'messages'   => [],
            'attributes' => [
                'name' => 'nome',
            ],
        ];
    }

    public static function requestIntercept(Request $request)
    {
        //
    }

    public static function listAll(array $params = [])
    {
        return (new self)
            ->where(function ($query) use ($params) {
                if (isset($params['search']) && !empty($params['search'])) {
                    $query->where(function ($q) use ($params) {
                        foreach ((new self)->getFillable() as $attr) {
                            $q->orWhere($attr, 'LIKE', "%{$params['search']}%");
                        }
                    });
                }
            })
            ->applyOrderBy($params)
            ->getResult($params);
    }

    public static function listHtmlSelect(array $params = [])
    {
        return (new self)
            ->where(function ($query) use ($params) {
                if (isset($params['active'])) {
                    $query->where('active', $params['active']);
                }
            })
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }
}
